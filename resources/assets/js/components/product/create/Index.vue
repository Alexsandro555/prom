<template>
    <v-flex xs8>
        <v-toolbar color="indigo darken-1" dark tabs>
            <v-tabs slot="extension" left v-model="tabs" slider-color="white" color="transparent">
                <v-tab href="#main" class="subheading">Основные параметры</v-tab>
                <v-tab href="#attributes" class="subheading">Аттрибуты</v-tab>
            </v-tabs>
        </v-toolbar>
        <v-tabs-items v-model="tabs">
            <v-tab-item key="main" :id="'main'">
                <v-card>
                    <v-container fluid grid-list-md>
                        <v-layout row wrap>
                            <v-flex xs2></v-flex>
                            <v-flex xs8 center align-end flexbox>
                                <v-alert v-if="flagAlert" :type="alertType" :value="true">
                                    {{resultMessage}}
                                </v-alert>
                                <div>
                                    <v-form ref="form" lazy-validation v-model="valid">
                                        <p></p>
                                        <v-text-field
                                                name="title"
                                                label="Название продукта"
                                                v-model="form.title"
                                                :rules="titleRules"
                                                :counter="255"
                                                required></v-text-field>
                                        <v-text-field
                                                name="vendor"
                                                label="Артикул"
                                                v-model="form.vendor"
                                                :rules="vendorRules"
                                                :counter="12"
                                        ></v-text-field>
                                        <v-text-field
                                                name="IEC"
                                                label="IEC"
                                                v-model="form.IEC"
                                                :rules="IECRules"
                                                :counter="255"
                                        ></v-text-field>
                                        <v-text-field
                                                name="price"
                                                label="Цена"
                                                v-model="form.price"
                                                :rules="priceRules"
                                                :counter="12"
                                                prefix="₽"
                                                required
                                        ></v-text-field>
                                        <div id="wysiwyg"></div>
                                        <v-text-field
                                                name="qty"
                                                label="Количество"
                                                value="1"
                                                v-model="form.qty"
                                                :rules="qtyRules"
                                                :counter="15"
                                        ></v-text-field>
                                        <v-text-field
                                                name="sort"
                                                label="Сортировка"
                                                value="1"
                                                v-model="form.sort"
                                                :rules="sortRules"
                                        ></v-text-field>
                                        <v-checkbox
                                                label="Скидка"
                                                v-model="form.onsale"></v-checkbox>
                                        <v-checkbox
                                                label="Спецпредложение"
                                                v-model="form.special"></v-checkbox>
                                        <v-checkbox
                                                label="Необходимо заказывать"
                                                v-model="form.need_order"></v-checkbox>
                                        <v-checkbox
                                                label="Активен"
                                                v-model="form.active"></v-checkbox>
                                        <v-select
                                                :items="typeProducts"
                                                v-model="form.type_product_id"
                                                item-text="title"
                                                item-value="id"
                                                label="Тип продукции"
                                                single-line
                                        ></v-select>
                                        <v-select
                                                :items="curTypeProduct.producers"
                                                v-model="form.producer_id"
                                                item-text="title"
                                                item-value="id"
                                                label="Производитель"
                                                single-line
                                        ></v-select>
                                        <v-select
                                                :items="productLines"
                                                v-model="form.producer_type_product_id"
                                                item-text="pivot.name_line"
                                                item-value="pivot.id"
                                                label="Линейка продукции"
                                                single-line
                                        ></v-select>
                                        <v-btn large color="primary" :disabled="!valid" @click.prevent="onSubmit()">Сохранить</v-btn>
                                        <br>
                                        <br>
                                        <v-divider></v-divider>
                                        <!--<uploader url="/files/upload" :element-id="Number(form.id)" :type-files="['image-product']"></uploader>-->
                                        <mas url="/files/upload" :fileable-id="Number(form.id)" :type-files="['image-product']" model="Modules\Catalog\Entities\Product"></mas>
                                    </v-form>
                                </div>
                            </v-flex>
                        </v-layout>
                    </v-container>
                </v-card>
            </v-tab-item>
            <v-tab-item key="attributes" :id="'attributes'">
                <product-attributes :attributes="this.attributes" :id="this.$route.params.id"></product-attributes>
            </v-tab-item>
        </v-tabs-items>
    </v-flex>
</template>
<script>
    import {Form} from '../../form/Form.js'
    import productAttributes from '../attribute';
    import uploader from '../../files';
    import mas from '../../files/mas.vue';
    import vueditor from '../../vueditor/dist/script/vueditor.min.js'
    import '../../vueditor/dist/style/vueditor.min.css'
    import { createNamespacedHelpers } from 'vuex'
    const productModule = createNamespacedHelpers('product')
    //import wysiwyg from '../../wysiwyg'

    export default {
        props: { },
        data: function() {
            return {
                inst: null,
                tabs: null,
                valid: false,
                form: new Form({
                    id: '',
                    title: '',
                    vendor: '',
                    IEC: '',
                    price: '',
                    description: '',
                    qty: '',
                    sort: '',
                    onsale: false,
                    special: false,
                    need_order: false,
                    active: true,
                    type_product_id: null,
                    producer_id: null,
                    producer_type_product_id: null,
                }),
                titleRules: [
                    v => !!v || 'Название продукта обязательно для заполнения',
                    v => v.length <=255 || 'Название продукта должно иметь длину не более 255 символов'
                ],
                vendorRules: [
                    v => v.length <=12 || 'Артикул должен иметь длину не более 12 символов'
                ],
                IECRules: [
                    v => v.length <=255 || 'IEC должен иметь длину не более 255 символов'
                ],
                priceRules: [
                    v => !!v || 'Цена продукта обязательна для заполнения',
                    v => /^[0-9].*$/.test(v) || 'Цена должна содержать только цифры',
                    v => v.length <=12 || 'Цена не может превышать 12 цифр'
                ],
                qtyRules: [
                    v => /^[0-9]*$/.test(v) || 'Количество может содержать только цифры'
                ],
                sortRules: [
                    v => /^[0-9]*$/.test(v) || 'Сорт. может содержать только цифры',
                ],
                originalLinesProduct: [],
                typeProducts: [],
                resultMessage: '',
                flagAlert: false,
                alertType: 'info',
                attributes: []
            }
        },
        components: {
            'product-attributes': productAttributes,
            'uploader': uploader,
            mas,
            //wysiwyg
        },
        watch: {
          '$route' (to, from) {
              this.initial();
          }
        },
        computed: {
          ...productModule.mapState({
              fields: state => state.fields
          }),
          curTypeProduct() {
              return this.originalLinesProduct.filter(item => item.id === this.form.type_product_id)[0] || [];
          },
          productLines() {
            return this.curTypeProduct.producers && this.curTypeProduct.producers.filter(item => item.id === this.form.producer_id) || [];
          }
        },
        created() {
            this.initial();
            this.getAttributes();
        },
        methods: {
            initializeEditor() {
                // инициализация wysiwyg-редактора
                let inst = vueditor.createEditor('#wysiwyg', {
                    uploadUrl: '/files/image-wysiwyg-upload',
                    uploadFile: '/files/upload-file',
                    fileableId: Number(this.form.id),
                    typeFiles: "image-wysiwyg",
                    model: "Modules\Catalog\Entities\Product",
                    id: 'product-wysiwyg',
                    classList: ['product-wysiwyg'],
                });
                inst.setContent(this.form.description);
                this.inst = inst;
            },
            initial() {
                if(this.$route.params.id == -1) {
                    axios.get('/catalog/create', {}).then(response => {
                        this.originalLinesProduct = response.data.typeProducts;
                        response.data.typeProducts.forEach((item)=> {
                            this.typeProducts.push({title: item.title, id: item.id});
                        });
                        for(let key in response.data.defaultProduct) {
                            if(this.form.hasOwnProperty(key) && response.data.defaultProduct[key] !== null) {
                                this.form[key] = response.data.defaultProduct[key];
                            }
                        }
                        this.initializeEditor();
                    }).catch(error => {
                        console.log(error);
                    });
                }
                else {
                    axios.get('/catalog/edit/'+this.$route.params.id, {}).then(response => {
                        this.originalLinesProduct = response.data.typeProducts;
                        response.data.typeProducts.forEach((item)=> {
                            this.typeProducts.push({title: item.title, id: item.id});
                        });
                        for(let key in response.data.product) {
                            if(this.form.hasOwnProperty(key) && response.data.product[key] !== null) {
                                this.form[key] = response.data.product[key];
                            }
                        }
                        this.initializeEditor();
                    }).catch(error => {
                        console.log(error);
                    });
                }
            },
            onSubmit() {
                if(this.$refs.form.validate()) {
                    this.form.description = this.inst.getContent();
                    this.form.submit('post', '/catalog/update').then(data => {
                        if(this.$route.params.id === '-1') {
                            this.$router.push({ name: 'table-products'})
                        }
                        else {
                            for(let key in data.model) {
                                if(this.form.hasOwnProperty(key) && data.model[key] !== null) {
                                    this.form[key] = data.model[key];
                                }
                            }
                            this.flagAlert = true;
                            setTimeout(() => this.flagAlert = false, 2000);
                            this.resultMessage = data.message;
                            this.attributes = [];
                            this.getAttributes();
                        }
                    }).catch(errors => {
                        this.alertType = 'error';
                        this.flagAlert = true;
                        this.resultMessage = 'Ошибка! '+errors;
                    });
                }
                else {
                    return;
                }

            },
            getAttributes() {
                if(this.$route.params.id !== '-1') {
                    axios.get('/catalog/attributes/'+this.$route.params.id, {}).then(response => {
                        let productAttributes = response.data;
                        axios.get('/catalog/attribute-values/'+this.$route.params.id, {}).then(res => {
                            productAttributes.forEach(productAttribute => {
                                let filtered = res.data.filter(item => item["id"] === productAttribute["id"]);
                                this.attributes.push({attribute_id: productAttribute["id"], title: productAttribute["title"], value: filtered.length !== 0? filtered[0]["pivot"]["value"]:""})
                            });
                        }).catch(error => {
                            console.log(error);
                        })
                    }).catch(error => {
                        console.log(error);
                    });
                }
            }
        }
     }
</script>

<style>
    .product-wysiwyg {
        min-height: 350px;
    }
</style>
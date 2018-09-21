<template>
    <v-flex xs8>
        <v-card>
            <v-container fluid grid-list-md>
                <v-layout row wrap>
                    <v-flex xs8 offset-sm1 align-end flexbox>
                        <v-alert v-if="flagAlert" :type="alertType" :value="true">
                            {{resultMessage}}
                        </v-alert>
                        <h1>Привязка атрибутов</h1>
                        <div>
                            <v-form ref="form-attr" lazy-validation v-model="valid">
                                <v-select
                                        :items="typeProducts"
                                        v-model="selTypeProduct"
                                        item-text="title"
                                        item-value="id"
                                        label="Тип продукции"
                                        :rules="typeProductsRules"
                                        single-line
                                        @change="selectTypeProduct"
                                        required
                                ></v-select>
                                <v-select
                                        :items="productLines"
                                        v-model="selLineProduct"
                                        item-text="title"
                                        item-value="id"
                                        label="Линейка продукции"
                                        @change="selectLineProduct"
                                        single-line
                                ></v-select>
                                <v-select
                                        label="Аттрибуты"
                                        :items="attrFiltr"
                                        v-model="selectedFiltr"
                                        multiple
                                        max-height="400"
                                        item-text="title"
                                        item-value="id"
                                        @change="selectAttribute($event)"
                                        persistent-hint
                                        :rules="attrFiltrRules"
                                        required
                                ></v-select>
                                <v-btn large color="primary" :disabled="!valid" @click.stop="onSave()">Сохранить</v-btn>
                            </v-form>
                            <v-flex xs12 sm6 md12>
                                <br>
                                <br>
                            </v-flex>
                            <v-form ref="form-type-prod" lazy-validation v-model="validTP">
                                <v-select
                                        label="Аттрибуты типа продукции"
                                        :items="attrTypeProducts"
                                        v-model="selectedAttrTypeProduct"
                                        multiple
                                        max-height="400"
                                        item-text="title"
                                        item-value="id"
                                        persistent-hint
                                        chips
                                        :rules="attrTypeProductsRules"
                                        required
                                >
                                <template slot="selection" slot-scope="data">
                                    <v-chip
                                            close
                                            @input="data.parent.selectItem(data.item)"
                                            :selected="data.selected"
                                            class="chip--select-multi"
                                            :key="JSON.stringify(data.item)">
                                        {{ data.item.title }}
                                    </v-chip>
                                </template>
                                </v-select>
                                <v-btn large color="primary" :disabled="!validTP" @click.prevent="onRemoveTypeProductAttribute()">Исключить атрибуты</v-btn>
                            </v-form>
                            <v-form ref="form-type-prod" lazy-validation v-model="validLP">
                                <v-flex xs12 sm6 md12>
                                    <br>
                                </v-flex>
                                <v-select
                                        label="Аттрибуты линейки продукции"
                                        :items="attrLineProducts"
                                        v-model="selAttrLineProduct"
                                        multiple
                                        max-height="400"
                                        item-text="title"
                                        item-value="id"
                                        persistent-hint
                                        selected="true"
                                        :rules="attrLineProductsRules"
                                        required
                                        chips>
                                    <template slot="selection" slot-scope="data">
                                        <v-chip
                                                close
                                                @input="data.parent.selectItem(data.item)"
                                                :selected="data.selected"
                                                class="chip--select-multi"
                                                :key="JSON.stringify(data.item)">
                                            {{ data.item.title }}
                                        </v-chip>
                                    </template>
                                </v-select>
                                <v-btn large color="primary" :disabled="!validLP" @click.prevent="onRemoveLineProductAttribute()">Исключить атрибуты</v-btn>
                            </v-form>
                        </div>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-card>
    </v-flex>
</template>
<script>
    export default {
        props: { },
        data: function() {
            return {
                selTypeProduct: null,
                selLineProduct: null,
                valid: false,
                validTP: false,
                validLP: false,
                resultMessage: '',
                flagAlert: false,
                alertType: 'info',
                originalLinesProduct: [],
                typeProducts: [],
                attributes:[],
                selectedAttrTypeProduct: [],
                attrTypeProducts: [],
                attrLineProducts: [],
                attrFiltr: [],
                selectedFiltr: null,
                attrResp: [],
                attrVal: [],
                selAttrLineProduct: [],
                attrTypeProd: [],
                attrLineProd: [],
                typeProductsRules: [
                    v => !!v || 'Должен быть выбран тип продукта',
                ],
                attrFiltrRules:[
                    v => !!v || 'Должен быть выбран хотя бы один атрибут',
                ],
                attrTypeProductsRules: [
                    v => !!v || 'Необходимо выбрать атрибуты для исключения',
                ],
                attrLineProductsRules: [
                    v => !!v || 'Необходимо выбрать атрибуты для исключения',
                ],
                typeProductId: 0,
                lineProductId: 0
            }
        },
        computed: {
            curTypeProduct() {
                return this.originalLinesProduct.filter(item => item.id === this.selTypeProduct)[0] || [];
            },
            productLines() {
                return this.curTypeProduct.line_products || [];
            }
        },
        created() {
            axios.get('/catalog/attribute/lineProducts', {}).then(response => {
                this.originalLinesProduct = response.data;
                response.data.forEach((item) => {
                    this.typeProducts.push({title: item.title, id: item.id});
                });
            }).catch(error => {
                console.log(error);
            });
            axios.get('/catalog/attribute', {}).then(response => {
                response.data.attributes.forEach((item) => {
                    this.attributes.push({id: item.id, title: item.title});
                });
            }).catch(error => {
                console.log(error);
            });
        },
        methods: {
            selectTypeProduct(event) {
                this.selAttrLineProduct = [];
                this.selLineProduct = null;
                if(event === null) return;
                this.typeProductId = event;
                this.lineProductId = 0;
                // Данные для выпадающих списком Тип продукции, Линейка продукции
                axios.get('/catalog/attribute/type-product/'+event, {}).then(response => {
                    this.attrTypeProducts = response.data
                    response.data.forEach(item => {
                       this.selectedAttrTypeProduct.push(item.id)
                    });
                }).catch(error => {
                    console.log(error);
                });
                axios.get('/catalog/attribute/filtered/'+event, {}).then(response => {
                    this.attrFiltr = response.data
                }).catch(error => {
                    console.log(error);
                });
            },
            selectLineProduct(event) {
                if(event === null) return;
                this.lineProductId = event;
                this.typeProductId = 0;
                axios.get('/catalog/attribute/line-product/'+event, {}).then(response => {
                    this.attrLineProducts = response.data
                    response.data.forEach(item => {
                        this.selAttrLineProduct.push(item.id)
                    });
                }).catch(error => {
                    console.log(error);
                });
                axios.get('/catalog/attribute/filtered-line/'+event, {}).then(response => {
                    this.attrFiltr = response.data
                }).catch(error => {
                    console.log(error);
                });
            },
            selectAttribute(event) {
                if(event === null) return;
                this.attrVal = [];
                this.attrResp = [];
                for (let i=0, l = event.length; i<l; i++) {
                    let attribute = {id: event[i]};
                    this.attrResp.push(attribute);
                    this.attrVal.push(attribute);
                }
            },
            selectAttributeTypeProduct(event) {
                this.attrTypeProd = [];
                for (let i=0, l = event.length; i<l; i++) {
                    let attribute = {id: event[i]};
                    this.attrTypeProd.push(attribute);
                }
            },
            selectedAttrLineProduct(event) {
                this.attrLineProd = [];
                for (let i=0, l = event.length; i<l; i++) {
                    let attribute = {id: event[i]};
                    this.attrLineProd.push(attribute);
                }
            },
            onSave() {
                axios.post('/catalog/attribute/save', {attr: this.attrResp, typeProductId: this.typeProductId, lineProductId: this.lineProductId}).then(response => {
                    this.attrResp = [];
                    /*this.selTypeProduct = null;
                    this.selLineProduct = null;
                    this.selectedFiltr = null;*/
                    this.$refs["form-attr"].reset();
                    //this.$router.push('bind-attributes')
                    //location.reload();
                }).catch(error => {
                    console.log(error);
                });
            },
            onRemoveTypeProductAttribute() {
                axios.post("/catalog/attribute/remAttrTypeProd", {attr: this.selectedAttrTypeProduct, type_product_id: this.selTypeProduct}).then(function (response)
                {
                    location.reload();
                }).catch(function (error)
                {
                    console.log(error);
                });
            },
            onRemoveLineProductAttribute() {
                axios.post("/catalog/attribute/remAttrLineProd", {attr: this.selAttrLineProduct, producer_type_product_id: this.selLineProduct}).then(function (response)
                {
                    location.reload();
                }).catch(function (error)
                {
                    console.log(error);
                });
            }
        }
     }
</script>
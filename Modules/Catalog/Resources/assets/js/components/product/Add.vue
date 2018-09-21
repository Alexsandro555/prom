<template>
    <v-container flud grid-list-md>
        <v-layout wrap row>
            <v-progress-circular v-if="loader" indeterminate :size="50" color="primary"></v-progress-circular>
            <v-flex xs8 v-if="!loader" >
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
                                        <div>
                                            <v-form ref="form" lazy-validation v-model="valid">
                                                <template v-for="(field, num) in fields">
                                                    <form-builder :field="field" :num="num" :items="items" @update="updateItem"></form-builder>
                                                </template>
                                                <file-box url="/files/upload" :fileable-id="Number(items.id)" :type-files="typeFiles" :model="model"></file-box>
                                                <v-btn large color="primary" :disabled="!valid" @click.prevent="onSubmit()">Сохранить</v-btn>
                                            </v-form>
                                        </div>
                                    </v-flex>
                                </v-layout>
                            </v-container>
                        </v-card>
                    </v-tab-item>
                    <v-tab-item key="attributes" :id="'attributes'">
                        <product-attributes :attributes="attributes" :id="this.$route.params.id"></product-attributes>
                    </v-tab-item>
                </v-tabs-items>
            </v-flex>
        </v-layout>
    </v-container>
</template>
<script>
    import { createNamespacedHelpers } from 'vuex'
    const module = createNamespacedHelpers('product')
    import formBuilder from '../../../../../../../resources/assets/js/components/form/builder/FormBuilder'
    import fileBox from './../../../../../../../Modules/Files/Resources/assets/js/components/file-box/FileBox'
    import productAttributes from './attributes/Attributes';
    export default {
        props: { },
        data: function() {
            return {
                tabs: null,
                valid: false,
                loader: true
            }
        },
        created() {
            this.setFields()
        },
        mounted() {
            this.getAttributes()
        },
        computed: {
            ...module.mapState({
                fields: state => state.fields,
                items: state => state.items,
                typeFiles: state => state.typeFiles,
                model: state => state.model,
                attributes: state => state.attributes
            }),
        },
        watch: {
            '$route' (to, from) {
                this.initial();
            }
        },
        components: {
            formBuilder,
            fileBox,
            productAttributes
        },
        methods: {
            setFields() {
                this.$store.dispatch('product/setFields').then(response => {
                    this.initial()
                }).catch(error => {})
            },
            initial() {
                if(this.$route.params.id == -1) {
                    this.$store.dispatch('product/create').then(response => {
                        this.loader = false;
                        this.updateRelations()
                    }).catch(error => {})
                } else {
                    this.$store.dispatch('product/update',this.$route.params.id).then(response => {
                        this.loader = false;
                        this.updateRelations()
                    }).catch(error => {})
                }
            },
            updateRelations() {
                this.$store.dispatch('product/updateRelations',this.items.type_product)
            },
            updateItem(obj) {
                this.$store.dispatch('product/updateItem', obj)
            },
            /*...mapActions('product',[
                'updateItem'
            ]),*/
            onSubmit() {
                if(this.$refs.form.validate()) {
                    axios.post('/catalog/update', this.items).then(response => {
                        if(this.$route.params.id === '-1') {
                            this.$router.push({ name: 'table-products'})
                        }
                        else {
                            let data = response.data
                            /*for(let key in data.model) {
                                if(this.form.hasOwnProperty(key) && data.model[key] !== null) {
                                    this.form[key] = data.model[key]
                                }
                            }*/
                            this.$store.dispatch('product/resetAttributes')
                            this.getAttributes()
                        }

                    }).catch(err => {
                            console.log(err)
                    })
                    }
                    else {
                        return;
                    }

            },
            getAttributes() {
                if(this.$route.params.id !== '-1') {
                    this.$store.dispatch('product/attributes',this.$route.params.id)
                }
            }
        }
     }
</script>
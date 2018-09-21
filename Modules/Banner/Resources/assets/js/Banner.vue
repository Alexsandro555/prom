<template>
    <v-flex xs4 offset4>
        <v-card>
            <v-container fluid grid-list-md>
                <v-layout row wrap>
                    <v-flex xs8 offset-xs1>
                        <v-form ref="form" lazy-validation v-model="valid">
                            <v-layout wrap>
                                <v-flex xs12 sm6 md12>
                                    <v-alert v-if="flagAlert" :type="alertType" :value="true">
                                        {{resultMessage}}
                                    </v-alert>
                                    <v-text-field
                                            name="title"
                                            label="Название"
                                            v-model="editedItem.title"
                                            :rules="titleRules"
                                            :counter="255"
                                            required></v-text-field>
                                    <v-text-field
                                        name="description"
                                        label="Описание"
                                        v-model="editedItem.description"
                                        multi-line></v-text-field>
                                </v-flex>
                                <v-btn color="blue darken-1" flat @click.native="save">Сохранить</v-btn>
                            </v-layout>
                        </v-form>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-card><br>
        <v-card v-for="banner in banners" :key="banner.id">
            <v-container fluid grid-list-md>
                <v-layout row wrap>
                    <v-flex xs8 offset-xs1 center align-end flexbox class="text-xs-center">
                        <h2 class="text-xs-left">{{banner.title}}</h2>
                        {{banner.description}}
                        <br>
                        <v-divider></v-divider>
                        <br>
                        <mas url="/files/upload" :fileable-id="banner.id" :type-files="['banner']" model="Modules\Banner\Entities\Banner"></mas>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-card>
    </v-flex>
</template>
<script>
    import mas from '../../../../../resources/assets/js/components/files/mas.vue';
    import {Form} from '../../../../../resources/assets/js/components/form/Form.js'
    export default {
        props: { },
        data: function() {
            return {
                valid: false,
                flagAlert: false,
                alertType: 'info',
                resultMessage: '',
                banners: [],
                editedItem: new Form({
                    title: '',
                    description: '',
                }),
                defaultItem: new Form({
                    title: '',
                    description: ''
                }),
                titleRules: [
                    v => !!v || 'Название обязательно для заполнения',
                    v => v.length <=255 || 'Название должно иметь длину не более 255 символов'
                ],
            }
        },
        created() {
          axios.get('/banner').then(response => {
              this.banners = response.data
          }).catch(err => {

          });
        },
        mounted: function() {
        },
        components: {
            mas
        },
        methods: {
            save() {
                if(this.$refs.form.validate()) {
                    this.editedItem.submit('post', '/banner/save').then(response => {
                        this.resultMessage = response.data.message
                        this.flagAlert = true;
                        setTimeout(() => this.flagAlert = false, 2000);
                        this.$refs.form.reset()
                    }).catch(errors => {
                        console.log(errors);
                    });
                }
            }
        }
    }
</script>
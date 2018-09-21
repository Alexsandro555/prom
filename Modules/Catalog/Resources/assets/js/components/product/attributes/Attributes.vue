<template>
    <div>
        <v-card>
            <v-container fluid grid-list-md>
                <v-layout row wrap>
                    <v-flex xs2></v-flex>
                    <v-flex xs8 align-end flexbox v-if="attributes.lenght !== 0">
                        <br>
                        <div>
                            <v-form ref="form">
                                <p></p>
                                <template v-for="attribute in attributes">
                                    <v-container grid-list-md>
                                        <v-layout col wrap>
                                            <v-flex xs6>
                                                <v-text-field
                                                        :name="attribute.attribute_id"
                                                        v-model="attribute.value"
                                                        :label="attribute.title"
                                                ></v-text-field>
                                            </v-flex>
                                            <v-flex xs6 v-if="groups">
                                                <v-select
                                                        name="group"
                                                        :items="groups"
                                                        v-model="attribute.group_id"
                                                        item-text="title"
                                                        :rules="selectedRules"
                                                        item-value="id"
                                                        label="Группа"
                                                        single-line
                                                ></v-select>
                                            </v-flex>
                                        </v-layout>
                                    </v-container>

                                </template>
                                <v-btn :disabled="!attributes.length>0" large color="primary" @click.prevent="onSave()">Сохранить</v-btn>
                            </v-form>
                        </div>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-card>
    </div>
</template>
<script>
    export default {
        props: {
            attributes: {
                type: Array,
                default: []
            },
            id: {
                type: String,
                required: true
            }
        },
        data: function() {
            return {
                valid: false,
                groups: null,
                selectedRules: [
                    v => this.selectRequired(v),
                ],
            }
        },
        created() {
            axios.get('/catalog/group').then(response => response.data).then(response => {
                this.groups = response
            }).catch(err => {})
        },
        mounted: function() {
        },
        methods: {
            selectRequired(v) {
                return !!v || 'Необходимо выбрать значение'
            },
            onSave() {
                axios.post('/catalog/save-attributes', {data: JSON.stringify(this.attributes), productId: this.id}).then(res => {
                }).catch(error => {
                    console.log(error);
                });
            }
        }
    }
</script>
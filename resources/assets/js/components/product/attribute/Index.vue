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
                                    <v-text-field
                                            :name="attribute.attribute_id"
                                            v-model="attribute.value"
                                            :label="attribute.title"
                                            ></v-text-field>
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
                lastSort: null
            }
        },
        created() {

        },
        mounted: function() {
        },
        methods: {
            onSave() {
                axios.post('/catalog/save-attributes', {data: JSON.stringify(this.attributes), productId: this.id}).then(res => {
                }).catch(error => {
                    console.log(error);
                });
            }
        }
     }
</script>
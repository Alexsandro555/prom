<template>
    <v-container flud grid-list-lg>
        <v-layout row wrap>
            <v-flex xs12>
                <v-card>
                    <v-card-title><h1>Добавление новой группы</h1></v-card-title>
                    <v-card-text>
                        <v-container grid-list-md>
                            <v-layout wrap>
                                <v-flex xs12>
                                    <v-form ref="form" lazy-validation v-model="valid">
                                        <template v-for="(field, num) in fields">
                                            <form-builder :field="field" :num="num" :items="items" @update="updateItem"></form-builder>
                                        </template>
                                    </v-form>
                                </v-flex>
                            </v-layout>
                        </v-container>
                    </v-card-text>
                    <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="blue darken-1" :disabled="false" flat @click.prevent="save()">Сохранить</v-btn>
                    </v-card-actions>
                </v-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>
<script>
    import { mapGetters, mapActions, mapState, mapMutations } from 'vuex'
    import { ACTIONS } from '../../../../../../../resources/assets/js/constants.js'
    import formBuilder from '../../../../../../../resources/assets/js/components/form/builder/FormBuilder.vue'
    export default {
        props: {},
        data: function() {
            return {
                valid: false,
                form: null
            }
        },
        beforeRouteEnter(to, from, next) {
            next(vm => vm.init())
        },
        beforeRouteUpdate(to, from, next) {
            this.init()
            next()
        },
        computed: {
            ...mapState('group', ['items', 'fields']),
            //...mapGetters('validations', { complexMaxLength: VALIDATIONS.COMPLEX_MAX_LENGTH, maxLength: VALIDATIONS.MAX_LENGTH }),
        },
        components: {
          formBuilder
        },
        methods: {
            init() {
                this.setFields()
            },
            ...mapActions('group',{setFields: ACTIONS.SET_FIELDS, updateItem: ACTIONS.UPDATE_ITEM, save: ACTIONS.SAVE_DATA})
        }
     }
</script>
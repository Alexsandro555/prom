<template>
    <div>
        <v-progress-circular v-if="loader" indeterminate :size="50" color="primary"></v-progress-circular>
        <v-data-table v-if="!loader"
                      :headers="headers"
                      :items="items"
                      hide-actions
                      class="elevation-1">
            <template slot="items" slot-scope="props">
                <td>{{ props.item.code }}</td>
                <td class="text-xs-left">{{ props.item.title }}</td>
                <td class="justify-center layout px-0">
                    <v-btn icon class="mx-0" @click="editItem(props.item)">
                        <v-icon color="teal">edit</v-icon>
                    </v-btn>
                </td>
            </template>
            <template slot="no-data">
                <v-alert :value="true" color="error" icon="warning">
                    Извините, нет данных для отображения :(
                </v-alert>
            </template>
        </v-data-table>
        <div class="text-xs-left pt-2">
            <v-dialog  v-model="dialog" max-width="500px">
                <v-btn color="primary" dark slot="activator"  class="text-left mb-2"><v-icon>add</v-icon></v-btn>
                <v-form ref="form" @submit.prevent="save" lazy-validation v-model="valid">
                    <v-card>
                        <v-card-title>
                            <span class="headline">{{ formTitle }}</span>
                        </v-card-title>
                        <v-card-text>
                            <v-container grid-list-md>
                                    <v-layout wrap>
                                        <v-flex xs12 sm6 md12>
                                            <v-text-field
                                                    name="code"
                                                    label="Номер ТНВЭД"
                                                    v-model="code"
                                                    :disabled="editedIndex!==-1"
                                                    :rules="idRules"
                                                    :counter="255"
                                                    :error-messages="messages.code"
                                                    required></v-text-field>
                                            <v-text-field
                                                    name="title"
                                                    label="Названиие"
                                                    v-model="title"
                                                    :rules="titleRules"
                                                    :error-messages="messages.title"
                                                    :counter="255"
                                                    required></v-text-field>
                                            <v-checkbox
                                                    label="Актив."
                                                    v-model="active"
                                                    ></v-checkbox>
                                        </v-flex>
                                    </v-layout>
                            </v-container>
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="blue darken-1" flat @click.native="close">Отмена</v-btn>
                            <v-btn type="submit" :disabled="loading" color="blue darken-1" flat>Сохранить</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-form>
            </v-dialog>
        </div>
    </div>
</template>
<script>
    import { createNamespacedHelpers } from 'vuex'
    const {mapState, mapActions} = createNamespacedHelpers('initializer')

    export default {
        data: function() {
            return {
                code: null,
                title: null,
                active: null,
                dialog: false,
                editedIndex: -1,
                loader: true,
                loading: false,
                headers: [
                    {
                        text: 'Код ТНВЭД',
                        align: 'left',
                        value: 'code'
                    },
                    { text: 'Название', align: 'left', value: 'name_line' },
                    { text: 'Действия', sortable: false}
                ],
                items: [],
                categories: [],
                // Валидация
                valid: false,
                idRules: [
                    v => this.required(v),
                    v => /^[0-9].*$/.test(v) || 'Номер должен содержать только цифры',
                ],
                titleRules: [
                    v => this.required(v),
                    v => v && v.length <=255 || 'Название должно иметь длину не более 255 символов'
                ]
            }
        },
        created() {
            axios.get('/catalog/tnved').then(response => {
                this.loader = false;
                this.items = response.data;
            }).catch(error => {
            });
        },
        computed: {
            ...mapState({
                messages: state => state.messages,
            }),
            formTitle () {
                return this.editedIndex === -1 ? 'Добавление ТНВЭД' : 'Редактирование ТНВЭД'
            }
        },
        methods: {
            ...mapActions([
                'resetError'
            ]),
            required(v) {
                return !!v || 'Обязательно для заполнения'
            },
            editItem (item) {
                this.editedIndex = this.items.indexOf(item)
                this.active = item.active
                this.title = item.title
                this.code = item.code
                this.dialog = true
            },
            deleteItem (item) {
                const index = this.items.indexOf(item)
                if(confirm('Вы уверены что хотите удалить запись?')) {
                    axios.delete('/catalogt/tnved/delete', {data: {code: this.items[index].code}}).then(response => {
                    }).catch(error => {

                    });
                    this.items.splice(index, 1)
                }
            },
            close () {
                this.resetError()
                this.dialog = false
                this.loading = false
                const sort = this.sort
                this.$refs.form.reset()
                this.sort = sort
                setTimeout(() => {
                    this.editedIndex = -1
                }, 300)
                this.loading = false
            },
            save () {
                let data = {
                    code: this.code,
                    title: this.title,
                    active: this.active?this.active:false
                }
                if (this.editedIndex > -1) {
                    if(this.$refs.form.validate()) {
                        this.loading = true
                        Object.assign(this.items[this.editedIndex], data)
                        axios.post('/catalog/tnved/update',data).then(response => {
                            this.$refs.form.reset();
                            this.close()
                            swal('', response.data.message, "success");
                        }).catch(err => {
                            this.valid = false
                        });
                    }
                } else {
                    if(this.$refs.form.validate()) {
                        this.loading = true
                        axios.post('/catalog/tnved/store', data).then(response => {
                            this.items.push(response.data.model)
                            this.loading = false
                            this.close()
                            swal('', response.data.message, "success");
                        }).catch(err => {
                            this.valid = false
                        })
                    }
                }
            }
        }
    }
</script>

<style scoped>
    div {
        text-align: center;
    }

    .progress-circular {
        margin: 1rem;
    }
</style>
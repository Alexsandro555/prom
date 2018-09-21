<template>
    <div>
        <v-progress-circular v-if="loader" indeterminate :size="50" color="primary"></v-progress-circular>
        <v-data-table v-if="!loader"
                      :headers="headers"
                      :items="items"
                      hide-actions
                      class="elevation-1">
            <template slot="items" slot-scope="props">
                <td>{{ props.item.id }}</td>
                <td class="text-xs-left">{{ props.item.title }}</td>
                <td class="text-xs-left">{{ props.item.sort }}</td>
                <td class="justify-center layout px-0">
                    <v-btn icon class="mx-0" @click="editItem(props.item)">
                        <v-icon color="teal">edit</v-icon>
                    </v-btn>
                    <!--<v-btn icon class="mx-0" @click="deleteItem(props.item)">
                        <v-icon color="pink">delete</v-icon>
                    </v-btn>-->
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
            <v-btn color="primary" @click="createItem" dark slot="activator" class="text-left mb-2"><v-icon>add</v-icon></v-btn>
            <v-form ref="form" @submit.prevent="save" lazy-validation v-model="valid">
                <v-card>
                    <v-card-title>
                        <span class="headline">{{ formTitle }}</span>
                    </v-card-title>
                    <v-card-text>
                        <v-container grid-list-md>
                            <v-layout wrap>
                                    <v-flex xs12 sm6 md12>
                                        <v-select
                                                :items="categories"
                                                v-model="category_id"
                                                item-text="title"
                                                item-value="id"
                                                label="Категория"
                                                single-line
                                                :rules="categoryRules"
                                                :error-messages="messages.category_id"
                                                required
                                        ></v-select>
                                    </v-flex>
                                    <v-flex xs12 sm6 md12>
                                        <v-select
                                                :items="tnveds"
                                                v-model="tnved_id"
                                                item-text="title"
                                                item-value="code"
                                                label="ТНВЭД"
                                                :rules="tnvedRules"
                                                :error-messages="messages.tnved_id"
                                                single-line
                                        ></v-select>
                                    </v-flex>
                                    <v-flex xs12 sm6 md12>
                                        <v-text-field
                                                name="title"
                                                label="Наименование типа продукции"
                                                v-model="title"
                                                :rules="titleRules"
                                                :counter="255"
                                                :error-messages="messages.title"
                                                required></v-text-field>
                                    </v-flex>
                                    <v-flex xs12 sm6 md12>
                                        <v-text-field
                                                name="url_key"
                                                label="Url-адрес"
                                                v-model="url_key"
                                                :rules="urlRules"
                                                :counter="255"
                                                :error-messages="messages.url_key"
                                                required>
                                        </v-text-field>
                                    </v-flex>
                                    <v-flex xs12 sm6 md12>
                                        <v-text-field
                                                name="description"
                                                label="Описание"
                                                v-model="description"
                                                multi-line></v-text-field>
                                    </v-flex>
                                    <v-flex xs12 sm6 md12>
                                        <v-text-field
                                                name="sort"
                                                label="Сорт."
                                                v-model="sort"
                                                :rules="sortRules"
                                                :error-messages="messages.sort"
                                                required
                                        ></v-text-field>
                                    </v-flex>
                            </v-layout>
                        </v-container>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="blue darken-1" flat @click.native="close">Отмена</v-btn>
                        <v-btn color="blue darken-1" flat :disabled="loading" type="submit">Сохранить</v-btn>
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
                id: null,
                title: null,
                sort: null,
                lastSort: null,
                url_key: null,
                tnved_id: null,
                category_id: null,
                description: null,
                dialog: false,
                editedIndex: -1,
                loader: true,
                categories: [],
                tnveds: [],
                headers: [
                    {
                        text: '#',
                        align: 'left',
                        sortable: false,
                        value: 'id'
                    },
                    { text: 'Название', align: 'left', value: 'title' },
                    { text: 'Сорт', value: 'sort' },
                    { text: 'Действия', sortable: false}
                ],
                items: [],
                loading: false,
                // Валидация
                valid: false,
                titleRules: [
                    v => this.required(v),
                    v => v && v.length <=255 || 'Название типа продукта должно иметь длину не более 255 символов'
                ],
                urlRules: [
                    v => this.required(v),
                    v => this.checkUrl(v)
                ],
                categoryRules: [
                    v => this.selectRequired(v),
                ],
                tnvedRules: [
                    v => this.selectRequired(v),
                ],
                sortRules: [
                    v => this.required(v),
                    v => this.checkUrl(v),
                ]
            }
        },
        created() {
            axios.get('/catalog/type-product', {}).then(response => {
                this.loader = false;
                this.items = response.data.typeProducts;
                this.tnveds = response.data.tnveds;
                this.categories = response.data.categories;
                this.lastSort = response.data.sort+1;
            }).catch(error => {
            });
        },
        computed: {
            ...mapState({
                messages: state => state.messages,
            }),
            formTitle () {
                return this.editedIndex === -1 ? 'Добавление нового типа продукта' : 'Редактирование типа продукта'
            }
        },
        methods: {
            ...mapActions([
                'resetError'
            ]),
            required(v) {
                return !!v || 'Обязательно для заполнения'
            },
            selectRequired(v) {
                return !!v || 'Необходимо выбрать значение'
            },
            checkUrl(v) {
                let regexp = /^[a-z0-9-]+$/
                return regexp.test(v)?true:'Неправильный формат url-адреса'
            },
            editItem (item) {
                this.editedIndex = this.items.indexOf(item)
                this.id = item.id
                this.title = item.title
                this.sort = item.sort
                this.url_key = item.url_key
                this.description = item.description
                this.category_id = item.category_id
                this.tnved_id = item.tnved_id
                this.dialog = true
            },
            createItem() {
                this.editedIndex = -1
                this.sort = this.lastSort
            },
            deleteItem (item) {
                const index = this.items.indexOf(item)
                if(confirm('Вы уверены что хотите удалить запись?')) {
                    axios.delete('/catalog/type-product/delete', {data: {id: this.items[index].id}}).then(response => {
                        swal('', response.data.message, "success");
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
            },
            save () {
                let data = {
                    id: this.id,
                    title: this.title,
                    description: this.description,
                    category_id: this.category_id,
                    tnved_id: this.tnved_id,
                    url_key: this.url_key,
                    sort: this.sort
                }
                if (this.editedIndex > -1) {
                    if(this.$refs.form.validate()) {
                        this.loading = true
                        Object.assign(this.items[this.editedIndex], data)
                        axios.post('/catalog/type-product/update',data).then(response => {
                            this.loading = true
                            this.$refs.form.reset();
                            this.close()
                            //swal('', response.data.message, "success");
                        }).catch(err => {
                            this.valid = false
                        });
                    }
                } else {
                    if(this.$refs.form.validate()) {
                        this.loading = true
                        axios.post('/catalog/type-product/store', data).then(response => {
                            this.items.push(response.data.model)
                            this.loading = false
                            this.lastSort = this.lastSort+1;
                            this.close()
                        }).catch(err => {
                            this.valid = false
                        });
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
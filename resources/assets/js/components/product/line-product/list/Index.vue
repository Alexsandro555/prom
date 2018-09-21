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
            <v-btn color="primary" dark slot="activator" @click="createItem" class="text-left mb-2"><v-icon>add</v-icon></v-btn>
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
                                                :items="typeProducts"
                                                v-model="type_product_id"
                                                item-text="title"
                                                item-value="id"
                                                label="Тип продукции"
                                                :rules="selectedRules"
                                                :error-messages="messages.type_product_id"
                                                single-line
                                        ></v-select>
                                    </v-flex>
                                    <v-flex xs12 sm6 md12>
                                        <v-select
                                                :items="producers"
                                                v-model="producer_id"
                                                item-text="title"
                                                item-value="id"
                                                label="Производитель"
                                                :rules="selectedRules"
                                                :error-messages="messages.producer_id"
                                                single-line
                                        ></v-select>
                                    </v-flex>
                                    <v-flex xs12 sm6 md12>
                                        <v-text-field
                                                name="title"
                                                label="Наименование линейки продукции"
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
                        <v-btn color="blue darken-1" :disabled="loading" flat type="submit">Сохранить</v-btn>
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
                type_product_id: null,
                producer_id: null,
                title: null,
                sort: null,
                dialog: false,
                editedIndex: -1,
                url_key: null,
                loader: true,
                typeProducts: [],
                producers: [],
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
                lastSort: null,
                items: [],
                loading: false,
                // валидация
                valid: false,
                titleRules: [
                    v => this.required(v),
                    v => v && v.length <=255 || 'Наименование линейки продукта должно иметь длину не более 255 символов'
                ],
                urlRules: [
                    v => this.required(v),
                    v => this.checkUrl(v)
                ],
                selectedRules: [
                    v => this.selectRequired(v),
                ],
                sortRules: [
                    v => this.required(v),
                ]
            }
        },
        created() {
            axios.get('/catalog/line-product', {}).then(response => {
                this.loader = false;
                this.items = response.data.lineProducts;
                this.typeProducts = response.data.typeProducts;
                this.producers = response.data.producers;
                this.lastSort = response.data.sort+1;
            }).catch(error => {});
        },
        computed: {
            ...mapState({
                messages: state => state.messages,
            }),
            formTitle () {
                return this.editedIndex === -1 ? 'Добавление линейки' : 'Редактирование линейки'
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
                this.type_product_id = item.type_product_id
                console.log(item.url_key)
                this.url_key = item.url_key
                this.producer_id = item.producer_id
                this.dialog = true
            },
            createItem() {
                this.editedIndex = -1
                this.sort = this.lastSort
            },
            deleteItem (item) {
                const index = this.items.indexOf(item)
                if(confirm('Вы уверены что хотите удалить запись?')) {
                    axios.delete('/catalog/line-product/delete', {data: {id: this.items[index].id}}).then(response => {
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
                    type_product_id: this.type_product_id,
                    producer_id: this.producer_id,
                    url_key: this.url_key,
                    sort: this.sort
                }
                if (this.editedIndex > -1) {
                    if(this.$refs.form.validate()) {
                        this.loading = true
                        Object.assign(this.items[this.editedIndex], data)
                        axios.post('/catalog/line-product/update',data).then(response => {
                            this.loading = true
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
                        axios.post('/catalog/line-product/store', data).then(response => {
                            this.items.push(response.data.model)
                            this.loading = false
                            this.lastSort = this.lastSort+1;
                            this.close()
                            swal('', response.data.message, "success");
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
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
                                            <v-text-field
                                                    name="title"
                                                    label="Наименование категории"
                                                    v-model="title"
                                                    :rules="titleRules"
                                                    :counter="255"
                                                    :error-messages="messages.title"
                                                    required></v-text-field>
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
                                <v-flex xs12>
                                    <!--<mas v-if="id" url="/files/upload" :fileable-id="Number(id)" :type-files="['image-product']" model="Modules\Catalog\Entities\Catalog"></mas>-->
                                </v-flex>
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
    import mas from '../../../files/mas.vue';
    import { createNamespacedHelpers } from 'vuex'

    const {mapState, mapActions} = createNamespacedHelpers('initializer')

    export default {
        data: function() {
            return {
                id: null,
                title: null,
                description: null,
                sort: null,
                lastSort: null,
                dialog: false,
                editedIndex: -1,
                loader: true,
                loading: false,
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
                // Валидация
                valid: false,
                titleRules: [
                    v => this.required(v),
                    v => v && v.length <=255 || 'Наименование должно иметь длину не более 255 символов'
                ],
                sortRules: [
                    v => this.required(v),
                ]
            }
        },
        created() {
            axios.get('/catalog/categories', {}).then(response => {
                this.loader = false;
                this.items = response.data.categories;
                this.lastSort = response.data.sort+1;
            }).catch(error => {});
        },
        computed: {
            ...mapState({
                messages: state => state.messages,
            }),
            formTitle () {
                return this.editedIndex === -1 ? 'Добавление новой категории' : 'Редактирование категории'
            }
        },
        components: {
          mas
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
                this.id = item.id
                this.title = item.title
                this.sort = item.sort
                this.description = item.description
                this.dialog = true
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
            createItem() {
                this.editedIndex = -1
                this.sort = this.lastSort
            },
            save () {
                let data = {
                    id: this.id,
                    title: this.title,
                    sort: this.sort
                }
                if(this.editedIndex > -1) {
                    if(this.$refs.form.validate()) {
                        this.loading = true
                        Object.assign(this.items[this.editedIndex], data)
                        axios.post('/catalog/category/update',data).then(response => {
                            this.loading = false
                            this.$refs.form.reset();
                            this.close()
                            swal('', response.data.message, "success");
                        }).catch(err => {
                            this.valid = false
                        });
                    }
                }
                else {
                    if(this.$refs.form.validate()) {
                        this.loading = true
                        axios.post('/catalog/category/store', data).then(response => {
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
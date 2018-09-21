<template>
    <div>
        <v-progress-circular v-if="loader" indeterminate :size="50" color="primary"></v-progress-circular>
        <v-card v-if="!loader">
            <v-card-title>
                Продукты
                <v-spacer></v-spacer>
                <v-text-field
                        v-model="search"
                        append-icon="search"
                        label="Поиск"
                        single-line
                        hide-details
                ></v-text-field>
            </v-card-title>
            <v-data-table v-if="!loader"
                :headers="headers"
                :items="items"
                :search="search"
                class="elevation-1">
            <template slot="items" slot-scope="props">
                <td>{{ props.item.id }}</td>
                <td class="text-xs-left">{{ props.item.title }}</td>
                <td class="text-xs-left">
                    <v-btn @click="goToPage(props.item.url_key)" color="yellow">
                        <v-icon>find_in_page</v-icon>
                    </v-btn>
                </td>
                <td class="text-xs-left">{{ props.item.price }}</td>
                <td class="justify-center layout px-0">
                    <v-btn icon class="mx-0" @click="$router.push('/update-product/'+props.item.id)">
                        <v-icon color="teal">edit</v-icon>
                    </v-btn>
                    <v-btn :disabled="props.item.url_key === 'po-umolchaniyu'" icon class="mx-0" @click="deleteItem(props.item)">
                        <v-icon color="pink">delete</v-icon>
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
                <router-link to="/update-product/-1">
                    <v-btn color="primary" dark class="text-left mb-2"><v-icon>add</v-icon></v-btn>
                </router-link>
            </div>
        </v-card>
    </div>
</template>
<script>
    export default {
        props: { },
        data: function() {
            return {
                loader: true,
                headers: [
                    {
                        text: '#',
                        align: 'left',
                        sortable: true,
                        value: 'id'
                    },
                    { text: 'Название', value: 'title' },
                    { text: 'Путь', value: 'url_key' },
                    { text: 'Цена (руб.)', value: 'price' },
                    { text: 'Действия', value: 'title', sortable: false}
                ],
                items: [],
                search: '',
                //pagination: {},
            }
        },
        created() {
            axios.get('/catalog/', {}).then(response => {
                this.loader = false;
                this.items = response.data;
            }).catch(error => {

            });
        },
        /*computed: {
            pages () {
                if (this.pagination.rowsPerPage == null ||
                    this.pagination.totalItems == null
                ) return 0

                return Math.ceil(this.pagination.totalItems / this.pagination.rowsPerPage)
            }
        },*/
        mounted: function() {
        },
        methods: {
            deleteItem (item) {
                const index = this.items.indexOf(item)
                if(confirm('Вы уверены что хотите удалить запись?')) {
                    axios.delete('/catalog/delete', {data: {id: this.items[index].id}}).then(response => {
                    }).catch(error => {});
                    this.items.splice(index, 1)
                }
            },
            goToPage( url ) {
                document.location.href = '/'+url
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
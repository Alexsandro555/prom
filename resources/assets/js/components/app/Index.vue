<template>
    <v-app id="inspire">
        <v-navigation-drawer clipped class="gray lighten-4" app v-model="drawer" >
            <v-list dense class="gray lighten-4">
                <template v-for="(item, i) in items">
                    <v-layout row v-if="item.heading" align-center :key="i">
                        <v-flex xs6>
                            <v-subheader v-if="item.heading">
                                {{item.heading}}
                            </v-subheader>
                        </v-flex>
                        <v-flex xs6 class="text-xs-right">
                            <!--<v-btn small flat>edit</v-btn>-->
                        </v-flex>
                    </v-layout>
                    <v-divider dark v-else-if="item.divider" class="my-3" :key="i"></v-divider>
                    <v-list-tile v-else :key="i" @click="select(item.path)" >
                        <v-list-tile-action>
                            <v-icon>{{ item.icon }}</v-icon>
                        </v-list-tile-action>
                        <v-list-tile-content>
                            <v-list-tile-title class="grey--text">
                                {{item.text}}
                            </v-list-tile-title>
                        </v-list-tile-content>
                    </v-list-tile>
                </template>
            </v-list>
        </v-navigation-drawer>
        <v-toolbar dark color="indigo darken-1" app absolute clipped-left>
            <v-toolbar-side-icon @click.native="drawer = !drawer"></v-toolbar-side-icon>
            <span class="title ml-3 mr-5" @click="goMainPage()">Лидер</span>
            <v-text-field solo-inverted flat label="Поиск" prepend-icon="search"></v-text-field>
            <v-btn light @click.stop="exit">Выход</v-btn>
            <v-spacer></v-spacer>
        </v-toolbar>
        <v-content>
            <v-container fluid fill-height class="gery lighten-4">
                <v-layout justify-center align-center>
                    <router-view></router-view>
                </v-layout>
            </v-container>
        </v-content>
    </v-app>
</template>
<script>
    export default {
        props: { },
        data: function() {
            return {
                drawer: null,
                items: [
                    { divider: true },
                    { heading: 'Действия' },
                    {
                        text: 'Продукция',
                        path: '/'
                    },
                    {
                        text: 'Категории',
                        path: '/categories'
                    },
                    {
                        text: 'ТНВЭД',
                        path: '/tnved'
                    },
                    {
                        text: 'Типы продуктов',
                        path: '/list-type-products'
                    },
                    {
                        text: 'Производители',
                        path: '/list-producers'
                    },
                    {
                        text: 'Линейки продукции',
                        path: '/list-line-products'
                    },
                    {
                        text: 'Добавление группы',
                        path: '/group'
                    },
                    {
                        text: 'Аттрибуты',
                        path: '/list-attributes'
                    },
                    {
                        text: 'Привязка атрибутов',
                        path: '/bind-attributes'
                    },
                    {
                      text: 'Типы файлов',
                      path: '/type-files'
                    },
                    { divider: true },
                    {
                        text: 'Баннеры',
                        path: '/banner'
                    }
                ]
            }
        },
        methods: {
            select(path) {
                this.$router.push(path);
            },
            goMainPage() {
                this.$router.push({name: 'table-products'})
            },
            exit() {
                //localStorage.setItem('isAdmin','false')
                //this.$store.dispatch('auth/disableAdmin')
                //this.$store.dispatch('auth/disableAdminView')
                //this.$router.push('/')
                axios.get('/exit').then((response) => {
                    document.location.href="/"
                }).catch(err => {
                    console.log(err)
                })
            }
        }
    }
</script>
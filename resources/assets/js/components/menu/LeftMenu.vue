<template>
    <div>
        <img class="menu-left-img hidden-sm-and-down" src="images/menu-left-hr.png"/>
        <v-card class="menu-left-wrappers hidden-sm-and-down">
            <v-list class="list-menu-left">
                <v-list-tile class="menu-left__header">
                    <v-list-tile-content>
                        <v-list-tile-title class="text-md-center">Каталог продукции</v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>
                <template v-for="itemMenu in menu">
                    <v-menu offset-x open-on-hover class="menu-left-h">
                        <v-list-group v-model="itemMenu.id" slot="activator">
                            <v-list-tile slot="activator">
                                <v-list-tile-content>
                                    <v-list-tile-title>{{ itemMenu.title }}</v-list-tile-title>
                                </v-list-tile-content>
                            </v-list-tile>
                            <v-list-tile v-for="subItem in itemMenu.type_products" :key="subItem.id">
                                <v-list-tile-content>
                                    <v-list-tile-title class="menu-left-item-el" slot="activator">
                                        <img src="images/menu-left-item-sub-arr.png"/>
                                        {{ subItem.title }}
                                    </v-list-tile-title>
                                </v-list-tile-content>
                            </v-list-tile>
                        </v-list-group>
                        <div class="sub-menu" v-if="itemMenu.type_products.length>0">
                            <v-layout column wrap v-for="submenu in itemMenu.type_products" :key="submenu.id">
                                    <v-layout column wrap>
                                        <span class="sub-menu__header">{{submenu.title}}</span>
                                        <v-list>
                                            <v-list-tile v-for="item in submenu.producer_type_products" :key="item.id">
                                                <a href="#">{{item.name_line}}</a>
                                            </v-list-tile>
                                        </v-list>
                                    </v-layout>
                            </v-layout>
                            <br>
                        </div>
                    </v-menu>
                </template>
            </v-list>
        </v-card>
    </div>
</template>
<script>
    export default {
        name: 'LeftMenu',
        props: { },
        data: function() {
            return {
                menu: []
            }
        },
        mounted: function() {
            this.getMenu()
        },
        methods: {
            getMenu() {
                axios.get('/left-menu').then(response => response.data).then( response => {
                    this.menu = response
                }).catch(error => {})
            }
        }
     }
</script>
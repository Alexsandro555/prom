<!-- Новое меню -->
<img class="menu-left-img hidden-sm-and-down" src="{{asset('images/menu-left-hr.png')}}"/>
<v-card class="menu-left-wrappers hidden-sm-and-down">
    <v-list class="list-menu-left">
        <v-list-tile class="menu-left__header">
            <v-list-tile-content>
                <v-list-tile-title class="text-md-center">Каталог продукции</v-list-tile-title>
            </v-list-tile-content>
        </v-list-tile>
        <template v-for="menu in menus">
            <v-menu offset-x open-on-hover class="menu-left-h">
                <v-list-group v-model="menu.active" slot="activator">
                    <v-list-tile slot="activator">
                        <v-list-tile-content>
                            <v-list-tile-title>@{{ menu.title }}</v-list-tile-title>
                        </v-list-tile-content>
                    </v-list-tile>
                    <v-list-tile v-for="subItem in menu.submenu" :key="subItem.title">
                        <v-list-tile-content>
                            <v-list-tile-title class="menu-left-item-el" slot="activator">
                                <img src="{{asset('images/menu-left-item-sub-arr.png')}}"/>
                                @{{ subItem.title }}
                            </v-list-tile-title>
                        </v-list-tile-content>
                    </v-list-tile>
                </v-list-group>
                <div class="sub-menu" v-if="menu.submenu">
                    <v-layout column wrap>
                        <v-layout row wrap>
                            <v-layout column wrap>
                                <span class="sub-menu__header">Кормление</span>
                                <v-list>
                                    <v-list-tile><a href="#">Подпункт меню</a></v-list-tile>
                                    <v-list-tile><a href="#">Подпункт меню</a></v-list-tile>
                                    <v-list-tile><a href="#">Подпункт меню</a></v-list-tile>
                                </v-list>
                            </v-layout>
                            <v-layout column wrap>
                                <span class="sub-menu__header">Кормление</span>
                                <v-list>
                                    <v-list-tile><a href="#">Подпункт меню</a></v-list-tile>
                                    <v-list-tile><a href="#">Подпункт меню</a></v-list-tile>
                                    <v-list-tile><a href="#">Подпункт меню</a></v-list-tile>
                                </v-list>
                            </v-layout>
                            <v-layout column wrap>
                                <span class="sub-menu__header">Кормление</span>
                                <v-list>
                                    <v-list-tile><a href="#">Подпункт меню</a></v-list-tile>
                                    <v-list-tile><a href="#">Подпункт меню</a></v-list-tile>
                                    <v-list-tile><a href="#">Подпункт меню</a></v-list-tile>
                                </v-list>
                            </v-layout>
                        </v-layout>
                    </v-layout>
                    <v-layout column wrap>
                        <v-layout row wrap>
                            <v-layout column wrap>
                                <span class="sub-menu__header">Кормление</span>
                                <v-list>
                                    <v-list-tile><a href="#">Подпункт меню</a></v-list-tile>
                                    <v-list-tile><a href="#">Подпункт меню</a></v-list-tile>
                                    <v-list-tile><a href="#">Подпункт меню</a></v-list-tile>
                                </v-list>
                            </v-layout>
                            <v-layout column wrap>
                                <span class="sub-menu__header">Кормление</span>
                                <v-list>
                                    <v-list-tile><a href="#">Подпункт меню</a></v-list-tile>
                                    <v-list-tile><a href="#">Подпункт меню</a></v-list-tile>
                                    <v-list-tile><a href="#">Подпункт меню</a></v-list-tile>
                                </v-list>
                            </v-layout>
                            <v-layout column wrap>
                                <span class="sub-menu__header">Кормление</span>
                                <v-list>
                                    <v-list-tile><a href="#">Подпункт меню</a></v-list-tile>
                                    <v-list-tile><a href="#">Подпункт меню</a></v-list-tile>
                                    <v-list-tile><a href="#">Подпункт меню</a></v-list-tile>
                                </v-list>
                            </v-layout>
                        </v-layout>
                    </v-layout>
                    <!--<ul class="sub-menu__head">
                        <li v-for="subItem in menu.submenu">
                            <a href="#">@{{ subItem.title }}</a>
                            <ul class="sub-menu__items">
                                <li class="sub-menu__item" v-for="item in subItem.items">
                                    <a href="#">@{{ item.title }}</a>
                                </li>
                            </ul>
                        </li>
                    </ul>-->
                    <br>
                </div>
            </v-menu>
        </template>
    </v-list>
</v-card>
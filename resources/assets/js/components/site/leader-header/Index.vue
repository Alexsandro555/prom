<template>
    <header class="header">
        <v-flex xs1>
            <v-btn dark class="hidden-md-and-up" @click.stop="drawer = !drawer"><v-icon>reorder</v-icon></v-btn>
        </v-flex>
        <div class="header-menu hidden-sm-and-down">
            <v-flex xl12 lg12 md12 sm12 xs12 class="wrapper">
                <v-layout row wrap>
                    <v-flex xl4 lg4 md5 sm7 xs6>
                        <v-list class="top-menu text-xs-right text-lg-center">
                            <v-list-tile class="top-menu__item">о компании</v-list-tile>
                            <v-list-tile class="top-menu__item">новости</v-list-tile>
                            <v-list-tile class="top-menu__item">оборудование</v-list-tile>
                        </v-list>
                    </v-flex>
                    <v-flex xl2 lg2 md2 class="hidden-sm-and-down">
                        <a href="/"><img src="images/logo-layer.png"/></a>
                    </v-flex>
                    <v-flex xl6 lg6 md5 sm5 xs6>
                        <v-layout row wrap>
                            <v-flex md12 lg8 xl8 class="text-md-center">
                                <v-list class="top-menu text-xs-left text-md-center text-sm-left text-lg-center">
                                    <v-list-tile class="top-menu__item">доставка и оплата</v-list-tile>
                                    <v-list-tile class="top-menu__item">контакты</v-list-tile>
                                </v-list>
                            </v-flex>
                            <v-flex xs4 class="hidden-md-and-down">
                                <v-layout row wrap>
                                    <v-flex xs10>
                                        <cart-widget></cart-widget>
                                    </v-flex>
                                    <v-flex xs2 justify-center>
                                        <img class="find" src="images/find.png"/>
                                    </v-flex>
                                </v-layout>
                            </v-flex>
                        </v-layout>
                    </v-flex>
                </v-layout>
            </v-flex>
        </div>
        <div class="wrapper">
            <v-flex sm12>
                <v-layout row wrap>
                    <v-flex sm4 class="hidden-md-and-down">
                        <div class="main-slogan">
                            Инновационные <span class="sub-slogan">системы кормления</span><br>
                            <span class="main-slogan__from">от европейских производителей</span>
                        </div>
                    </v-flex>
                    <v-flex sm3 offset-sm3 class="hidden-md-and-down">
                        <div class="phone text-xs-right">
                            c 8 до 22 <span class="phone__sun" @click.stop="login">без выходных</span><br>
                            <span class="phone__number">+7 (495) 780 44 96</span><br>
                            <a class="phone__callback" href="#">Заказать звонок</a>
                        </div>
                    </v-flex>
                </v-layout>
            </v-flex>
        </div>
        <div class="wrapper">
            <div class="animal-panel hidden-md-and-down">
                <a href="#"><img src="images/chicken-img-panel.png"/></a>
                <a href="#"><img src="images/pig-img-panel.png"/></a>
                <a href="#"><img src="images/cow-img-panel.png"/></a>
                <a href="#"><img src="images/bar-img-panel.png"/></a>
            </div>
        </div>
    </header>
</template>
<script>
    export default {
        name: 'LeaderHeader',
        props: { },
        data: function() {
            return { }
        },
        mounted: function() {
        },
        methods: {
        }
     }
</script>
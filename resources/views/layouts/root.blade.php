<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="{{asset('storage/favicon_leader.ico')}}" type="image/x-icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @yield('view.style')
    <title>@yield('title')</title>
</head>
<body>
<div id="app">
        <!--<div v-if="isAdminView">
            <app></app>
        </div>
        <div v-else>-->
        <v-app >
            <template>
                <v-layout column wrap>
                    <v-container fluid grid-list-xs text-xs-center>
                        <header ref="header" :class="{header: true, chickens: chickens, cows: cows, pigs: pigs, rams:rams, 'main-layout': main}">
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
                                            <a href="/"><img src="{{asset('images/logo-layer.png')}}"/></a>
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
                                                            <img class="find" src="{{asset('images/find.png')}}"/>
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
                                                c 8 до 22 <span class="phone__sun">без выходных</span><br>
                                                <span class="phone__number">+7 (495) 780 44 96</span><br>
                                                <a class="phone__callback" href="#">Заказать звонок</a>
                                            </div>
                                        </v-flex>
                                    </v-layout>
                                </v-flex>
                            </div>
                            <div class="wrapper">
                                <div class="animal-panel hidden-md-and-down">
                                    <a href="#"><img @click.stop="changeSlide('chickens')" src="{{asset('images/chicken-img-panel.png')}}"/></a>
                                    <a href="#"><img @click.stop="changeSlide('pigs')" src="{{asset('images/pig-img-panel.png')}}"/></a>
                                    <a href="#"><img @click.stop="changeSlide('cows')" src="{{asset('images/cow-img-panel.png')}}"/></a>
                                    <a href="#"><img @click.stop="changeSlide('rams')" src="{{asset('images/bar-img-panel.png')}}"/></a>
                                </div>
                            </div>
                            <!--<img class="header__img" src="{{asset('images/header-layer.png')}}"/>-->
                        </header>
                        <div class="content-wrapper-top"></div>
                        @yield('content')
                        <footer class="footer">
                            <div class="footer-wrapper">
                                <v-layout row wrap>
                                    <v-flex xs12 class="hidden-sm-and-down">
                                        <v-layout row wrap>
                                            <v-flex xs8>
                                                <ul class="footer-top-menu">
                                                    <li>О компании</li>
                                                    <li>Новости</li>
                                                    <li>Оборудование</li>
                                                    <li>Доставка и оплата</li>
                                                    <li>Контакты</li>
                                                </ul>
                                            </v-flex>
                                            <v-flex xs4>
                                                <img class="footer__sicial-icons" src="{{asset('images/footer-social-icons.png')}}"/>
                                            </v-flex>
                                        </v-layout>
                                    </v-flex>
                                    <v-flex xs12>
                                        <v-layout row wrap>
                                            <v-flex xs6 class="footer__menu hidden-sm-and-down">
                                                <v-layout row wrap>
                                                    <v-flex xs10 sm6 md4 class="text-xs-left">
                                                        <v-list>
                                                            <v-list-tile>
                                                                <img class="footer-menu-ava" src="{{asset('images/footer-menu-ava.png')}}" />
                                                                Вентиляция
                                                            </v-list-tile>
                                                            <v-list-tile>
                                                                <img class="footer-menu-ava" src="{{asset('images/footer-menu-ava.png')}}" />
                                                                Комплексные решения
                                                            </v-list-tile>
                                                            <v-list-tile>
                                                                <img class="footer-menu-ava" src="{{asset('images/footer-menu-ava.png')}}" />
                                                                Кормление
                                                            </v-list-tile>
                                                            <v-list-tile>
                                                                <img class="footer-menu-ava" src="{{asset('images/footer-menu-ava.png')}}" />
                                                                Поение
                                                            </v-list-tile>
                                                            <v-list-tile>
                                                                <img class="footer-menu-ava" src="{{asset('images/footer-menu-ava.png')}}" />
                                                                Навозоудаление
                                                            </v-list-tile>
                                                            <v-list-tile>
                                                                <img class="footer-menu-ava" src="{{asset('images/footer-menu-ava.png')}}" />
                                                                Содержание
                                                            </v-list-tile>
                                                            <v-list-tile>
                                                                <img class="footer-menu-ava" src="{{asset('images/footer-menu-ava.png')}}" />
                                                                Доильное оборудлвание
                                                            </v-list-tile>
                                                        </v-list>
                                                    </v-flex>
                                                    <v-flex xs10 sm6 md4 class="text-xs-left">
                                                        <v-list>
                                                            <v-list-tile avatar>
                                                                <img class="footer-menu-ava" src="{{asset('images/footer-menu-ava.png')}}" />
                                                                Вентиляция
                                                            </v-list-tile>
                                                            <v-list-tile>
                                                                <img class="footer-menu-ava" src="{{asset('images/footer-menu-ava.png')}}" />
                                                                Комплексные решения
                                                            </v-list-tile>
                                                            <v-list-tile>
                                                                <img class="footer-menu-ava" src="{{asset('images/footer-menu-ava.png')}}" />
                                                                Кормление
                                                            </v-list-tile>
                                                            <v-list-tile>
                                                                <img class="footer-menu-ava" src="{{asset('images/footer-menu-ava.png')}}" />
                                                                Поение
                                                            </v-list-tile>
                                                            <v-list-tile>
                                                                <img class="footer-menu-ava" src="{{asset('images/footer-menu-ava.png')}}" />
                                                                Навозоудаление
                                                            </v-list-tile>
                                                            <v-list-tile>
                                                                <img class="footer-menu-ava" src="{{asset('images/footer-menu-ava.png')}}" />
                                                                Содержание
                                                            </v-list-tile>
                                                            <v-list-tile>
                                                                <img class="footer-menu-ava" src="{{asset('images/footer-menu-ava.png')}}" />
                                                                Доильное оборудлвание
                                                            </v-list-tile>
                                                        </v-list>
                                                    </v-flex>
                                                    <v-flex xs10 sm6 md4 class="text-xs-left">
                                                        <v-list>
                                                            <v-list-tile>
                                                                <img class="footer-menu-ava" src="{{asset('images/footer-menu-ava.png')}}" />
                                                                Вентиляция
                                                            </v-list-tile>
                                                            <v-list-tile>
                                                                <img class="footer-menu-ava" src="{{asset('images/footer-menu-ava.png')}}" />
                                                                Комплексные решения
                                                            </v-list-tile>
                                                            <v-list-tile>
                                                                <img class="footer-menu-ava" src="{{asset('images/footer-menu-ava.png')}}" />
                                                                Кормление
                                                            </v-list-tile>
                                                            <v-list-tile>
                                                                <img class="footer-menu-ava" src="{{asset('images/footer-menu-ava.png')}}" />
                                                                Поение
                                                            </v-list-tile>
                                                            <v-list-tile>
                                                                <img class="footer-menu-ava" src="{{asset('images/footer-menu-ava.png')}}" />
                                                                Навозоудаление
                                                            </v-list-tile>
                                                            <v-list-tile>
                                                                <img class="footer-menu-ava" src="{{asset('images/footer-menu-ava.png')}}" />
                                                                Содержание
                                                            </v-list-tile>
                                                            <v-list-tile>
                                                                <img class="footer-menu-ava" src="{{asset('images/footer-menu-ava.png')}}" />
                                                                Доильное оборудлвание
                                                            </v-list-tile>
                                                        </v-list>
                                                    </v-flex>
                                                </v-layout>
                                            </v-flex>
                                            <v-flex xs2 class="hidden-sm-and-down">
                                                <img class="footer__chicken" src="{{asset('images/footer-chicken.png')}}"/>
                                            </v-flex>
                                            <v-flex xs11 offset-xs1 sm11 md3 class="text-xs-left text-md-right">
                                                <v-layout column wrap>
                                                    <v-flex xs8>
                                                        <span class="footer__phone footer-right">
                                                            c 8 до 22 <span class="phone__sun">без выходных</span><br>
                                                            <span class="phone__number">+7 (495) 780 44 96</span><br>
                                                            <a class="phone__callback text-xs-center" href="#">Заказать звонок</a>
                                                        </span>
                                                    </v-flex>
                                                    <v-flex xs4 class="footer__address text-xs-right">
                                                        <v-flex offset-md4 class="text-xs-left footer__address--margbot10 footer-right">
                                                            <img align="top" src="{{asset('images/footer-mail-img.png')}}"/>
                                                            <span class="footer__mail">info@mail.ru</span><br>
                                                            <img align="top" src="{{asset('images/footer-map-marker-img.png')}}"/>
                                                            г.Москва, Большая Семеноская д.15<br>
                                                        </v-flex>
                                                        <v-flex xs12 class="text-xs-right">
                                                            <v-layout column wrap>
                                                                <v-flex xs11 offset-xs2>
                                                                    <img align="middle" class="footer__logo" src="{{asset('images/logo-small.png')}}"/>&nbsp;&nbsp;&nbsp;
                                                                </v-flex>
                                                                <v-flex xs12>
                                                                    <span class="footer__copyright">© Copyright 2018</span><br>
                                                                    <auth-widget class="text-xs-right footer-right"></auth-widget>
                                                                </v-flex>
                                                            </v-layout>

                                                        </v-flex>
                                                    </v-flex>
                                                </v-layout>
                                            </v-flex>
                                        </v-layout>
                                    </v-flex>
                                </v-layout>
                            </div>
                        </footer>
                    </v-container>
                    <v-navigation-drawer v-model="drawer" temporary absolute dark style="position:fixed; top:0; left:0; overflow-y:scroll;">
                        <v-toolbar flat>
                            <v-list class="pa-0">
                                <v-list-tile>
                                    Страницы
                                </v-list-tile>
                            </v-list>
                        </v-toolbar>
                        <v-list>
                            <v-list-tile>О компании</v-list-tile>
                            <v-list-tile>Новости</v-list-tile>
                            <v-list-tile>Оборудование</v-list-tile>
                            <v-list-tile>Доставка и оплата</v-list-tile>
                            <v-list-tile>Контакты</v-list-tile>
                            <v-subheader>Рубрикатор</v-subheader>
                        </v-list>
                        <v-divider></v-divider>
                        <v-toolbar flat>
                            <v-list>
                                <v-list-tile>
                                    Рубрики
                                </v-list-tile>
                                <v-list-group v-model="item.active" v-for="item in items" :key="item.title" no-action>
                                    <v-list-tile slot="activator">
                                        <v-list-tile-content>
                                            <v-list-tile-title>@{{ item.title }}</v-list-tile-title>
                                        </v-list-tile-content>
                                    </v-list-tile>
                                    <v-list-tile v-for="subItem in item.submenu" :key="subItem.title">
                                        <v-list-tile-content>
                                            <v-list-tile-title>@{{ subItem.title }}</v-list-tile-title>
                                        </v-list-tile-content>
                                    </v-list-tile>
                                </v-list-group>
                            </v-list>
                        </v-toolbar>
                    </v-navigation-drawer>
                </v-layout>
            </template>
            <dialog-registration></dialog-registration>
            <dialog-login></dialog-login>
        </v-app>
        <!--Коf-->
        <!--</div>-->
</div>
<script src="{{mix('/js/app.js')}}" type="application/javascript"></script>
<link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}">
</body>
</html>
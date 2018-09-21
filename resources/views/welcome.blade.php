<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
    <!--<link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' rel="stylesheet">-->
    <style>
        .first {
            display: inline-block;
            width: 10%;
        }
        .second {
            //display: inline-block;
            //width:89%;
        }
        .sub-menu {
            list-style: none;
            margin: 0;
            padding: 0;
        }
        .sub-menu li {
            width: 100%;
            height: 50px;
            text-align: center;

        }
        .sub-menu li:hover {
            background-color: red;
        }
        .sub-menu li a {
            text-decoration: none;
            height: 50px;
            line-height: 25px;
        }
        .fd {
            width: 100%;
        }
    </style>
</head>
<body>
<div id="app">
    <v-app id="inspire">
        <div class="first">
            <v-list>
                <v-list-group v-model="item.active" v-for="item in items" :key="item.title" no-action>
                    <v-list-tile slot="activator">
                        <v-list-tile-content>
                            <v-list-tile-title>@{{ item.title }}</v-list-tile-title>
                        </v-list-tile-content>
                    </v-list-tile>
                    <template v-for="subItem in item.submenu">
                        <v-menu  class="fd" offset-x open-on-hover>
                            <v-list-tile  @click="" slot="activator">
                                <v-list-tile-content>
                                    <v-list-tile-title>@{{ subItem.title }}</v-list-tile-title>
                                </v-list-tile-content>
                            </v-list-tile>
                            <v-card>
                                <v-list three-line v-if="subItem.recept">
                                    <template v-for="(rec, index) in subItem.recept">
                                        <v-subheader v-if="rec.header" :key="rec.header">@{{ rec.header }}</v-subheader>
                                        <v-divider v-else-if="rec.divider" :inset="rec.inset" :key="index"></v-divider>
                                        <v-list-tile avatar v-else :key="rec.title" @click="">
                                            <v-list-tile-avatar>
                                                <img :src="rec.avatar">
                                            </v-list-tile-avatar>
                                            <v-list-tile-content>
                                                <v-list-tile-title v-html="rec.title"></v-list-tile-title>
                                                <v-list-tile-sub-title v-html="rec.subtitle"></v-list-tile-sub-title>
                                            </v-list-tile-content>
                                        </v-list-tile>
                                    </template>
                                </v-list>
                            </v-card>
                        </v-menu>
                    </template>
                </v-list-group>
            </v-list>
        </div>
        <div class="second">
            <v-container fluid grid-list-xs>
                <v-layout row wrap>
                    <div style="width: 1200px; margin: 0 auto;">
                            <v-layout row wrap>
                                <v-flex md5>
                                    Содержимое 1
                                </v-flex>
                                <v-flex md2 class="hidden-md-and-down">
                                    Содержимое 2
                                </v-flex>
                                <v-flex md5>Содержимое 3</v-flex>
                            </v-layout>
                    </div>
                </v-layout>
            </v-container>
            <!--<div class="text-xs-top">
                <template>
                    <v-layout row>
                        <v-flex xs12 sm6 offset-sm3>
                            <v-card>
                                <v-toolbar color="cyan" dark>
                                    <v-toolbar-side-icon></v-toolbar-side-icon>
                                    <v-toolbar-title>Inbox</v-toolbar-title>
                                    <v-spacer></v-spacer>
                                    <v-btn icon>
                                        <v-icon>search</v-icon>
                                    </v-btn>
                                </v-toolbar>
                                <v-list two-line>
                                    <template v-for="(item, index) in items[0].submenu[0].recept">
                                        <v-subheader v-if="item.header" :key="item.header">@{{ item.header }}</v-subheader>
                                        <v-divider v-else-if="item.divider" :inset="item.inset" :key="index"></v-divider>
                                        <v-list-tile avatar v-else :key="item.title" @click="">
                                            <v-list-tile-avatar>
                                                <img :src="item.avatar">
                                            </v-list-tile-avatar>
                                            <v-list-tile-content>
                                                fdf
                                                <v-list-tile-title v-html="item.title"></v-list-tile-title>
                                                <v-list-tile-sub-title v-html="item.subtitle"></v-list-tile-sub-title>
                                            </v-list-tile-content>
                                        </v-list-tile>
                                    </template>
                                </v-list>
                            </v-card>
                        </v-flex>
                    </v-layout>
                </template>
            </div>-->
        </div>
    </v-app>
</div>
<script src="/js/app.js" type="application/javascript"></script>
</body>
</html>

    /**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import Vuex from 'vuex';
import Vuetify from 'vuetify';
import VueCarousel from 'vue-carousel';

Vue.use(Vuetify);
import 'material-design-icons/iconfont/material-icons.css'
import 'vuetify/dist/vuetify.min.css'
import createStore from './store/states.js'

import site from './components/site';

import VueRouter from 'vue-router';
Vue.use(Vuex);
Vue.use(VueRouter);

Vue.component('app', require('./components/app/Index.vue'));
Vue.component('cart-widget', require('../../../Modules/Cart/Resources/assets/js/components/cart/CartWidget'));

// Аутентификация
Vue.component('dialog-registration', require('./components/auth/register'));
Vue.component('dialog-login', require('./components/auth/login'));
Vue.component('auth-widget', require('./components/auth/login-widget'));

// Слайдер
Vue.component('leader-slider', require('./components/leader/slider'));
import DetailImage from './components/leader/DetailImage';
Vue.component('detail-image', DetailImage);
//Vue.component('leader-detail-image', require('./components/leader/leader-detail-image'));
Vue.component('left-menu', require('./components/menu/LeftMenu'));

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


/* Возможно код ниже следуе вынести в отдельный файл route.js */
import tableProducts from './components/product/table-products';
import updateProduct from './components/product/create';
import listCategories from './components/product/category/list';
import listLineProducts from './components/product/line-product/list';
import listTypeProducts from './components/product/type-product/list';
import listProducers from './components/product/producer/list';
import listAttributes from './components/product/attribute/list';
import bindAttributes from './components/product/attribute/binding';
import typeFiles from './components/files/type-file';
import banner from '../../../Modules/Banner/Resources/assets/js/Banner';
import tnved from './components/product/tnved/list';
import swal from 'sweetalert';
import initializer from "./store/modules/initializer";
import product from "../../../Modules/Catalog/Resources/assets/js/components/product/Add"
import group from  "../../../Modules/Catalog/Resources/assets/js/components/group/Add"


const routes = [
    {path: '/', name: 'table-products', component: tableProducts},
    {path: '/update-product/:id', name: 'update-product', component: product},
    {path: '/categories', name: 'categories', component: listCategories},
    {path: '/list-line-products', name: 'list-line-products', component: listLineProducts},
    {path: '/list-type-products', name: 'list-type-products', component: listTypeProducts},
    {path: '/list-producers', name: 'list-producers', component: listProducers},
    {path: '/list-attributes', name: 'list-attributes', component: listAttributes},
    {path: '/bind-attributes', name: 'bind-attributes', component: bindAttributes},
    {path: '/type-files', name: 'type-files', component: typeFiles},
    {path: '/banner', name: 'banner', component: banner},
    {path: '/tnved', name: 'tnved', component: tnved},
    {path: '/group', name: 'group', component: group},
    {path: '/testForm/:id', name: 'test-form', component: product}
];

const router = new VueRouter({
    routes,
    //mode: 'history',
    base: 'admin'
})

const app = new Vue({
    el: '#app',
    $_veeValidate: {
        validator: 'new'
    },
    router,
    store: new Vuex.Store(createStore()),
    data: {
    },
    created() {
        this.$store.dispatch('initializer/init')
    },
    methods: {
        login() {
            // если client аутентифицирован уже
            if(this.$store.getters['auth/getAdmin']) {
                // отображаем панель администрирования
                this.$store.dispatch('auth/adminView')
                this.$router.push('admin')
            }
            else {
                this.$store.dispatch('auth/active')
            }
        },
        addCart(id) {
            this.$store.dispatch('cart/add', { id })
        },
        changeSlide(val) {
            this.$store.dispatch('sliderFullPage/change',val)
        }
    }
});

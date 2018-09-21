import createStore from "./store/states";

require('./bootstrap');

window.Vue = require('vue');

import Vuex from 'vuex';
Vue.use(Vuex);




const app = new Vue({
    el: '#app',
    store: new Vuex.Store(createStore()),
});


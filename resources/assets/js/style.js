import createStore from "./store/states";

require('./bootstrap');

window.Vue = require('vue');

import Vuex from 'vuex';
Vue.use(Vuex);

Vue.component('leader-detail-image', require('./components/leader-detail-image'));


const app = new Vue({
    el: '#app',
    store: new Vuex.Store(createStore()),
});


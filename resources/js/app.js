import VueRouter from 'vue-router';
import Vuelidate from 'vuelidate';
import store from './app/store';
import router from './app/router';
import App from "./app/App";

window.Vue = require('vue');

require('./bootstrap');

Vue.use(VueRouter);
Vue.use(Vuelidate);

const app = new Vue({
    el: '#app',
    store,
    router,
    render : h => h(App)
});

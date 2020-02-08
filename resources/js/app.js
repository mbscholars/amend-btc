
import Vue from 'vue';
import router from './router.js';
import LoadScript from 'vue-plugin-load-script';
 
  Vue.use(LoadScript);
require('./bootstrap');

window.Vue = require('vue');
//REGISTER COMPONENTNS
// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('app-header', require('./components/header.vue').default);
Vue.component('app-nav', require('./components/menu.vue').default);


const app = new Vue({
    el: '#app',
    router
});

import vuetify from './plugins/vuetify.js'
require('./bootstrap');

window.Vue = require('vue').default;
Vue.component('app', require('./app.vue').default);
Vue.component('Header', require('./components/Header').default);

const app = new Vue({
    el: '#app',
    vuetify
});

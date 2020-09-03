require('./bootstrap');

import Vue from 'vue';

Vue.component('admin-users', require('./components/admin-users.vue').default);
Vue.component('general-users', require('./components/general-users.vue').default);

const app = new Vue({
    el: '#app'
});

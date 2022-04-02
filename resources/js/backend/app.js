import 'alpinejs'

window.$ = window.jQuery = require('jquery');
window.Swal = require('sweetalert2');
window._ = require('lodash');


// CoreUI
require('@coreui/coreui');

// Boilerplate
require('../plugins');

window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import Vue from 'vue';
import vSelect from 'vue-select'

Vue.component('v-select', vSelect)
Vue.component('select-customer', require('./components/Selects/Customers/SelectCustomer.vue').default);
Vue.component('select-category', require('./components/Selects/Categories/SelectCategories.vue').default);

const app = new Vue({
    el: '#app',
});

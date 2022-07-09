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
import vSelect from 'vue-select';
import VueRangedatePicker from 'vue-rangedate-tools';
import { createPinia, PiniaVuePlugin } from 'pinia'

Vue.use(PiniaVuePlugin)
const pinia = createPinia()


Vue.component('vue-date-picker', VueRangedatePicker);
Vue.component('v-select', vSelect)

Vue.component('transaction-out', require('./components/Forms/Transactions/Sales/Out.vue').default);
Vue.component('transaction-in', require('./components/Forms/Transactions/Purchases/In_2.vue').default);

Vue.component('report-out', require('./components/Forms/Reports/Out.vue').default);

Vue.component('select-customer', require('./components/Selects/Customers/SelectCustomer.vue').default);
Vue.component('select-suplier', require('./components/Selects/Suppliers/SelectSuplier.vue').default);
Vue.component('select-category', require('./components/Selects/Categories/SelectCategories.vue').default);
Vue.component('select-date', require('./components/Forms/DatePicker/FilterDate.vue').default);

Vue.component('chart-out', require('./components/Chart/OutChart.vue').default);

Vue.component('full-calendar-component', require('./components/Calendar/FullCalendar.vue').default);

Vue.component('create-payment-component', require('./components/Forms/Payments/CreatePayment.vue').default);
Vue.component('input-number-component', require('./components/Forms/InputNumber.vue').default);

Vue.component('report', require('./components/Reports/Page.vue').default);

const app = new Vue({
    el: '#app',
    pinia
});

window.vueApp = app;

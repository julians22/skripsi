<template>
    <div>
        <div class="form-group row">
            <label for="customer" class="col-md-2 col-form-label">{{ selectLabel }}</label>
            <div class="col-md-10">
                <input type="hidden" name="selected_customer" v-bind:value="getCustomerId(selected_customer)">
                <v-select label="name" v-model="selected_customer" :options="customers" @search="onSearch" @deselected="selected_customer = null"></v-select>
                <div class="mt-2">
                    <input-customer :customer="selected_customer"></input-customer>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import InputCustomer from './InputCustomer.vue';

export default {
    props: {
        customers_model: {
            type: Array,
        },
        selectLabel: {
            type: String,
            default: 'Select Customer',
        },
    },
    components: {
        InputCustomer
    },
    data() {
        return {
            customers: [],
            selected_customer: null,
        }
    },
    created() {
        this.customers = this.customers_model;
    },
    methods: {
        onSearch(search, loading) {
            if(search.length) {
                loading(true);
                this.search(loading, search, this)
            }else{
                this.customers = this.customers_model;
                loading(false);
            }
        },
        search: _.debounce((loading, search, vm) => {
            axios.get('/ajax/getCustomers?search=' + search)
                .then(res => {
                    vm.customers = res.data;
                    loading(false);
                })
                .catch(error => {
                    console.log(error);
                    loading(false);
                });
        }, 500),
        getCustomerId(customer) {
            if(customer) {
                return customer.id;
            }
            return 0;
        }
    }
}
</script>

<style>

</style>

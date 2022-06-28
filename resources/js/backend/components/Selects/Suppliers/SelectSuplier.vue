<template>
    <div>
        <div class="form-group row">
            <label for="customer" class="col-md-2 col-form-label">Select Suplier</label>
            <div class="col-md-10">
                <input type="hidden" name="suplier" v-bind:value="getSuplierId(selected_suplier)">
                <v-select label="name" v-model="selected_suplier" :options="supliers" @search="onSearch" @deselected="selected_suplier = null"></v-select>
                <div class="mt-2">
                    <input-suplier :suplier="selected_suplier"></input-suplier>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import InputSuplier from './InputSuplier.vue';

export default {
    props: {
        suplier_model: {
            type: Array,
        }
    },
    components: {
        InputSuplier
    },
    data() {
        return {
            supliers: [],
            selected_suplier: null,
        }
    },
    created() {
        this.supliers = this.suplier_model;
    },
    methods: {
        onSearch(search, loading) {
            if(search.length) {
                loading(true);
                this.search(loading, search, this)
            }else{
                this.supliers = this.suplier_model;
                loading(false);
            }
        },
        search: _.debounce((loading, search, vm) => {
            axios.get('/ajax/getSupliers?search=' + search)
                .then(res => {
                    vm.supliers = res.data;
                    loading(false);
                })
                .catch(error => {
                    console.log(error);
                    loading(false);

                });
        }, 500),
        getSuplierId(suplier) {
            if(suplier) {
                return suplier.id;
            }
            return 0;
        }
    }
}
</script>

<style>

</style>

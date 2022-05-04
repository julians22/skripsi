<template>
    <div>
        <slot name="select_customer"></slot>

        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <v-select label="name"
                                v-model="selected_product"
                                :options="products"
                                placeholder="Select Product"
                                @search="onSearch"
                                @deselected="selected_product = null"
                                >
                            </v-select>
                        </div>
                        <div v-if="selected_product">
                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <div class="row">
                                    <div class="col-10">
                                        <input type="number" class="form-control" id="amount" placeholder="Quantity" v-model="amount">
                                    </div>
                                    <div class="col-2">
                                        / <span v-text="selected_product.quantity"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button @click="addSelectedProduct" class="btn btn-sm btn-success" type="button">Add Product</button>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="table-responsive">
                    <table class="table table-sm table-strip table-hover table-bordered" align="center">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Amount</th>
                                <th>Price</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody v-if="added_products">
                            <table-row v-for="add_product in added_products" :key="`row-${add_product.id}`" :add_product="add_product"  />
                        </tbody>
                        <tbody v-else>
                            <tr>
                                <td colspan="4">No products added, select product first</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import TableRow from './Table/Row.vue'
export default {
    props: {
        products_model: {
            type: Array,
        }
    },
    data() {
        return {
            products: [],
            selected_product: null,
            added_products: [],
            amount: 1,
        }
    },
    components: {
        TableRow,
    },
    created() {
        this.products = this.products_model;
    },
    methods: {
        addSelectedProduct: function() {
            if(this.selected_product && this.amount) {
                if (this.added_products.length > 0) {
                    let found = false;
                    for (let i = 0; i < this.added_products.length; i++) {
                        if (this.added_products[i].id === this.selected_product.id) {
                            found = true;
                            let amount = parseInt(this.added_products[i].amount) + parseInt(this.amount);
                            this.added_products[i].amount = amount;
                            return;
                        }
                    }
                    if (!found) {
                        this.selected_product.amount = this.amount;
                        this.added_products.push(this.selected_product);
                        this.selected_product = null;
                    }
                }else{
                    this.selected_product.amount = this.amount;
                    this.added_products.push(this.selected_product);
                    this.selected_product = null;
                }
            }else{
                alert('Please select product and insert amount');
            }
        },

        onSearch(search, loading) {
            if(search.length) {
                loading(true);
                this.search(loading, search, this)
            }
        },
        search: _.debounce((loading, search, vm) => {
            axios.get('/ajax/getProducts', {
                    search: search,
                    added: vm.added_products
                })
                .then(res => {
                    vm.products = res.data;
                    loading(false);
                })
                .catch(error => {
                    console.log(error);
                    loading(false);
                });
        }, 500),
        addedId(){
            return this.added_products.map(product => product.id);
        },
    }
}
</script>

<style>

</style>

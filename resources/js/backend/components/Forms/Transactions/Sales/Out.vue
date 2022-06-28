<template>
    <div>
        <div class="row">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label >Select category</label>
                            <select class="form-control" v-model="selected_category" @change="onCategoryChange">
                                <option value="0">All</option>
                                <option v-for="(category, index) in categories" :value="category.id" :key="index">{{ category.name }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label >Select Product</label>
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
                                    <div class="col-8">
                                        <input type="number" class="form-control form-control-sm" id="amount" placeholder="Quantity" v-model="amount">
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
            <div class="col-md-7">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <slot name="select_customer"></slot>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered" align="center">
                                        <thead class="bg-dark">
                                            <tr>
                                                <th></th>
                                                <th>Product</th>
                                                <th>@</th>
                                                <th>Price</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="added_products.length > 0">
                                            <tr v-for="(add_product, index) in added_products" :key="`row-${add_product.id}`">
                                                <td>
                                                    <button @click="removeProduct(index)" type="button" class="btn btn-sm btn-danger">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </td>
                                                <td  width="100%">
                                                    {{ add_product.name }}
                                                    <input type="hidden" :name="`products[${index}][product_id]`" :value=" add_product.id">
                                                </td>
                                                <td>
                                                    {{ add_product.amount }}
                                                    <input type="hidden" :name="`products[${index}][quantity]`" :value=" add_product.amount">
                                                </td>
                                                <td>
                                                    <input type="hidden" :name="`products[${index}][price]`" :value=" add_product.price">
                                                    {{ add_product.price }}
                                                </td>
                                                <td>
                                                    {{ total(add_product.total) }}
                                                </td>
                                            </tr>
                                            <tr class="bg-dark">
                                                <th colspan="4">Subtotal</th>
                                                <td>
                                                    <input type="hidden" name="total" :value="subtotal">
                                                    <span v-text="subtotal">
                                                    </span>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody v-else>
                                            <tr>
                                                <td colspan="5">No products added, select product first</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">

                                <div class="form-group" v-if="subtotal > 0">
                                    <label for="discounts">Discount</label>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="input-group input-group-sm">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="inputGroup-sizing-sm">%</span>
                                                </div>
                                                <input v-model="discount.percentage" type="number" :readonly="setting.percentage == 1" class="form-control" name="discounts[percent]">
                                            </div>
                                        </div>
                                        <div class="col-md-2 text-center p-0">
                                            <button class="btn btn-sm btn-light" type="button" @click="setting.percentage = !setting.percentage"><i class="fas fa-exchange-alt"></i></button>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="input-group input-group-sm">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="inputGroup-sizing-sm">Rp</span>
                                                </div>
                                                <input v-model="discount.price" type="number" :readonly="setting.percentage == 0" class="form-control" name="discounts[price]">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div v-if="subtotal > 0">
                                    <span class="text-bolder">Grand Total</span>
                                    <span v-text="grand_total"></span>
                                </div>
                            </div>
                        </div>

                    </div>
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
        },
        categories_model: {
            type: Array,
        },
        old_selected_products: {
            type: Array,
        },
    },
    data() {
        return {
            products: [],
            selected_category: 0,
            selected_product: null,
            added_products: [],
            amount: 1,
            // grand_total: 0,
            subtotal: 0,
            discount: {
                percentage: 0,
                price: 0,
            },
            setting:{
                percentage: false,
            }
        }
    },
    watch: {
        subtotal() {
            this.applydiscount()
        },
        'discount.percentage': function(val) {
            this.applydiscount()
        },
        'discount.price': function(val) {
            this.applydiscount()
        },
    },
    computed: {
        grand_total(){
            const total = this.subtotal - this.discount.price
            return Number(total).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        },
        categories(){
            const categories_model = this.categories_model;
            let categories = categories_model.map(category => {
                return {
                    id: category.id,
                    name: category.name,
                }
            });

            return categories;
        },
    },
    components: {
        TableRow,
    },
    created() {
        this.products = this.products_model;
    },
    methods: {
        addSelectedProduct: function() {
            let data_added_products = this.added_products;
            this.selected_product.total = Number(this.amount) * Number(this.selected_product.price);
            if(this.selected_product && this.amount) {
                if (data_added_products.length > 0) {
                    let found = false;
                    for (let i = 0; i < data_added_products.length; i++) {
                        if (data_added_products[i].id === this.selected_product.id) {
                            found = true;
                            let amount = Number(data_added_products[i].amount) + Number(this.amount);
                            data_added_products[i].amount = Number(amount);
                            data_added_products[i].total = Number(data_added_products[i].amount) * Number(data_added_products[i].price);
                        }
                    }
                    if (!found) {
                        this.selected_product.amount = Number(this.amount);
                        data_added_products.push(this.selected_product);
                        this.selected_product = null;
                    }
                }else{
                    this.selected_product.amount = Number(this.amount);
                    data_added_products.push(this.selected_product);
                    this.selected_product = null;
                }
                this.added_products = [];
            }else{
                alert('Please select product and insert amount');
                this.added_products = [];
            }
            this.added_products = data_added_products;
            this.setSubtotal();

            this.amount = 1;
        },

        onSearch(search, loading) {
            if(search.length) {
                loading(true);
                this.search(loading, search, this)
            }
        },
        total(total) {
            return Number(total).toFixed(2);
        },
        search: _.debounce((loading, search, vm) => {
            axios.get('/ajax/getProducts', {
                    params: {
                        search: search,
                        category: vm.selected_category,
                    }
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
        removeProduct(index){
            this.added_products.splice(index, 1);
            this.setSubtotal();
        },
        setSubtotal(){
            let subtotal = 0;
            this.added_products.forEach(function(product) {
                subtotal += product.total;
            });
            this.subtotal = Number(subtotal).toFixed(2);
            this.applydiscount();
        },
        applydiscount(){
            const dis_type = this.setting.percentage;
            if(dis_type === true){
                this.dis_price();
            }else{
                this.dis_precent();
            }
        },
        dis_precent(){
            let percentValue = Number(this.discount.percentage);
            let subtotal = Number(this.subtotal);
            let price_value = Number(subtotal) * (percentValue / 100);
            this.discount.price = Number(price_value).toFixed(2);
        },
        dis_price(){
            let priceValue = Number(this.discount.price);
            let subtotal = Number(this.subtotal);
            let percent_value = Number(priceValue) / Number(subtotal);
            this.discount.percentage = Number(percent_value * 100).toFixed(2);
        },
        onCategoryChange(e){
            let value = e.target.value;
            axios.get('/ajax/getProducts', {
                params: {
                    category: value
                }
            })
            .then(res => {
                console.log(res);
                this.products = res.data;
                this.selected_category = value;
                // loading(false);
            })
            .catch(error => {
                console.log(error);
                // loading(false);
            });
        },
    }
}
</script>

<style scoped>
    table.table-sm{
        font-size: 0.8rem;
        text-align: center;
    }
</style>

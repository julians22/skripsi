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
                                    <div class="col-7">
                                        <input type="number" class="form-control form-control-sm" id="amount" placeholder="Quantity" v-model="amount">
                                    </div>
                                    <div class="col">
                                        / <span v-text="selected_product.quantity"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="buy_price">Harga Beli</label>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="single_price">Harga Per Produk</label>
                                            <input v-model="buy_price.single_price" type="number" id="single_price" :readonly="setting.single_price == 1" class="form-control" >
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-center p-0">
                                        <button class="btn btn-sm btn-light" type="button" @click="setting.single_price = !setting.single_price"><i class="fas fa-exchange-alt"></i></button>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="total_price">Harga Total</label>
                                            <input v-model="buy_price.total_price" type="number" id="total_price" :readonly="setting.single_price == 0" class="form-control" >
                                        </div>
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
                                <slot name="select_suplier"></slot>
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

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
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
    data(){
        return {
            products: [],
            selected_category: 0,
            selected_product: null,
            added_products: [],
            amount: 1,
            subtotal: 0,
            buy_price: {
                single_price: 0,
                total_price: 0,
            },
            setting:{
                single_price: false,
            }
        }
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
    watch: {
        'amount': function(val){
            this.applyBuyPrice();
        },
        'buy_price.single_price': function(val) {
            this.applyBuyPrice()
        },
        'buy_price.total_price': function(val) {
            this.applyBuyPrice()
        },
    },
    created() {
        this.products = this.products_model;
    },
    methods: {
        applyBuyPrice(){
            const buy_price_type = this.setting.single_price;
            if(buy_price_type === true){
                this.totalPrice();
            }else{
                this.singlePrice();
            }
        },
        totalPrice(){
            let totalValue = Number(this.buy_price.total_price);
            let amount = Number(this.amount);
            let price_value = Number(totalValue) / Number(amount);
            this.buy_price.single_price = Number(price_value).toFixed(2);
        },
        singlePrice(){
            let priceValue = Number(this.buy_price.single_price);
            let amount = Number(this.amount);
            let total_value = Number(priceValue) * Number(amount);
            this.buy_price.total_price = Number(total_value).toFixed(2);
        },
        addSelectedProduct: function() {
            if(this.selected_product === null){
                alert('Please select product first');
                return;
            }

            let product = {
                id: this.selected_product.id,
                name: this.selected_product.name,
                amount: Number(this.amount),
                price: Number(this.buy_price.single_price),
                total: this.buy_price.total_price,
            };

            let data_exist = this.added_products.find(product => product.id == this.selected_product.id);
            if(data_exist){
                data_exist.amount += Number(this.amount);
                data_exist.price = Number(this.buy_price.single_price);
                data_exist.total = Number(data_exist.price) * Number(data_exist.amount);

                this.setSubtotal();
            }else{
                this.added_products.push(product);

                this.setSubtotal();
            }

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
                subtotal += Number(product.total);
            });
            this.subtotal = Number(subtotal).toFixed(2);
        },
        onCategoryChange(e){
            let value = e.target.value;
            axios.get('/ajax/getProducts', {
                params: {
                    category: value
                }
            })
            .then(res => {
                this.products = res.data;
                this.selected_category = value;
            })
            .catch(error => {
                console.log(error);
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

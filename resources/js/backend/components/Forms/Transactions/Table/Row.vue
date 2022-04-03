<template>
    <tr>
        <td>{{ add_product.name }}</td>
        <td>
            @<input type="number" v-model="amount" class="form-control form-control-sm" />
        </td>
        <td>
            {{ add_product.price }}
        </td>
        <td>{{ total }}</td>
        <td>
            <button @click="removeProduct()" type="button" class="btn btn-sm btn-danger">
                <i class="fa fa-trash"></i>
            </button>
        </td>
    </tr>
</template>

<script>
export default {
    props: {
        add_product:{
            type: Object
        },
        add_amount: {
            type: Number,
            default: 1,
        },
    },
    data() {
        return {
            total: 0,
            amount: 0,
        }
    },
    watch: {
        amount: function(new_amount) {
            if (new_amount > 0) {
                if(new_amount > this.add_product.quantity){
                    this.amount = this.add_product.quantity;
                    this.total = this.amount * this.add_product.price;
                    alert('Amount cannot be greater than quantity');
                }else{
                    this.total = new_amount * this.add_product.price;
                }
            }else{
                this.total = 0;
                alert('Amount must be greater than 0');
            }
        }
    },
    created() {
        this.amount = this.add_product.amount;
    },
    methods: {
        removeProduct: function() {
            this.$emit('remove-product', this.add_product);
        }
    }
}
</script>

<style>

</style>

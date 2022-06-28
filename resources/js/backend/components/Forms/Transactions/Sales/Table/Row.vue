<template>

</template>

<script>
export default {
    props: {
        added_products: {
            type: Array,
        }
    },
    data() {
        return {
            amount: this.add_product.amount,
            total: 0,
        }
    },
    mounted() {
        this.amount = this.add_product.amount;
        this.total = this.add_product.amount * this.add_product.price;
    },
    watch: {
        amount(new_amount) {
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
        },
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

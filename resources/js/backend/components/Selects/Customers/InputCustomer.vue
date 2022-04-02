<template>
    <div class="form-row">
        <div class="col-md-3">
            <input type="text" v-bind:readonly="customer!=null" name="name" class="form-control" placeholder="First name" v-model="name">
        </div>
        <div class="col-md-3">
            <input type="email" v-bind:readonly="customer!=null" name="email" class="form-control" placeholder="Email" v-model="email">
        </div>
        <div class="col-md-3">
            <input type="text" v-bind:readonly="customer!=null" name="phone" class="form-control" placeholder="Phone" v-model="phone">
        </div>
        <div class="col-md-3">
            <textarea name="address" cols="30" rows="1" v-bind:readonly="customer!=null" class="form-control" placeholder="Address" v-model="address"></textarea>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        customer: {
            type: Object,
            default: null
        }
    },
    data(){
        return {
            name: '',
            email: '',
            phone: '',
            address: '',
        }
    },
    watch: {
        customer() {
            if(this.customer) {
                this.name = this.customer.name;
                this.email = this.customer.email;
                this.phone = this.customer.phone;
                this.address = this.customer.address;
            }else{
                this.name = '';
                this.email = '';
                this.phone = '';
                this.address = '';
            }
        }
    },
}
</script>

<style>

</style>

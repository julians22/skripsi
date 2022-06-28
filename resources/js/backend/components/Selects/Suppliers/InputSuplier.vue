<template>
    <div class="form-row">
        <div class="col-md-3">
            <input type="text" v-bind:readonly="suplier!=null" name="name" class="form-control" placeholder="Name for suplier" v-model="name">
        </div>
        <div class="col-md-3">
            <input type="email" v-bind:readonly="suplier!=null" name="email" class="form-control" placeholder="Email for suplier" v-model="email">
        </div>
        <div class="col-md-3">
            <input type="text" v-bind:readonly="suplier!=null" name="phone" class="form-control" placeholder="Phone for suplier" v-model="phone">
        </div>
        <div class="col-md-3">
            <input type="text" v-bind:readonly="suplier!=null" name="address" class="form-control" placeholder="Address for suplier" v-model="address">
        </div>
    </div>
</template>

<script>
export default {
    props: {
        suplier: {
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
        suplier() {
            if(this.suplier) {
                this.name = this.suplier.name;
                this.email = this.suplier.email;
                this.phone = this.suplier.phone;
                this.address = this.suplier.address;
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

<template>
    <div>
        <input type="text" class="form-control" v-model.lazy="code" :name="identifier" :id="identifier" required @change="onChange">
        <small class="text-danger" v-if="!isValid">{{ message }}
            <span v-if="alternative_code" class="text-bold">Alternative {{alternative_code}} </span>
        </small>
    </div>
</template>

<script>
export default {
    props: {
        placleholder: {
            type: String,
            default: 'Enter code'
        },
        identifier: {
            type: String,
            default: 'code'
        },
        value: {
            type: String,
            default: null
        }
    },
    data() {
        return {
            code: '',
            message: '',
            isValid: false,
            alternative_code: null,
            isLoading : false
        }
    },
    mounted() {
        if (null == this.value) {
            this.getDefaultCode();
        }else{
            this.code = this.value;
        }
    },
    methods: {
        onChange() {
            if (!this.isLoading) {
                this.isLoading = true;
                axios.post('/ajax/checkProductCode', {
                    code: this.code
                })
                .then(response => {
                    if (response.data.status == 'success') {
                        this.isValid = true;
                        this.message = response.data.message;
                    } else {
                        this.isValid = false;
                        this.message = response.data.message;
                    }
                    this.alternative_code = null;
                    this.isLoading = false;
                })
                .catch(error => {
                    console.log(error.response);
                    this.isValid = false;
                    this.message = error.response.data.message ?? 'Kode produk tidak dapat digunakan';
                    const alternative_code = error.response.data.alterative_code ?? null;
                    if (alternative_code) {
                        this.alternative_code = alternative_code;
                    }
                    this.isLoading = false;
                });
            }
        },
        getDefaultCode(){
            axios.get('/ajax/getProductCode').then(response => {
                this.code = response.data.code;
            }).catch(error => {
                console.log(error);

            });
        }
    }

}
</script>

<style>

</style>

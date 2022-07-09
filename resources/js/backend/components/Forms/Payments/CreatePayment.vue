<template>
    <div>
        <div class="alert alert-warning" v-if="!showForm">
            {{ alertMessage }}
            <button @click="showForm = true" type="button" class="btn btn-sm btn-light">
                {{ addBtnText }}
            </button>
        </div>
        <div v-if="showForm">
            <div class="row mb-2">
                <div class="col-md-4">
                    {{ totalLabelText }}
                </div>
                <div class="col-md-8">
                    <strong>
                        {{ grandTotalLabel }}
                    </strong>
                </div>
            </div>
            <div class="form-group row">
                <label for="amount" class="col-form-label col-md-4">{{ fullPaymentLabel }} ?</label>
                <div class="col-md-8 d-flex align-items-center">
                    <label class="c-switch c-switch-pill c-switch-success m-0">
                        <input type="checkbox" class="c-switch-input" v-model="checkFullPayment" checked>
                        <span class="c-switch-slider"></span>
                    </label>
                </div>
            </div>
            <div class="form-group row" v-show="!checkFullPayment">
                <label for="payment" class="col-form-label col-md-4">{{ payAmountLabel }}</label>
                <div class="col-md-8">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Rp</span>
                        </div>
                        <input-number-component name="payment" :form-value="total"></input-number-component>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-secondary" @click="showForm = false">Cancel</button>
            <button type="submit" class="btn btn-primary">{{saveBtnText}}</button>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        grandTotalLabel: {
            type: String,
            required: true
        },
        grandTotal: {
            type: String,
            required: true
        },
        alertMessage: {
            type: String,
            default: ''
        },
        addBtnText: {
            type: String,
            default: ''
        },
        saveBtnText: {
            type: String,
            default: ''
        },
        totalLabelText: {
            type: String,
            default: ''
        },
        fullPaymentLabel: {
            type: String,
            default: ''
        },
        payAmountLabel: {
            type: String,
            default: ''
        }
    },
    data(){
        return{
            showForm: false,
            checkFullPayment: true,
            total: 0
        }
    },
    created(){
        this.total = Number(this.grandTotal)
    }
}
</script>

<style>

</style>

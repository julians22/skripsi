<template>
    <input :class="classForm" v-model.lazy="value" :name="formName" :id="formName" v-number="number" :placeholder="placeholder" required>
</template>

<script>
import {vNumber} from "@coders-tm/vue-number-format";
export default {
    props: {
        formName: {
            type: String,
            default: 'money'
        },
        formValue: {
            type: Number,
            required: true
        },
        placeholder: {
            type: String,
            default: ''
        },
        classForm: {
            type: String,
            default: 'form-control'
        }

    },
    mounted() {
        this.value = Number(this.formValue);
    },
    data(){
        return{
            value: 0,
            number : {
                "decimal": ",",
                "separator": ".",
                "prefix": "",
                "suffix": "",
                "precision": 0,
                "nullValue": "0",
                "masked": false,
                "reverseFill": false,
                "min": 0,
                "prefill": false,
                "minimumFractionDigits": "0"
            }
        }
    },
    directives: {
        number: vNumber,
    },
}
</script>

<style>

</style>

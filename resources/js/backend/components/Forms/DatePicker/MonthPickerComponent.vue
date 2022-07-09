<template>
    <div>
        <date-picker v-model="value2" type="month" placeholder="Custom" value-type="format" @change="handelChange"></date-picker>
    </div>
</template>

<script>

import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
import { useReport } from "../../../../store";


export default {
    components: {
        DatePicker
    },
    data(){
        return {
            value2: '',
        }
    },
    methods: {
        handelChange(value, type) {
            const report = useReport();
            report.$patch({
                month_selected: value,
            });
        }
    }
}
</script>

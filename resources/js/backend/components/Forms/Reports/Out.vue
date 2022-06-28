<template>
    <div>
        <input type="text" :value="startDate" name="start_date" id="start_date" class="d-none" required>
        <input type="text" :value="endDate" name="end_date" id="end_date" class="d-none" required>

        <button class="btn btn-primary">Cetak</button>
    </div>
</template>

<script>
import { useReport } from "../../../../store";

export default {
    data() {
        return {
            isShowBtn: false
        }
    },
    computed: {
        storeReport(){
            return useReport();
        },
        startDate(){
            return this.storeReport.start_date || '';
        },
        endDate(){
            return this.storeReport.end_date || '';
        },
    }
}
</script>

<style>

</style>

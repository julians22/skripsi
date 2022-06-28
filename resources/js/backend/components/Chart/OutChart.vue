<template>
    <div>
        <Bar
            :chart-options="chartOptions"
            :chart-data="chartData"
            :chart-id="chartId"
            :dataset-id-key="datasetIdKey"
            :plugins="plugins"
            :css-classes="cssClasses"
            :styles="styles"
            :width="width"
            :height="height"
            v-if="isApply"
        />
        <div class="alert alert-warning" v-else>Harap pilih rentang waktu terlebih dahulu</div>
    </div>
</template>

<script>
import { useReport } from "../../../store";
import { Bar } from 'vue-chartjs/legacy'
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js';

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

export default {
    components: {
        Bar
    },
    props: {
        chartId: {
            type: String,
            default: 'bar-chart'
        },
        datasetIdKey: {
            type: String,
            default: 'label'
        },
        width: {
            type: Number,
            default: 400
        },
        height: {
            type: Number,
            default: 100
        },
        cssClasses: {
            default: '',
            type: String
        },
        styles: {
            type: Object,
            default: () => {}
        },
        plugins: {
            type: Object,
            default: () => {}
        }
    },
    data() {
        return {
            chartData: {
                labels: [ 'January', 'February', 'March' ],
                datasets: [ { data: [40, 20, 12] } ]
            },
            chartOptions: {
                responsive: true
            },
            reports: []
        }
    },
    watch: {
        isApply: function (val) {
            if (val) {
                this.getSales();
            }
        }
    },
    computed: {
        storeReport(){
            return useReport();
        },
        isApply(){
            return this.storeReport.isApply;
        },
    },
    methods: {
        getSales(){
            axios.get('/ajax/getSales', {
                params: {
                    start_date: this.storeReport.start_date,
                    end_date: this.storeReport.end_date
                }
            })
            .then(response => {
                const data = response.data;
                if (data.status === 'success') {
                    let reports = data.reports;
                    if (reports.length > 0) {
                        this.reports = data.reports
                    }else{
                        this.reports = [];
                        alert("Coba dengan rentang waktu lain");
                    }
                }else{
                    alert("Coba dengan rentang waktu lain");
                }
            })
            .catch(error => {
                console.log(error);
            });
        }
    }
}
</script>

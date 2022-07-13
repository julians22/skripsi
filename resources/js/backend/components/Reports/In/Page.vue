<template>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group row">
                <label for="report_type" class="col-md-3 col-form-label text-md-right">Data Laporan Pembelian</label>
                <div class="col-md-9">
                    <select name="report_type" id="report_type" class="form-control" v-model="report_type">
                        <option value="invoice">Per Faktur</option>
                        <option value="product">Per Produk</option>
                    </select>
                </div>
            </div>

            <div class="form-group row" v-cloak v-show="report_type == 'product'">
                <label for="product" class="col-md-3 col-form-label text-md-right">Pilih Barang</label>
                <div class="col-md-9">
                    <select name="product" id="product" class="form-control" v-model="product">
                        <option value="">Pilih Barang</option>
                        <option v-for="product in products" :value="product.product.id" :key="product.product.id">{{ product.product.name }}</option>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="date" class="col-form-label col-md-3 text-md-right">Pilih Tanggal</label>
                <div class="col-md-9">
                    <select-date></select-date>
                </div>
            </div>

            <div class="form-group row">
                <label for="show" class="col-form-label col-md-3 text-md-right">Tampilkan Dengan</label>
                <div class="col-md-9">
                    <select v-model="show_report" class="form-control">
                        <option value="monthly">Bulanan</option>
                        <option value="daily">Harian</option>
                    </select>
                </div>
            </div>

            <div class="form-group text-right">
                <button type="button" @click="sendData()" class="btn btn-primary" v-bind:disabled="isLoading" v-bind:class="{disabled : isLoading}">Kirim</button>
            </div>
        </div> <!-- col -->

        <div class="col-md-12" v-if="chartIsValid">
            <div class="row">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Transaksi</h5>
                            <h6 class="card-subtitle mb-2 text-muted">{{ extarctMoney(total_purchase) }}</h6>
                        </div>
                    </div>
                    <div class="card" v-if="purchase_average">
                        <div class="card-body">
                            <h5 class="card-title">{{ average_label }} </h5>
                            <h6 class="card-subtitle mb-2 text-muted">{{ extarctMoney(purchase_average) }}</h6>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Jumlah Transaksi</h5>
                            <h6 class="card-subtitle mb-2 text-muted">{{ total_transaction }}</h6>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Jumlah Produk Dibeli</h5>
                            <h6 class="card-subtitle mb-2 text-muted">{{ total_product }}</h6>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <LineChartGen
                        :chart-options="chartOptions"
                        :chart-data="chartData"
                        :chart-id="chartId"
                        :dataset-id-key="datasetIdKey"
                        :plugins="plugins"
                        :css-classes="cssClasses"
                        :styles="styles"
                        :height="200"
                    />
                </div>
            </div>
        </div>

        <!-- <div v-else> -->
            <div class="col-md-12" v-else>
                <div class="alert alert-warning">
                    <p>
                        {{ message }}
                    </p>
                </div>
            </div>
        <!-- </div> -->

    </div> <!-- row -->
</template>

<script>
import { useReport } from "../../../../store";

import { Bar, Line as LineChartGen } from 'vue-chartjs/legacy'
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  LineElement,
  LinearScale,
  CategoryScale,
  PointElement
} from 'chart.js'

ChartJS.register(
  Title,
  Tooltip,
  Legend,
  LineElement,
  LinearScale,
  CategoryScale,
  PointElement
)

import { rupiah } from "../../../../utils/money";

import MonthPicker from "../../Forms/DatePicker/MonthPickerComponent.vue";

export default {
    props: {
        products: {
            type: Array,
            required: true
        },
        chartId: {
            type: String,
            default: 'line-chart'
        },
        datasetIdKey: {
            type: String,
            default: 'label'
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
    data(){
        return {
            report_type: 'invoice',
            show_report: 'monthly',
            product: '',
            total_purchase: 0,
            total_transaction: 0,
            total_product: 0,
            purchase_average: 0,
            average_label: '',
            chartIsValid: false,
            isLoading: false,
            message: 'Silahkan klik tombol kirim untuk mengambil data',
            chartData: {
                labels: [],
                datasets: [
                    {
                        label: 'Pembelian',
                        data: [],
                        backgroundColor: '#3330E4',
                        borderColor: '#3330E4',
                        yAxisID: 'y',
                        order: 1,
                    },
                    {
                        label: 'Jumlah Transaksi',
                        data: [],
                        borderColor: '#F637EC',
                        backgroundColor: '#F637EC',
                        yAxisID: 'y1',
                        order: 1,
                    },
                    {
                        label: 'Produk Terjual',
                        data: [],
                        backgroundColor: '#FBB454',
                        borderColor: '#FBB454',
                        yAxisID: 'y2',
                        order: 2,
                    }
                ]
            },
            chartOptions: {
                responsive: true,
                interaction: {
                    mode: 'index',
                    intersect: true,
                },
                stacked: false,
                scales: {
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        id: 'y',
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        id: 'y1',
                        grid: {
                            drawOnChartArea: false, // only want the grid lines for one axis to show up
                        },
                    },
                    y2: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        id: 'y2',
                        grid: {
                            drawOnChartArea: false, // only want the grid lines for one axis to show up
                        },
                    },
                }
            },
        }
    },
    components: { Bar, LineChartGen, MonthPicker },
    mounted(){
        this.storeReport.report_type = this.report_type;
        this.storeReport.show_report = this.show_report;
        this.storeReport.product = this.product;
    },
    watch: {
        report_type: function(val){
            this.storeReport.report_type = val;
        },
        show_report: function(val){
            this.storeReport.show_report = val;
        }
    },
    computed: {
        storeReport(){
            return useReport();
        },
    },

    methods: {
        sendData(){
            let data = this.collectData();
            this.clearData();
            this.isLoading = true;

            if (data.report_type == 'product') {
                if (data.product == '') {
                    this.message = 'Silahkan pilih barang terlebih dahulu';
                    this.isLoading = false;
                    return;
                }
            }

            let config = {
                method: 'GET',
                url: '/ajax/reports/purchase',
                params: data,
                headers: {
                    'Content-Type': 'application/json'
                }
            };

            axios(config)
                .then(response => {
                    const data = response.data.result.data;
                    if (response.data.status == 'success') {
                        this.passData(data);
                        this.chartIsValid = true;
                    }else{
                        this.chartIsValid = false;
                    }

                    this.message = response.data.message;
                    this.isLoading = false;
                })
                .catch(error => {
                    this.message = 'Terjadi kesalahan pada server';
                    this.isLoading = false;
                    console.log(error);
                });
        },
        collectData(){
            return {
                report_type: this.report_type,
                product: this.product,
                show_report: this.show_report,
                start_date: this.storeReport.start_date,
                end_date: this.storeReport.end_date,
            }
        },
        passData(data){
            for (const key in data.purchase) {
                this.chartData.labels.push(key);

                this.chartData.datasets[0].data.push(data.purchase[key]);
                this.chartData.datasets[1].data.push(data.total[key]);
                this.chartData.datasets[2].data.push(data.product[key]);

                this.total_purchase += data.purchase[key];
                this.total_transaction += data.total[key];
                this.total_product += data.product[key];
            }
            this.purchase_average = data.average;
            this.average_label = data.average_label;
        },
        clearData(){
            this.chartData.labels = [];
            this.chartData.datasets[0].data = [];
            this.chartData.datasets[1].data = [];
            this.chartData.datasets[2].data = [];
            this.chartIsValid = false;
            this.total_purchase = 0;
            this.total_transaction = 0;
            this.total_product = 0;
            this.purchase_average = 0;
        },
        extarctMoney(val){
            return rupiah(val);
        }
    }


}
</script>

<style lang="css" scoped>
    .form-group :deep() .input-date {
        width: 100%;
    }
</style>

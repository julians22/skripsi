<template>
    <div>
        <vue-date-picker @selected="datePickerEnvent" :init-range="initRange" :captions="config.captions" :righttoleft="align === 'left' ? 'false' : 'true'" :presetRanges="config.presetRanges"></vue-date-picker>
    </div>
</template>

<script>
import { useReport } from "../../../../store";
import { formatDate } from "../../../../utils/date";

export default {
    props: {
        align: {
            type: String,
            default: 'left'
        },
    },
    created(){
        const report = useReport();
        const dateRange = this.config.presetRanges.today().dateRange;
        this.initRange.start = dateRange.start;
        this.initRange.end = dateRange.end;

        const start_date = formatDate(dateRange.start.toDateString());
        const end_date = formatDate(dateRange.end.toDateString());
        report.$patch({
            start_date: start_date,
            end_date: end_date,
            isApply: true
        });
    },
    data(){
        return {
            initRange: {},
            start_date: '',
            end_date: '',
            config: {
                captions: {
                    'title': 'Pilih Tanggal',
                    'ok_button': 'Terapkan'
                },
                presetRanges : {
                    today: function () {
                        const n = new Date()
                        const startToday = new Date(n.getFullYear(), n.getMonth(), n.getDate() + 0, 0, 0)
                        const endToday = new Date(n.getFullYear(), n.getMonth(), n.getDate() + 0, 23, 59)
                        return {
                            label: "Hari ini",
                            active: true,
                            dateRange: {
                                start: startToday,
                                end: endToday
                            }
                        }
                    },
                    yesterday: function () {
                        const n = new Date()
                        const startYesterday = new Date(n.getFullYear(), n.getMonth(), n.getDate() - 1, 0, 0)
                        const endYesterday = new Date(n.getFullYear(), n.getMonth(), n.getDate() - 1, 23, 59)
                        return {
                            label: "Kemarin",
                            active: false,
                            dateRange: {
                                start: startYesterday,
                                end: endYesterday
                            }
                        }
                    },
                    thisMonth: function () {
                        const n = new Date()
                        const startThisMonth = new Date(n.getFullYear(), n.getMonth(), 1, 0, 0)
                        const endThisMonth = new Date(n.getFullYear(), n.getMonth(), n.getDate(), 23, 59)
                        return {
                            label: "Bulan ini",
                            active: false,
                            dateRange: {
                                start: startThisMonth,
                                end: endThisMonth
                            }
                        }
                    },
                    lastMonth: function () {
                        const n = new Date()
                        const month = n.getMonth() - 1
                        const startLastMonth = new Date(n.getFullYear(), month, 1, 0, 0)

                        const lastDateInLastMonth = new Date(n.getFullYear(), month, 0, 23, 59)

                        const endLastMonth = new Date(n.getFullYear(), month, lastDateInLastMonth.getDate(), 23, 59)
                        return {
                            label: "Bulan lalu",
                            active: false,
                            dateRange: {
                                start: startLastMonth,
                                end: endLastMonth
                            }
                        }
                    },
                },
                format: 'dd-MM-yyyy',
            }
        }
    },
    methods: {
        datePickerEnvent(event){
            let start_date = event.start;
            let end_date = event.end;
            start_date = formatDate(start_date.toDateString());
            end_date = formatDate(end_date.toDateString());

            const report = useReport();
            report.$patch({
                start_date: start_date,
                end_date: end_date,
                isApply: true
            });
        }
    }
}
</script>

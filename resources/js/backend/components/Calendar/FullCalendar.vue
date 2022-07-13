<template>
    <div>
        <full-calendar :options="calendarOptions" />
    </div>
</template>

<script>

import FullCalendar from "@fullcalendar/vue";
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'

import idLocale from '@fullcalendar/core/locales/id'

import tippy from 'tippy.js'
import { rupiah } from '../../../utils/money';

export default {
    props : {
        sales : {
            type : Array,
            default : () => []
        },
        purchases : {
            type : Array,
            default : () => []
        },
    },
    components: {
        FullCalendar
    },
    data(){
        return {
            calendarOptions : {
                plugins: [ dayGridPlugin, interactionPlugin ],
                initialView: 'dayGridMonth',
                dateClick: this.handleDateClick,
                events: [],
                locale: idLocale,
                height: '400px',
                eventClick: function(info) {
                    const link = info.event.extendedProps.link;
                    window.location.href = link;
                },
                eventDidMount: (info) => {
                    const description = info.event.extendedProps.description;
                    const grandTotal = info.event.extendedProps.grand_total;
                    const userName = info.event.extendedProps.name;

                    const element = info.el;
                    let htmlListContent = this.makeElement(description, grandTotal, userName);
                    tippy(element, {
                        content: htmlListContent,
                        allowHTML: true,
                        arrow: true,
                        placement: 'top',
                        theme: 'translucent',
                        trigger: 'mouseenter',
                        hideOnClick: false,
                        maxWidth: '800px',
                        animation: 'scale'
                    });
                }
            }
        }
    },
    created(){
        if(this.sales.length > 0 || this.purchases.length > 0){
            this.calendarOptions.events = this.computedEvent();
        }
    },
    methods: {
        handleDateClick: function(arg) {
        //    alert('date click! ' + arg.dateStr)
        },
        makeElement: function(...items) {
            let listWrapper = document.createElement('ul');
            items.forEach(item => {
                let listItem = document.createElement('li');
                listItem.innerHTML = item;
                listWrapper.appendChild(listItem);
            });

            return listWrapper;
        },
        computedEvent : function(){
            let events = [];
            this.sales.forEach(event => {
                events.push({
                    title : 'Penjualan',
                    date : event.created_at,
                    description : event.invoice_number,
                    grand_total : rupiah(event.grand_total),
                    name : event.customer.name,
                    link : '/admin/sales/' + event.id + '/show',
                    url : '/admin/sales/' + event.id + '/show',
                    backgroundColor : '#00bcd4',
                })
            });

            this.purchases.forEach(event => {
                events.push({
                    title : 'Pembelian',
                    date : event.created_at,
                    description : event.invoice_number,
                    grand_total : rupiah(event.total),
                    name : event.supplier.name,
                    link : '/admin/purchase/' + event.id + '/show',
                    url : '/admin/purchase/' + event.id + '/show',
                    backgroundColor : '#ff9800',
                })
            });


            return events;
        }
    }

}
</script>

<style>
    .tippy-content {
        text-align: left;
        max-width: max-content;
    }

    .tippy-content ul {
        padding: 0;
        margin: 0;
        padding-left: 12px;
    }
</style>

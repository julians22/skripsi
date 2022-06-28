import { defineStore } from 'pinia'

export const useStore = defineStore('counter', {
    state: () => {
        return {
            count: 0
        }
    },
    actions: {
        increment() {
          this.count++
        },
    },
});

export const useReport = defineStore('report', {
    state: () => {
        return {
            start_date: '',
            end_date: '',
            isApply: false,
        }
    }
});

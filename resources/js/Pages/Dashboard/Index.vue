<script setup>
import { defineProps } from 'vue';
import Card from '@/Components/Card.vue';
import Default from '@/Layout/Default.vue';

const props = defineProps({
    salesToday: Number,
    revenue: Number,
    expenses: Number,
    chartData: Object
});

let x = {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Monthly Revenue and Expenses'
    },
    xAxis: {
        categories: props.chartData.months // Dynamic months from the backend
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Amount (in IDR)'
        }
    },
    series: [{
        name: 'Revenue',
        data: props.chartData.revenue
    }, {
        name: 'Expenses',
        data: props.chartData.expenses
    }]
}
</script>

<template>
    <Default>
        <div class="flex justify-between border-b items-center border-b-neutral-700">
            <div>Welcome back, Johnny</div>
        </div>
        <div class="flex gap-4">
            <Card class="flex-4/8">
                <div class="flex justify-between text-xs">
                    <div>Sales Today</div>
                    <div>{{ salesToday }}</div>
                </div>
                <div class="flex justify-between">
                    <div class="text-xl font-bold">{{ salesToday }} IDR</div>
                    <i-material-symbols:attach-money-rounded></i-material-symbols:attach-money-rounded>
                </div>
            </Card>
            <Card class="flex-2/8">
                <div class="flex justify-between text-xs">
                    <div>Revenue</div>
                    <i-material-symbols:money-bag></i-material-symbols:money-bag>
                </div>
                <div>{{ revenue }} IDR</div>
            </Card>

            <Card class="flex-2/8">
                <div class="flex justify-between text-xs">
                    <div>Expenses</div>
                    <i-material-symbols:money-bag></i-material-symbols:money-bag>
                </div>
                <div>{{ expenses }} IDR</div>
            </Card>
        </div>

        <highcharts :options="x">
        </highcharts>
    </Default>
</template>

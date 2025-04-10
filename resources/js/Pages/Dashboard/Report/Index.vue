<script setup>
import { defineProps } from 'vue';
import Card from '@/Components/Card.vue';
import Default from '@/Layout/Default.vue';

const props = defineProps({
    salesToday: Number,
    revenue: Number,
    expenses: Number,
    chartData: Object,
    salesByProduct: Array,
    salespersonData: Array,
});

const revenueExpensesChart = {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Revenue and Expenses by Month'
    },
    xAxis: {
        categories: props.chartData.months
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
};

const salesByProductChart = {
    chart: {
        type: 'bar'
    },
    title: {
        text: 'Sales by Product'
    },
    xAxis: {
        categories: props.salesByProduct.map(product => product.product),
        title: {
            text: 'Products'
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Units Sold'
        }
    },
    series: [{
        name: 'Units Sold',
        data: props.salesByProduct.map(product => product.total_sold)
    }]
};

const salesBySalespersonChart = {
    chart: {
        type: 'pie'
    },
    title: {
        text: 'Sales by Salesperson'
    },
    series: [{
        name: 'Sales',
        data: props.salespersonData.map(salesperson => ({
            name: salesperson.salesperson,
            y: salesperson.total_sales
        }))
    }]
};
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

        <div class="flex gap-4 mt-4">
            <Card class="flex-4/8">
                <highcharts :options="revenueExpensesChart"></highcharts>
            </Card>

            <Card class="flex-4/8">
                <highcharts :options="salesByProductChart"></highcharts>
            </Card>
        </div>

        <Card class="mt-4">
            <highcharts :options="salesBySalespersonChart"></highcharts>
        </Card>
    </Default>
</template>

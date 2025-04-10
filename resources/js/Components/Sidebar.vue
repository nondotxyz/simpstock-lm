<script setup>
import { Link } from "@inertiajs/vue3"
</script>

<template>
    <div class="flex flex-col bg-neutral-900 p-2 rounded-lg gap-1 h-screen min-w-40">
        <div class="flex items-center justify-center"><img src="/images/Frame 2.svg" class="w-60 mb-6"></div>
        <Link href="/">
        <div class="flex items-center text-lg">
            <i-material-symbols:home-rounded class="mr-2"></i-material-symbols:home-rounded>
            <span>Home</span>
        </div>
        </Link>
        <Link href="/transaction">
        <div class="flex items-center text-lg">
            <i-material-symbols:receipt-rounded class="mr-2"></i-material-symbols:receipt-rounded>
            Transactions
        </div>
        </Link>
        <Link href="/stocks">
        <div class="flex items-center text-lg">
            <i-material-symbols:box-rounded class="mr-2"></i-material-symbols:box-rounded>
            Stocks
        </div>
        </Link>
        <Link href="/report">
        <div class="flex items-center text-lg">
            <i-material-symbols:table-chart-view-rounded class="mr-2"></i-material-symbols:table-chart-view-rounded>
            Report
        </div>
        </Link>
    </div>
</template>

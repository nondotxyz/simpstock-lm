<script setup>
import { ref, computed } from 'vue';
import Card from '@/Components/Card.vue';
import Default from '@/Layout/Default.vue';

const props = defineProps({
    sales: Array,
});

const search = ref('');
const expandedSaleId = ref(null);

const filteredSales = computed(() =>
    props.sales.filter(s =>
        s.id.toString().includes(search.value.toLowerCase()) // Searching by ID
    )
);

const toggleExpand = (id) => {
    expandedSaleId.value = expandedSaleId.value === id ? null : id;
};
</script>

<template>
    <Default>
        <Card class="p-4">
            <input v-model="search" placeholder="Search by Sale ID..."
                class="mb-4 w-full p-2 bg-neutral-900 rounded-lg" />

            <table class="w-full border border-neutral-700 text-left">
                <thead class="border-b border-neutral-700">
                    <tr>
                        <th class="p-2">ID</th>
                        <th class="p-2">Date</th>
                        <th class="p-2">Total</th>
                        <th class="p-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <template v-for="sale in filteredSales" :key="sale.id">
                        <tr class="border-b border-neutral-700">
                            <td class="p-2">{{ sale.id }}</td>
                            <td class="p-2">{{ sale.date }}</td>
                            <td class="p-2">{{ sale.total }}</td>
                            <td class="p-2">
                                <button @click="toggleExpand(sale.id)"
                                    class="bg-neutral-800 px-2 py-1 rounded cursor-pointer">
                                    {{ expandedSaleId === sale.id ? 'Hide' : 'Show' }} Details
                                </button>
                            </td>
                        </tr>
                        <tr v-if="expandedSaleId === sale.id" class="bg-neutral-800 border-b border-neutral-700">
                            <td colspan="5" class="p-4">
                                <table class="w-full text-sm text-left">
                                    <thead>
                                        <tr>
                                            <th class="p-2">Product</th>
                                            <th class="p-2">Qty</th>
                                            <th class="p-2">Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(detail, i) in sale.details" :key="i"
                                            class="border-t border-neutral-700">
                                            <td class="p-2">{{ detail.product }}</td>
                                            <td class="p-2">{{ detail.quantity }}</td>
                                            <td class="p-2">{{ detail.price }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </Card>
    </Default>
</template>

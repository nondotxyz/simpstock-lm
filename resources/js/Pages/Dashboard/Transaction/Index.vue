<script setup>
import { Link, useForm } from "@inertiajs/vue3";
import Default from '@/Layout/Default.vue';
import Card from '@/Components/Card.vue';
import { ref, computed } from 'vue';
import { humanize } from "@/Utils/humanize";

const props = defineProps({
    products_list: Array, // Products will now be passed as an array of objects
});

const query = ref('');
const showResults = ref(false);
const selectedProducts = ref([]);

const filtered = computed(() => {
    if (!query.value) return [];
    return props.products_list.filter(p =>
        p.name.toLowerCase().includes(query.value.toLowerCase()) // Search by name
    );
});

const selectProduct = (product) => {
    selectedProducts.value.push({
        ...product,
        quantity: 1,
        total: product.price,
    });
    showResults.value = false;
};

const discount = ref(0);
const money = ref(0);

const subtotal = computed(() => {
    return selectedProducts.value.reduce((sum, product) => sum + product.total, 0);
});

const discountedTotal = computed(() => {
    return subtotal.value * (1 - discount.value / 100);
});

const updateTotal = (product) => {
    product.total = product.price * product.quantity;

    if (product.quantity === 0) {
        const index = selectedProducts.value.findIndex(p => p.id === product.id);
        if (index !== -1) {
            selectedProducts.value.splice(index, 1);
        }
    }
    console.log(selectedProducts)
};

const total = computed(() => {
    return selectedProducts.value.reduce((sum, product) => sum + product.total, 0);
});

const change = computed(() => {
    return money.value - discountedTotal.value;
});
</script>

<template>
    <Default>
        <Card class="shadow-lg p-4 rounded-lg bg-neutral-900 text-white">
            <div class="flex justify-between items-center w-full relative">
                <div class="text-lg font-semibold">Product List</div>
                <div class="relative w-64">
                    <input v-model="query" @focus="showResults = true" placeholder="Search products..."
                        class="border px-4 py-2 rounded-lg w-full text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-neutral-800" />
                    <ul v-if="showResults && filtered.length"
                        class="absolute top-10 left-0 right-0 border rounded shadow-xl z-10 bg-neutral-950 text-white">
                        <li v-for="item in filtered" :key="item.id" @click="selectProduct(item)"
                            class="px-4 py-2 hover:bg-neutral-800 cursor-pointer">
                            {{ item.name }}
                        </li>
                    </ul>
                </div>
            </div>
        </Card>

        <div class="flex gap-4 mt-6">
            <Card class="flex-5/7 w-full shadow-lg p-4 rounded-lg bg-neutral-900 text-white">
                <div class="w-full max-h-64 overflow-auto">
                    <table class="w-full table-auto">
                        <thead class="bg-neutral-800">
                            <tr>
                                <th class="py-2 px-4 text-left">Product</th>
                                <th class="py-2 px-4 text-center">Quantity</th>
                                <th class="py-2 px-4 text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="product in selectedProducts" :key="product.id" class="hover:bg-neutral-800">
                                <td class="py-2 px-4">{{ product.name }}</td>
                                <td class="py-2 px-4 text-center">
                                    <input v-model="product.quantity" type="number" min="1"
                                        @input="updateTotal(product)"
                                        class="bg-neutral-800 p-2 rounded-lg w-16 text-center text-white focus:outline-none focus:ring-2 focus:ring-blue-500" />
                                </td>
                                <td class="py-2 px-4 text-right">{{ humanize(product.total) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="flex flex-col items-end w-full border-t border-t-neutral-700 mt-6 pt-4">
                    <div class="font-semibold">Total</div>
                    <div class="text-xl font-bold text-blue-400">{{ humanize(total) }}</div>
                </div>
            </Card>

            <Card class="flex-2/7 flex flex-col gap-4 p-4 w-full shadow-lg rounded-lg bg-neutral-900 text-white">
                <div class="flex items-center gap-4">
                    <label class="min-w-20 font-semibold">Discount</label>
                    <input type="number" v-model="discount"
                        class="bg-neutral-800 p-2 rounded-lg w-32 text-center text-white focus:outline-none focus:ring-2 focus:ring-blue-500" />
                </div>

                <div class="flex flex-col">
                    <div>Sub-total</div>
                    <div class="text-2xl font-bold">{{ humanize(subtotal) }}$</div>
                </div>

                <div class="flex flex-col">
                    <div>Discount</div>
                    <div class="text-2xl font-bold">{{ discount }}%</div>
                </div>

                <div class="flex flex-col">
                    <div>Total</div>
                    <div class="text-2xl font-bold text-blue-400">{{ humanize(discountedTotal) }}$</div>
                </div>

                <div class="flex items-center gap-4">
                    <label class="min-w-20 font-semibold">Money</label>
                    <input type="number"
                        class="bg-neutral-800 p-2 rounded-lg w-32 text-center text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                        v-model="money" />
                </div>

                <div class="flex items-center gap-4">
                    <label class="min-w-20 font-semibold">Change</label>
                    <input type="number"
                        class="bg-neutral-800 p-2 rounded-lg w-32 text-center text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                        v-model="change" />
                </div>

                <Link :href="route('transaction.store', {
                    selectedProducts: selectedProducts,
                    total: discountedTotal
                })"
                    class="mt-6 p-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer">
                Checkout
                </Link>
            </Card>
        </div>

        <Link :href="route('transaction.list')">
        <Card class="shadow-lg p-4 rounded-lg bg-neutral-900 text-white mt-6">
            <div class="text-center font-semibold">List Previous Transactions</div>
        </Card>
        </Link>
    </Default>
</template>

<script setup>
</script>

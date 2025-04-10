<script setup>
import { ref, computed } from 'vue';
import Default from '@/Layout/Default.vue';
import Card from '@/Components/Card.vue';
import { useForm, Link } from "@inertiajs/vue3"

const props = defineProps({
    products: Array
});

const createData = useForm({
    name: "",
    price: "",
    cost: "",
    stock: "",
})

const search = ref('');

const filteredProducts = computed(() =>
    props.products.filter(p =>
        p.name.toLowerCase().includes(search.value.toLowerCase())
    )
);

const removeProduct = (id) => {
};

const goToEdit = (id) => {
    // Hook this up to a route later
    console.log("Go to edit:", id);
};
</script>


<template>
    <Default>
        <div class="flex gap-2">
            <Card class="flex-4/6 p-4">
                <div class="mb-4">
                    <input v-model="search" placeholder="Search products..."
                        class="w-full p-2 bg-neutral-900 rounded-lg" />
                </div>
                <table class="w-full text-left border border-neutral-700">
                    <thead class="border-b border-neutral-700">
                        <tr>
                            <th class="p-2">Name</th>
                            <th class="p-2">Price</th>
                            <th class="p-2">Stock</th>
                            <th class="p-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="product in filteredProducts" :key="product.id" class="border-b border-neutral-700">
                            <td class="p-2">{{ product.name }}</td>
                            <td class="p-2">{{ product.price }}</td>
                            <td class="p-2">{{ product.stock }}</td>
                            <td class="p-2 flex gap-2 items-center justify-center">
                                <Link :href="route('stocks.edit', { product: product.id })"
                                    class="bg-blue-600 p-1 rounded px-4">
                                Edit
                                </Link>
                            </td>
                        </tr>
                    </tbody>
                </table>

            </Card>

            <Card class="flex-2/6 flex-col flex gap-2 p-4">
                <h2 class="text-lg font-bold uppercase">Add NEW PRODUCT</h2>
                <form class="flex flex-col gap-2">
                    <label>
                        <span>Product Name</span>
                        <textarea class="bg-neutral-900 rounded-lg w-full p-2" v-model="createData.name"></textarea>
                    </label>
                    <label class="flex justify-between items-center">
                        <span>Price</span>
                        <input type="number" class="bg-neutral-900 rounded-lg p-2" v-model="createData.price" />
                    </label>
                    <label class="flex justify-between items-center">
                        <span>Cost</span>
                        <input type="number" class="bg-neutral-900 rounded-lg p-2" v-model="createData.cost" />
                    </label>
                    <label class="flex justify-between items-center">
                        <span>Stock</span>
                        <input type="number" class="bg-neutral-900 rounded-lg p-2" v-model="createData.stock" />
                    </label>
                    <button type="button" @click.prevent="createData.post(route('stocks.create'))"
                        class="p-2 bg-neutral-900 rounded-lg">
                        SUBMIT
                    </button>

                </form>
            </Card>
        </div>
    </Default>
</template>

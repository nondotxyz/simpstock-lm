<script setup>
import { onMounted } from 'vue';
import { useForm } from "@inertiajs/vue3"
import Default from '@/Layout/Default.vue';
import Card from '@/Components/Card.vue';

const props = defineProps({
    product: Object
});

const form = useForm({
    name: '',
    price: '',
    stock: '',
    processing: false
});

onMounted(() => {
    if (props.product) {
        form.name = props.product.name || '';
        form.price = props.product.price || '';
        form.stock = props.product.stock || '';
    }
});
</script>

<template>
    <Default>
        <Card>
            <h2 class="text-xl font-bold">Edit Product</h2>

            <form class="flex flex-col gap-2">
                <div>
                    <label for="name" class="block">Product Name</label>
                    <textarea v-model="form.name" type="text" id="name"
                        class="bg-neutral-900 rounded-lg p-2 w-full"></textarea>
                </div>

                <div>
                    <label for="price" class="block">Price</label>
                    <input v-model="form.price" type="number" id="price" class="bg-neutral-900 rounded-lg p-2 w-full" />
                </div>

                <div>
                    <label for="stock" class="block">Stock</label>
                    <input v-model="form.stock" type="number" id="stock" class="bg-neutral-900 rounded-lg p-2 w-full" />
                </div>

                <button class="p-2 bg-neutral-900 rounded-lg mt-4 cursor-pointer"
                    @click.prevent="form.get(route('stocks.update', { product: props.product.id }))">Save</button>
            </form>
        </Card>
    </Default>
</template>

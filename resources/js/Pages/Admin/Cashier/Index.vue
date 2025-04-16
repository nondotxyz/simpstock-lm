<script setup>
import { ref, computed } from 'vue';
import Default from '@/Layout/Default.vue';
import Card from '@/Components/Card.vue';
import { useForm, Link } from "@inertiajs/vue3"

import { router } from '@inertiajs/vue3'

const props = defineProps({
    cashiers: Array
});

const createData = useForm({
    name: "",
    telephone: "",
    password: "",
})

const search = ref('');

const filteredCashiers = computed(() =>
    props.cashiers.filter(c =>
        c.name.toLowerCase().includes(search.value.toLowerCase())
    )
);


const deleteCashier = (id) => {
    if (confirm("Delete this cashier?")) {
        router.delete(route('cashiers.destroy', { cashier: id }))
    }
}

</script>

<template>
    <Default>
        <div class="flex gap-2">
            <Card class="flex-4/6 p-4">
                <div class="mb-4">
                    <input v-model="search" placeholder="Search cashiers..."
                        class="w-full p-2 bg-neutral-900 rounded-lg" />
                </div>
                <table class="w-full text-left border border-neutral-700">
                    <thead class="border-b border-neutral-700">
                        <tr>
                            <th class="p-2">Name</th>
                            <th class="p-2">Telephone</th>
                            <th class="p-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="cashier in filteredCashiers" :key="cashier.id" class="border-b border-neutral-700">
                            <td class="p-2">{{ cashier.name }}</td>
                            <td class="p-2">{{ cashier.telephone }}</td>
                            <td class="p-2 flex gap-2 items-center justify-center">
                                <Link :href="route('cashiers.edit', { cashier: cashier.id })"
                                    class="bg-blue-600 p-1 rounded px-4">
                                Edit
                                </Link>
                                <button @click="deleteCashier(cashier.id)" class="bg-red-600 p-1 rounded px-4">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </Card>

            <Card class="flex-2/6 flex-col flex gap-2 p-4">
                <h2 class="text-lg font-bold uppercase">Add NEW CASHIER</h2>
                <form class="flex flex-col gap-2">
                    <label>
                        <span>Cashier Name</span>
                        <textarea class="bg-neutral-900 rounded-lg w-full p-2" v-model="createData.name"></textarea>
                    </label>
                    <label class="flex justify-between items-center">
                        <span>Telephone</span>
                        <input type="text" class="bg-neutral-900 rounded-lg p-2" v-model="createData.telephone" />
                    </label>
                    <label class="flex justify-between items-center">
                        <span>Password</span>
                        <input type="password" class="bg-neutral-900 rounded-lg p-2" v-model="createData.password" />
                    </label>
                    <button type="button" @click.prevent="createData.post(route('cashiers.create'))"
                        class="p-2 bg-neutral-900 rounded-lg">
                        SUBMIT
                    </button>
                </form>
            </Card>
        </div>
    </Default>
</template>

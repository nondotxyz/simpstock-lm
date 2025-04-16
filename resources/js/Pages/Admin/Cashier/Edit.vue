<script setup>
import { useForm } from '@inertiajs/vue3'
import Default from '@/Layout/Default.vue'

const props = defineProps({
    cashier: Object
})

const form = useForm({
    name: props.cashier.name,
    telephone: props.cashier.telephone,
    password: ''
})

const submit = () => {
    form.put(route('cashiers.update', { cashier: props.cashier.id }))
}
</script>

<template>
    <Default>
        <div class="max-w-md mx-auto mt-10 p-6 bg-neutral-900 rounded-lg">
            <h1 class="text-xl font-bold mb-4">Edit Cashier</h1>
            <form @submit.prevent="submit" class="flex flex-col gap-4">
                <label>
                    <span>Name</span>
                    <input v-model="form.name" class="w-full p-2 bg-neutral-800 rounded" />
                </label>
                <label>
                    <span>Telephone</span>
                    <input v-model="form.telephone" class="w-full p-2 bg-neutral-800 rounded" />
                </label>
                <label>
                    <span>Password (leave blank to keep current)</span>
                    <input type="password" v-model="form.password" class="w-full p-2 bg-neutral-800 rounded" />
                </label>
                <button type="submit" class="p-2 bg-blue-600 rounded hover:bg-blue-500">
                    Save Changes
                </button>
            </form>
        </div>
    </Default>
</template>

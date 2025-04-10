<script setup>
import { ref, watch } from 'vue';
import { usePage } from '@inertiajs/vue3';
import Sidebar from '@/Components/Sidebar.vue';
import Toast from '@/Components/Toast.vue';

const page = usePage();
const errors = ref([]);

watch(() => page.props.errors, (newErrors) => {
    errors.value = Object.values(newErrors);
});
</script>

<template>
    <div class="flex">
        <Sidebar class="h-screen sticky top-0" />
        <div class="flex flex-1 px-4 flex-col gap-4 pt-10">
            <slot></slot>
        </div>

        <div class="fixed top-4 right-4 z-50 flex flex-col gap-2">
            <Toast v-for="(error, i) in errors" :key="i" :message="error" />
        </div>
    </div>
</template>

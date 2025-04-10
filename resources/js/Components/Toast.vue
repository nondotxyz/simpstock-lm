<template>
    <transition name="fade">
        <div v-if="visible" class="fixed top-5 right-5 bg-red-600 text-white px-4 py-2 rounded shadow-lg z-50">
            {{ message }}
        </div>
    </transition>
</template>

<script setup>
import { ref, watchEffect } from 'vue';

const props = defineProps({
    message: String,
    duration: {
        type: Number,
        default: 3000
    }
});

const visible = ref(true);

watchEffect(() => {
    if (visible.value) {
        setTimeout(() => visible.value = false, props.duration);
    }
});
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>

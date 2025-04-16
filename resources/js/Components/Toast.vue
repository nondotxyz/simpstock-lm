<template>
    <transition name="fade">
        <div v-if="visible" class="bg-red-600 text-white px-4 py-2 rounded shadow-lg z-50" role="alert">
            {{ message }}
        </div>
    </transition>
</template>

<script setup>
import { ref, watch, onMounted, onBeforeUnmount } from 'vue';

const props = defineProps({
    message: {
        type: String,
        default: ''
    },
    duration: {
        type: Number,
        default: 3000
    },
    show: {
        type: Boolean,
        default: false
    }
});

const emit = defineEmits(['update:show']);
const visible = ref(false);
let timeoutId = null;

const hideToast = () => {
    visible.value = false;
    emit('update:show', false);
};

const showToast = () => {
    if (timeoutId) {
        clearTimeout(timeoutId);
        timeoutId = null;
    }

    visible.value = true;

    if (props.duration > 0) {
        timeoutId = setTimeout(hideToast, props.duration);
    }
};

watch(() => props.show, (newVal) => {
    if (newVal) {
        showToast();
    } else {
        hideToast();
    }
});

onMounted(() => {
    if (props.show) {
        showToast();
    }
});

onBeforeUnmount(() => {
    if (timeoutId) {
        clearTimeout(timeoutId);
    }
});
</script>

<style>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
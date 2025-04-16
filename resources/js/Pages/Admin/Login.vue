<script setup>
import { useForm } from '@inertiajs/vue3';

const loginData = useForm({
    username: "",
    password: "",
})
</script>

<template>
    <div class="flex h-dvh items-center justify-center flex-col">
        <div class="bg-neutral-900 p-4">
            <div class="flex items-center flex-col">
                <div>Welcome to</div>
                <img src="/images/Frame 2.svg" class="h-24">
                <div>Admin panel</div>
            </div>
            <div class="flex flex-col gap-2 mt-10">
                <input type="text" class="bg-neutral-800 w-full p-2" placeholder="Username"
                    v-model="loginData.username">
                <input type="password" class="bg-neutral-800 w-full p-2" placeholder="Password"
                    v-model="loginData.password">
            </div>
            <div class="flex items-center mt-10">
                <button class="w-full bg-blue-400 p-2 cursor-pointer"
                    @click.prevent="loginData.post(route('admin.authenticate'))">LOGIN</button>
            </div>
        </div>
    </div>
</template>
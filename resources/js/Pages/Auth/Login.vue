<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import { Head, Link, useForm } from '@inertiajs/inertia-vue3'
import Button from '@/Components/Button.vue'

defineProps({
    canResetPassword: Boolean,
    status: String,
})

const form = useForm({
    email: '',
    password: '',
    remember: false,
})

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    })
}
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <form
            @submit.prevent="submit"
            class="px-4 pt-6 pb-8 bg-gray-900 border-4 border-gray-600 w-full sm:max-w-[470px] sm:px-12 sm:pt-7"
        >
            <h1 class="text-3xl">Login</h1>
            <p>
                <span class="opacity-50">Don't have an account?</span>
                <Link :href="route('register')" class="ml-1">Create one</Link>
            </p>
            <div class="mt-6">
                <label class="block" for="email">Email</label>
                <input
                    class="w-full mt-1 border-4 bg-gray-800 border-black focus:border-red-500 focus:ring-0"
                    v-model="form.email"
                    type="email"
                    id="email"
                    required
                    autocomplete="username"
                    autofocus
                />
                <p v-if="form.errors.email" class="mt-1 text-red-400">
                    {{ form.errors.email }}
                </p>
            </div>
            <div class="mt-6">
                <label class="block" for="password">Password</label>
                <input
                    class="w-full mt-1 border-4 bg-gray-800 border-black focus:border-red-500 focus:ring-0"
                    v-model="form.password"
                    type="password"
                    id="password"
                    required
                    autocomplete="current-password"
                />
                <p v-if="form.errors.password" class="mt-1 text-red-400">
                    {{ form.errors.password }}
                </p>
            </div>
            <Button :loading="form.processing" class="mt-8 sm:w-[201px]"
                >Login</Button
            >
            <div class="text-center mt-8">
                <Link :href="route('password.request')"
                    >Forgot your password?</Link
                >
            </div>
        </form>
    </GuestLayout>
</template>

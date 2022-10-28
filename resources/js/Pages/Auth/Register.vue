<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import Button from '@/Components/Button.vue'
import { Head, Link, useForm } from '@inertiajs/inertia-vue3'

const form = useForm({
    username: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
})

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    })
}
</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <form
            @submit.prevent="submit"
            class="px-4 pt-6 pb-8 bg-gray-900 border-4 border-gray-600 w-full sm:max-w-[470px] sm:px-12 sm:pt-7"
        >
            <h1 class="text-3xl">Register</h1>
            <p>
                <span class="opacity-50">Already have an account?</span>
                <Link :href="route('login')" class="ml-1">Login</Link>
            </p>
            <div class="mt-6">
                <label class="block" for="username">Username</label>
                <input
                    class="w-full mt-1 border-4 bg-gray-800 border-black focus:border-red-500 focus:ring-0"
                    v-model="form.username"
                    type="text"
                    id="username"
                    required
                    autocomplete="username"
                    autofocus
                />
                <p v-if="form.errors.username" class="mt-1 text-red-400">
                    {{ form.errors.username }}
                </p>
            </div>
            <div class="mt-6">
                <label class="block" for="email">Email</label>
                <input
                    class="w-full mt-1 border-4 bg-gray-800 border-black focus:border-red-500 focus:ring-0"
                    v-model="form.email"
                    type="text"
                    id="email"
                    required
                    autocomplete="email"
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
                    autocomplete="password"
                />
                <p v-if="form.errors.password" class="mt-1 text-red-400">
                    {{ form.errors.password }}
                </p>
            </div>
            <div class="mt-6">
                <label class="block" for="password_confirmation">
                    Confirm password
                </label>
                <input
                    class="w-full mt-1 border-4 bg-gray-800 border-black focus:border-red-500 focus:ring-0"
                    v-model="form.password_confirmation"
                    type="password"
                    id="password_confirmation"
                    required
                    autocomplete="password_confirmation"
                    autofocus
                />
                <p
                    v-if="form.errors.password_confirmation"
                    class="mt-1 text-red-400"
                >
                    {{ form.errors.password_confirmation }}
                </p>
            </div>
            <Button :loading="form.processing" class="mt-8 sm:w-[219px]">
                Register
            </Button>
        </form>
    </GuestLayout>
</template>

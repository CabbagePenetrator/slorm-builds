<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import Button from '@/Components/Button.vue'
import { Head, Link, useForm } from '@inertiajs/inertia-vue3'
import GuestInputField from '@/Components/GuestInputField.vue';

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
            <h2 class="text-3xl">Register</h2>
            <p>
                <span class="opacity-50">Already have an account?</span>
                <Link :href="route('login')" class="ml-1">Login</Link>
            </p>

            <div class="mt-6 flex flex-col gap-6">
                <GuestInputField
                    title="Username"
                    v-model="form.username"
                    :error="form.errors.username"
                    required
                    autofocus
                    auto-complete="username"
                />

                <GuestInputField
                    title="Email"
                    v-model="form.email"
                    :error="form.errors.email"
                    required
                    auto-complete="email"
                />

                <GuestInputField
                    title="Password"
                    v-model="form.password"
                    :error="form.errors.password"
                    type="password"
                    required
                    auto-complete="password"
                />

                <GuestInputField
                    title="Password"
                    v-model="form.password_confirmation"
                    :error="form.errors.password_confirmation"
                    type="password"
                    required
                    auto-complete="password_confirmation"
                />
            </div>

            <Button :loading="form.processing" class="mt-8 sm:w-[219px]">
                Register
            </Button>
        </form>
    </GuestLayout>
</template>

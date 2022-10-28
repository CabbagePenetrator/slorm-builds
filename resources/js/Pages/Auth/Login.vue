<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import { Head, Link, useForm } from '@inertiajs/inertia-vue3'
import Button from '@/Components/Button.vue'
import GuestInputField from '@/Components/GuestInputField.vue'

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
            class="
                px-4
                pt-6
                pb-8
                bg-gray-900
                border-4 border-gray-600
                w-full
                sm:max-w-[470px] sm:px-12 sm:pt-7
            "
        >
            <h2 class="text-3xl">Login</h2>
            <p>
                <span class="opacity-50">Don't have an account?</span>
                <Link :href="route('register')" class="ml-1">Create one</Link>
            </p>

            <div class="mt-6 flex flex-col gap-6">
                <GuestInputField
                    v-model="form.email"
                    :error="form.errors.email"
                    title="Email"
                    type="email"
                    auto-complete="username"
                    required
                    autofocus
                />
                <GuestInputField
                    v-model="form.password"
                    :error="form.errors.password"
                    title="Password"
                    type="password"
                    auto-complete="current-password"
                    required
                />
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

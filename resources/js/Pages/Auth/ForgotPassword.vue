<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import Button from '@/Components/Button.vue'
import { Head, useForm } from '@inertiajs/inertia-vue3'

defineProps({
    status: String,
})

const form = useForm({
    email: '',
})

const submit = () => {
    form.post(route('password.email'))
}
</script>

<template>
    <GuestLayout>
        <Head title="Forgot Password" />

        <form
            @submit.prevent="submit"
            class="px-4 pt-6 pb-8 bg-gray-900 border-4 border-gray-600 w-full sm:max-w-[470px] sm:px-12 sm:pt-7"
        >
            <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                {{ status }}
            </div>

            <h1 class="text-3xl">Forgot your password?</h1>
            <p class="opacity-50">
                No problem. Just let us know your email address and we will
                email you a password reset link that will allow you to choose a
                new one.
            </p>
            <div class="mt-6">
                <label class="block" for="email">Email</label>
                <input
                    class="w-full mt-1 border-4 bg-gray-800 border-black focus:border-red-500 focus:ring-0"
                    v-model="form.email"
                    type="text"
                    id="email"
                    required
                    autocomplete="email"
                    autofocus
                />
                <p v-if="form.errors.email" class="mt-1 text-red-400">
                    {{ form.errors.email }}
                </p>
            </div>
            <Button :loading="form.processing" class="mt-8">
                Email password reset link
            </Button>
        </form>
    </GuestLayout>
</template>

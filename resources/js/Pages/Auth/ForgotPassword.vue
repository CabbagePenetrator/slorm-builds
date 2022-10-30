<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import Button from '@/Components/Button.vue'
import { Head, useForm } from '@inertiajs/inertia-vue3'
import GuestInputField from '@/Components/GuestInputField.vue'

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
      class="w-full border-4 border-gray-600 bg-gray-900 px-4 pt-6 pb-8 sm:max-w-[470px] sm:px-12 sm:pt-7"
    >
      <p
        v-if="status"
        class="mb-4 text-sm font-medium text-green-600"
      >
        {{ status }}
      </p>

      <h2 class="text-3xl">Forgot your password?</h2>
      <p class="opacity-50">
        No problem. Just let us know your email address and we will email you a
        password reset link that will allow you to choose a new one.
      </p>

      <GuestInputField
        class="mt-6"
        title="Email"
        v-model="form.email"
        :error="form.errors.email"
        type="email"
        auto-complete="email"
        autofocus
        required
      />

      <Button
        :loading="form.processing"
        class="mt-8"
      >
        Email password reset link
      </Button>
    </form>
  </GuestLayout>
</template>

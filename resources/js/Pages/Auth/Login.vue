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

    <p
      v-if="status"
      class="mb-4 text-sm font-medium text-green-600"
    >
      {{ status }}
    </p>

    <form
      @submit.prevent="submit"
      class="w-full border-4 border-gray-600 bg-gray-900 px-4 pt-6 pb-8 sm:max-w-[470px] sm:px-12 sm:pt-7"
    >
      <h2 class="text-3xl">Login</h2>
      <p>
        <span class="opacity-50">Don't have an account?</span>
        <Link
          :href="route('register')"
          class="ml-1"
          >Create one</Link
        >
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

      <Button
        :loading="form.processing"
        class="mt-8 sm:w-[201px]"
      >
        Login
      </Button>

      <div class="mt-8 text-center">
        <Link :href="route('password.request')"> Forgot your password? </Link>
      </div>
    </form>
  </GuestLayout>
</template>

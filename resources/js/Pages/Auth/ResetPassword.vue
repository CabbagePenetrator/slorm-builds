<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import { Head, useForm } from '@inertiajs/inertia-vue3'
import Button from '@/Components/Button.vue'

const props = defineProps({
  email: String,
  token: String,
})

const form = useForm({
  token: props.token,
  email: props.email,
  password: '',
  password_confirmation: '',
})

const submit = () => {
  form.post(route('password.update'), {
    onFinish: () => form.reset('password', 'password_confirmation'),
  })
}
</script>

<template>
  <GuestLayout>
    <Head title="Reset Password" />

    <form
      @submit.prevent="submit"
      class="w-full border-4 border-gray-600 bg-gray-900 px-4 pt-6 pb-8 sm:max-w-[470px] sm:px-12 sm:pt-7"
    >
      <h1 class="text-3xl">Reset password</h1>
      <div class="mt-6">
        <label
          class="block"
          for="email"
          >Email</label
        >
        <input
          class="mt-1 w-full border-4 border-black bg-gray-800 focus:border-red-500 focus:ring-0"
          v-model="form.email"
          type="text"
          id="email"
          required
          autocomplete="email"
          autofocus
        />
        <p
          v-if="form.errors.email"
          class="mt-1 text-red-400"
        >
          {{ form.errors.email }}
        </p>
      </div>
      <div class="mt-6">
        <label
          class="block"
          for="password"
          >Password</label
        >
        <input
          class="mt-1 w-full border-4 border-black bg-gray-800 focus:border-red-500 focus:ring-0"
          v-model="form.password"
          type="password"
          id="password"
          required
          autocomplete="new-password"
        />
        <p
          v-if="form.errors.password"
          class="mt-1 text-red-400"
        >
          {{ form.errors.password }}
        </p>
      </div>
      <div class="mt-6">
        <label
          class="block"
          for="password_confirmation"
          >Confirm password</label
        >
        <input
          class="mt-1 w-full border-4 border-black bg-gray-800 focus:border-red-500 focus:ring-0"
          v-model="form.password_confirmation"
          type="password"
          id="password_confirmation"
          required
          autocomplete="new-password"
        />
        <p
          v-if="form.errors.password_confirmation"
          class="mt-1 text-red-400"
        >
          {{ form.errors.password_confirmation }}
        </p>
      </div>
      <Button
        :loading="form.processing"
        class="mt-8 sm:w-[275px]"
      >
        Reset Password
      </Button>
    </form>
  </GuestLayout>
</template>

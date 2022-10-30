<script lang="ts" setup>
defineProps<{
  modelValue: string
  title: string
  error?: string
  type?: 'password' | 'text' | 'email'
  autoComplete?: string
  required?: boolean
  autofocus?: boolean
}>()

const emit = defineEmits<{
  (e: 'update:modelValue', value: string): void
}>()

const onInput = (payload: Event) => {
  if (payload.target instanceof HTMLInputElement) {
    emit('update:modelValue', payload.target.value)
  }
}
</script>

<template>
  <div class="flex flex-col gap-1">
    <label class="flex flex-col gap-1">
      <span>{{ title }}</span>
      <input
        class="w-full border-4 border-black bg-gray-800 focus:border-red-500 focus:ring-0"
        :value="modelValue"
        @input="onInput"
        :type="type ?? 'text'"
        :required="required"
        :autocomplete="autoComplete"
        :autofocus="autofocus"
      />
    </label>
    <p
      v-if="error"
      class="text-red-400"
    >
      {{ error }}
    </p>
  </div>
</template>

<script setup lang="ts">
defineProps<{
  loading?: boolean
  type?: 'submit' | 'button'
}>()
</script>

<template>
  <button
    :type="type ?? 'submit'"
    :disabled="loading"
    class="relative grid h-[52px] w-full place-content-center gap-x-9 border-t-8 border-b-8 border-t-red-400 border-b-red-600 bg-red-500 text-center text-lg font-normal [border-style:inset] before:absolute before:top-0 before:left-0 before:h-full before:translate-y-[-8px] before:content-[url(/images/button-edge.svg)] after:absolute after:top-0 after:right-0 after:h-full after:translate-y-[-8px] after:scale-x-[-1] after:content-[url(/images/button-edge.svg)] focus:outline focus:outline-2 focus:outline-red-400"
  >
    <div
      v-if="loading"
      class="btn-spinner"
    ></div>
    <slot v-else />
  </button>
</template>

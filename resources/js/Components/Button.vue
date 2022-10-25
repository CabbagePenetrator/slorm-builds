<script setup>
import ButtonEdge from '@/Components/ButtonEdge.vue'

defineProps({
    loading: {
        type: Boolean,
        default: false,
    },
})
</script>

<template>
    <button
        :disabled="loading"
        class="relative flex items-center justify-between gap-x-9 bg-red-500 w-full h-[52px] text-lg font-normal focus:outline focus:outline-2 focus:outline-red-400"
    >
        <div class="h-2 bg-red-400 absolute top-0 left-0 right-0"></div>
        <div class="h-2 bg-red-600 absolute bottom-0 left-0 right-0"></div>
        <ButtonEdge position="left" />
        <div v-if="loading" class="btn-spinner"></div>
        <slot v-else />
        <ButtonEdge position="right" />
    </button>
</template>

<script setup lang="ts">
defineProps<{
    loading?: boolean
}>()
</script>

<template>
    <button
        :disabled="loading"
        class="
            relative
            border-t-8
            border-t-red-400
            [border-style:inset]
            border-b-8
            border-b-red-600
            grid
            text-center
            place-content-center
            gap-x-9
            bg-red-500
            w-full
            h-[52px]
            text-lg
            font-normal
            focus:outline focus:outline-2 focus:outline-red-400
            before:content-[url(/vb.svg)]
            after:content-[url(/vb.svg)]
            before:top-0
            before:left-0
            before:absolute
            before:translate-y-[-8px]
            before:h-full
            after:top-0
            after:right-0
            after:absolute
            after:translate-y-[-8px]
            after:scale-x-[-1]
            after:h-full
        "
    >
        <div v-if="loading" class="btn-spinner"></div>
        <slot v-else />
    </button>
</template>

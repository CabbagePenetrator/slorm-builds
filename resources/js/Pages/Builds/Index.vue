<script setup>
import Layout from '@/Layouts/AuthenticatedLayout.vue'
import { Link } from '@inertiajs/inertia-vue3'

defineProps({
  builds: Array,
})
</script>

<template>
  <Layout>
    <div class="container mx-auto">
      <nav>
        <Link :href="route('builds', { character: 0 })">Warrior</Link>
        <Link :href="route('builds', { character: 1 })">Huntress</Link>
        <Link :href="route('builds', { character: 2 })">Mage</Link>
      </nav>
      <article>
        <article
          v-for="build in builds"
          :key="build.id"
          class="flex items-center gap-4"
        >
          <h2>{{ build.title }}</h2>
          <p>-</p>
          <p>{{ build.character }}</p>
        </article>
      </article>
    </div>

    <Link :href="route('builds.create')">Create</Link>
  </Layout>
</template>

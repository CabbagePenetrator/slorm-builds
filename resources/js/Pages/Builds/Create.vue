<script setup>
import Layout from '@/Layouts/AuthenticatedLayout.vue'
import Button from '@/Components/Button.vue'
import GuestInputField from '@/Components/GuestInputField.vue'
import { useForm } from '@inertiajs/inertia-vue3'
import { ref } from 'vue'

const characters = ref([])

const form = useForm({
  file: null,
  character: null,
  title: null,
  description: null,
})

const submit = () => {
  form.post(route('builds.store'))
}

const upload = async event => {
  try {
    const formData = new FormData()
    formData.append('file', event.target.files[0])

    const { data } = await axios.post(route('characters'), formData)

    characters.value = data

    form.file = event.target.files[0]
  } catch (error) {
    console.log(error)
  }
}
</script>

<template>
  <Layout>
    <form
      @submit.prevent="submit"
      class="mx-auto w-full border-4 border-gray-600 bg-gray-900 px-4 pt-6 pb-8 sm:max-w-[470px] sm:px-12 sm:pt-7"
    >
      <h1 class="text-3xl">Create build</h1>
      <label
        class="mt-6 inline-grid cursor-pointer place-items-center border-2 border-dashed border-gray-600 bg-gray-700 py-12 px-20"
      >
        <p class="text-2xl">Save file</p>
        <input
          @change="upload"
          type="file"
          class="hidden"
        />
      </label>

      <div
        v-if="characters.length > 0"
        class="mt-6 grid grid-cols-3 gap-x-6"
      >
        <label
          v-for="character in characters"
          :key="character.name"
          class="cursor-pointer border py-2 px-4 capitalize"
          :class="{
            'border-red-500': form.character === character.value,
          }"
        >
          <p>{{ character.name }}</p>
          <p>lvl {{ character.level }}</p>
          <input
            v-model="form.character"
            type="radio"
            class="hidden"
            :value="character.value"
          />
        </label>
        <p
          v-if="form.errors.character"
          class="col-span-full mt-2 text-red-400"
        >
          {{ form.errors.character }}
        </p>
      </div>

      <GuestInputField
        v-model="form.title"
        :error="form.errors.title"
        class="mt-6"
        title="Title"
        type="text"
        required
      />

      <GuestInputField
        v-model="form.description"
        :error="form.errors.description"
        class="mt-6"
        title="Description"
        type="text"
      />

      <Button class="mt-8 sm:w-48">Create</Button>
    </form>
  </Layout>
</template>

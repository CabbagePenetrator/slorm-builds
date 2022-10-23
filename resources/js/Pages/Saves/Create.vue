<script setup>
import { useForm } from '@inertiajs/inertia-vue3'
import axios from 'axios'
import { ref } from 'vue'

const characters = ref([])

const form = useForm({
    file: null,
    character: null,
})

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

const submit = () => {
    form.post('/save')
}
</script>

<template>
    <div>save index</div>
    <input type="file" @change="upload" />

    <form v-if="characters.length > 0" @submit.prevent="submit">
        <p>characters</p>
        <div class="grid grid-cols-3 gap-4 max-w-md">
            <label
                v-for="(character, index) in characters"
                class="border hover:cursor-pointer"
                :class="{ 'border-red-500': form.character === character.name }"
            >
                <input
                    v-model="form.character"
                    type="radio"
                    class="hidden"
                    :value="character.name"
                />
                <p>{{ character.name }}</p>
                <p>{{ character.level }}</p>
            </label>
        </div>
        <button
            type="submit"
            class="capitalize bg-gray-700 text-white py-2 px-6 border-2 border-black disabled:opacity-80"
            :disabled="form.character === null"
        >
            Create build
        </button>
    </form>
</template>

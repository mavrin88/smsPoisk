<template>
  <div>
    <Head :title="`${form.name}`" />
    <h1 class="mb-8 text-3xl font-bold">
      <Link class="text-indigo-400 hover:text-indigo-600" href="/directions">Направления</Link>
      <span class="text-indigo-400 font-medium">/</span>
      {{ form.name }}
    </h1>

    <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="update">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <text-input v-model="form.name" :error="form.errors.name" class="pb-8 pr-6 w-full lg:w-1/2" label="Название клуба" />
        </div>
        <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
          <button class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Удалить Направление</button>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Обновить данные</loading-button>
        </div>
      </form>
    </div>

  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3'
import Layout from '@/Shared/Layout'
import TextInput from '@/Shared/TextInput'
import SelectInput from '@/Shared/SelectInput'
import LoadingButton from '@/Shared/LoadingButton'
import TrashedMessage from '@/Shared/TrashedMessage'

export default {
  components: {
    Head,
    Link,
    LoadingButton,
    SelectInput,
    TextInput,
    TrashedMessage,
  },
  layout: Layout,
  props: {
    direction: Object,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        name: this.direction.name,
      }),
    }
  },

  methods: {
    update() {
      this.form.put(`/directions/${this.direction.id}`)
    },
    destroy() {
      if (confirm('Вы уверены что хотите удалить Направление ?')) {
        this.$inertia.delete(`/directions/${this.direction.id}`)
      }
    },
    restore() {
      if (confirm('Are you sure you want to restore this contact?')) {
        this.$inertia.put(`/directions/${this.direction.id}/restore`)
      }
    },
  },
}
</script>

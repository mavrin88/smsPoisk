<template>
  <Head title="Login" />
  <div class="flex items-center justify-center p-6 min-h-screen bg-indigo-800">
    <div class="w-full max-w-md">
      <!--      <logo class="block mx-auto w-full max-w-xs fill-white" height="50" />-->
      <form class="mt-8 bg-white rounded-lg shadow-xl overflow-hidden" @keydown.enter.prevent="login">
        <div class="px-10 py-12">
          <h1 class="text-center text-3xl font-bold">Авторизация</h1>
          <div class="mt-6 mx-auto w-24 border-b-2" />
          <text-input v-model="form.email" :error="form.errors.email" class="mt-10" label="Email" type="email" autofocus autocapitalize="off" />
          <text-input v-model="form.password" :error="form.errors.password" class="mt-6" label="Пароль" type="password" />
          <label class="flex items-center mt-6 select-none" for="remember">
            <input id="remember" v-model="form.remember" class="mr-1" type="checkbox" />
            <span class="text-sm">Запомнить меня</span>
          </label>

        </div>
        <div class="flex px-10 py-4 bg-gray-100 border-t border-gray-100">
          <div v-show="isHovered" class="mt-3.5">
            <hollow-dots-spinner
              :animation-duration="1000"
              :dot-size="11"
              :dots-num="1"
              color="#ff1d5e"
            />
          </div>
          <button @mouseover="showHoverElement" @mouseleave="hideHoverElement" class="text-lg approximation ml-1" @click.prevent="onRegister">Перейти к регистрации</button>

          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="button" @click.prevent="login" >Войти</loading-button>
        </div>

      </form>
    </div>
  </div>
</template>

<script>
import { Head } from '@inertiajs/inertia-vue3'
import TextInput from '@/Shared/TextInput'
import LoadingButton from '@/Shared/LoadingButton'
import { HollowDotsSpinner } from 'epic-spinners'
import {route} from "ziggy-js";

export default {
  components: {
    Head,
    LoadingButton,
    TextInput,
    HollowDotsSpinner
  },
  data() {
    return {
      form: this.$inertia.form({
        email: '',
        password: '',
        remember: false,
      }),
      isHovered: false,
    }
  },
  methods: {
    login() {
      this.form.post('/login')
    },
    onRegister() {
      this.$inertia.visit(route('registration.index'));
    },
    showHoverElement() {
      this.isHovered = true;
    },
    hideHoverElement() {
      this.isHovered = false;
    },
  },
}
</script>
<style>

.approximation:hover{
  font-size: 19px; /* Размер текста по умолчанию */
  transition: font-size 0.2s ease; /* Плавное изменение размера текста */
}
</style>

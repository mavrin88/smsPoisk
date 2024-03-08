<template>
  <Head title="Регистрация"/>
  <div class="flex items-center justify-center p-6 min-h-screen bg-indigo-800">
    <div class="w-full max-w-xl">
      <!--      <logo class="block mx-auto w-full max-w-xs fill-white" height="50" />-->
      <form class="mt-8 bg-white rounded-lg shadow-xl overflow-hidden" @keydown.enter.prevent="register">
        <div class="px-10 py-12">
          <h1 class="text-center text-3xl font-bold">Регистрация</h1>
          <div class="mt-6 mx-auto w-24 border-b-2"/>

          <text-input v-model="form.email" :error="form.errors.email" class="mt-10" label="Email" type="email" autofocus
                      autocapitalize="off"/>

          <div class="flex flex-wrap -mx-4">
            <div class="w-full md:w-1/2 px-4">
              <text-input v-model="form.password" :error="form.errors.password" class="mt-6" label="Пароль"
                          type="password"/>
            </div>
            <div class="w-full md:w-1/2 px-4">
              <text-input v-model="form.confirmation_password" :error="form.errors.confirmation_password" class="mt-6"
                          label="Подтверждение пароля" type="password"/>
            </div>
          </div>

          <div class="flex flex-wrap -mx-4">
            <div class="w-full md:w-1/2 px-4">
              <text-input v-model="form.name" :error="form.errors.name" class="mt-6" label="Как вас зовут?"
                          type="text"/>
            </div>
            <div class="w-full md:w-1/2 px-4">
              <text-input v-model="form.telegramm" :error="form.errors.telegramm" class="mt-6" label="Telegram"
                          type="text"/>
            </div>
          </div>

          <text-input v-model="form.source_name" :error="form.errors.source_name" class="mt-6"
                      label="С какими источниками работаете?" type="text"/>
          <text-input v-model="form.from" :error="form.errors.about_us" class="mt-6" label="Как узнали о нас?"
                      type="text"/>

          <label class="flex items-center mt-6 select-none" for="form.rememberTerms">
            <input id="rememberTerms" v-model="form.rememberTerms" class="mr-1" type="checkbox"/>
            <span class="text-sm ml-2">Я принимаю</span> <a class="text-indigo-600 text-sm ml-2" href="/Conditions_proportions.html">Условия и положения</a>
          </label>

          <label class="flex items-center mt-4 select-none" for="rememberConsent">
            <input id="rememberConsent" v-model="form.rememberConsent" class="mr-1" type="checkbox"/>
            <span class="text-sm ml-2 ">Принимая данное соглашение, я даю свое согласие и разрешаю использование информации обо мне / либо моей компании, включая передачу её третьим лицам, для оценки, выявления, предотвращения или, иными словами, разрешаю отслеживание и предотвращение предумышленной, недопустимой или незаконной деятельности либо предотвращения фактов мошенничества.</span>
          </label>
        </div>

        <div class="flex px-10 py-4 bg-gray-100 border-t border-gray-100">
          <div v-show="isHovered" :class="{'mt-1.5': isRegistrationDisabled === false, 'mt-3.5': isRegistrationDisabled === true }">
            <hollow-dots-spinner
              :animation-duration="1000"
              :dot-size="11"
              :dots-num="1"
              color="#ff1d5e"
            />
          </div>
          <button @mouseover="showHoverElement" @mouseleave="hideHoverElement" class="text-lg approximation ml-1"
                  @click.prevent="onLogin">Перейти к авторизации
          </button>
          <loading-button @click.prevent="register" v-show="isRegistrationDisabled" :loading="form.processing"
                          class="btn-indigo ml-auto" type="submit">Создать аккаунт
          </loading-button>
        </div>
      </form>

      <footer>
        <div class="footer-links">
          <a href="/Conditions_proportions.html">Условия и положения</a>
          <a href="/Privacy_policy.html">Политика конфиденциальности</a>
        </div>
      </footer>

    </div>
  </div>
</template>

<script>
import {Head} from '@inertiajs/inertia-vue3'
import TextInput from '@/Shared/TextInput'
import LoadingButton from '@/Shared/LoadingButton'
import {HollowDotsSpinner} from 'epic-spinners'
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
        confirmation_password: '',
        podpis: '',
        name: '',
        telegramm: '',
        source_name: '',
        about_us: '',
        rememberTerms: false,
        rememberConsent: false,
      }),
      isHovered: false,
    }
  },
  computed: {
    isRegistrationDisabled() {
      return (this.form.rememberTerms && this.form.rememberConsent);
    },
  },
  methods: {
    register() {
      if (this.form.password !== this.form.confirmation_password) {
        this.form.errors.confirmation_password = 'Пароли не совпадают';
        return;
      }
      this.form.post('/register')
    },
    onLogin() {
      this.$inertia.visit(route('login'));
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
.footer-links {
  display: flex;
  justify-content: space-around;
  margin-top: 10px;
}

.footer-links a {
  font-size: 13px;
  color: #ffffff;
  margin-right: 20px;
  margin-bottom: 10px;
}

.approximation:hover {
  font-size: 19px; /* Размер текста по умолчанию */
  transition: font-size 0.2s ease; /* Плавное изменение размера текста */
}
</style>

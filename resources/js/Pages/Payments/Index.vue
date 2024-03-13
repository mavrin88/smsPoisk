<template>
  <div>
    <Head title="Выплаты"/>
    <h1 class="mb-8 text-3xl font-bold">Условия выплат </h1>
  </div>

  <div class="bg-white rounded-md shadow overflow-x-auto w-1/2 mt-3 mb-4">

    <table class="w-full whitespace-nowrap">
      <tr class="text-left font-bold">
        <th class="pb-4 pt-6 px-6 border-r-2 text-center">Тип выплат</th>
        <th class="pb-4 pt-6 px-6 text-center">% комиссии</th>
      </tr>

      <tr class="focus-within:bg-gray-100">

        <td class="w-px border-t p-2.5 border-r-2 text-center">
          <h1>ИП/Самозанятый РФ </h1>
        </td>
        <td class="w-px border-t pl-2 text-center">
          <spa>0</spa>
        </td>
      </tr>


      <tr class="focus-within:bg-gray-100">

        <td class="w-px border-t p-2.5 border-r-2 text-center">
          <spa>USDT-TRC 20</spa>
        </td>
        <td class="w-px border-t p-2.5 pl text-center">
          <spa>15%</spa>
        </td>
      </tr>

      <tr class="focus-within:bg-gray-100">

        <td class="w-px border-t p-2.5 border-r-2 text-center">
          <spa>Capitalist</spa>
        </td>
        <td class="w-px border-t p-2.5 text-center">
          <spa>5%</spa>
        </td>
      </tr>

      <tr class="focus-within:bg-gray-100">

        <td class="w-px border-t p-2.5 border-r-2 text-center">
          <spa>СПБ РФ</spa>
        </td>
        <td class="w-px border-t p-2.5 text-center">
          <spa>20%</spa>
        </td>
      </tr>
    </table>
  </div>

  <loading-button :loading="form.processing" class="btn-indigo" type="submit">
    <a href="https://t.me/smspoisk_manager" target="_blank" class="text-white">Запросить выплату</a>
  </loading-button>

  <h1 class="ml-5 mt-4 text-3xl font-bold">Предыдущие выплаты:</h1>
  <div class="bg-white rounded-md rounded shadow-xl overflow-x-auto mt-4">
    <table class="w-full whitespace-nowrap">
      <tr class="text-left font-bold">
        <th class="pb-4 pt-6 px-6 border-r-2 text-center">Дата</th>
        <th class="pb-4 pt-6 px-6 border-r-2 text-center">Валюта</th>
        <th class="pb-4 pt-6 px-6 border-r-2 text-center">Сумма</th>
        <th class="pb-4 pt-6 px-6 text-center">Тип</th>
      </tr>
      <tr v-for="payment in payments.data" :key="payment.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
        <td class="w-px border-t p-2.5 border-r-2 text-center">
          {{ payment.created_at }}
        </td>

        <td class="w-px border-t p-2.5 border-r-2 text-center">
          {{ payment.currency }}
        </td>

        <td class="w-px border-t p-2.5 border-r-2 text-center">
          {{ payment.amount }}
        </td>

        <td class="w-px border-t p-2.5 border-r-2 text-center">
          {{ payment.type }}
        </td>

      </tr>

    </table>
  </div>

</template>

<script>
import {Head} from '@inertiajs/inertia-vue3'
import Layout from '@/Shared/Layout'
import LoadingButton from "@/Shared/LoadingButton.vue";

export default {
  components: {
    LoadingButton,
    Head,
  },
  layout: Layout,

  props: {
    telegramm: String,
    payments: Object,
  },

  data() {
    return {
      form: this.$inertia.form({}),
    }
  },
}
</script>

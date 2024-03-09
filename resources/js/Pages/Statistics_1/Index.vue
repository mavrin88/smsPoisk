<template>
  <div>
    <Head title="Dashboard"/>
    <h1 class="mb-8 text-3xl font-bold">Конверсии</h1>
  </div>

  <div class="bg-white rounded-md rounded shadow-xl overflow-x-auto mt-4">
    <table class="w-full whitespace-nowrap">
      <tr class="text-left font-bold">
        <th class="pb-4 pt-6 px-6 border-r-2 text-center">Дата</th>
        <th class="pb-4 pt-6 px-6 border-r-2 text-center">Тип</th>
        <th class="pb-4 pt-6 px-6 border-r-2 text-center">Сумма</th>
        <th class="pb-4 pt-6 px-6 border-r-2 text-center">s1</th>
        <th class="pb-4 pt-6 px-6 border-r-2 text-center">s2</th>
        <th class="pb-4 pt-6 px-6 border-r-2 text-center">s3</th>
        <th class="pb-4 pt-6 px-6 border-r-2 text-center">s4</th>
        <th class="pb-4 pt-6 px-6 border-r-2 text-center">s5</th>
      </tr>
      <tr v-for="conversion in tableConversion.data" :key="conversion.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
        <td class="w-px border-t p-2.5 border-r-2 text-center">
          {{ conversion.day }}
        </td>

        <td class="w-px border-t p-2.5 border-r-2 text-center">
          {{ conversion.payment_type }}
        </td>

        <td class="w-px border-t p-2.5 border-r-2 text-center">
          {{ conversion.income }}
        </td>

        <td class="w-px border-t p-2.5 border-r-2 text-center">
          {{ conversion.s1 }}
        </td>

        <td class="w-px border-t p-2.5 border-r-2 text-center">
          {{ conversion.s2 }}
        </td>

        <td class="w-px border-t p-2.5 border-r-2 text-center">
          {{ conversion.s3 }}
        </td>

        <td class="w-px border-t p-2.5 border-r-2 text-center">
          {{ conversion.s4 }}
        </td>

        <td class="w-px border-t p-2.5 border-r-2 text-center">
          {{ conversion.s5 }}
        </td>

      </tr>

    </table>
  </div>

</template>

<script>
import {Head} from '@inertiajs/inertia-vue3'
import Layout from '@/Shared/Layout'

export default {
  components: {
    Head,
  },
  layout: Layout,
  props: {
    tableConversion: Object
  }
}
</script>

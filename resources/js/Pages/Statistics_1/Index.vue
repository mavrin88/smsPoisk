<template>
  <div>
    <Head title="Конверсии"/>
    <h1 class="mb-8 text-3xl font-bold">Конверсии</h1>
  </div>

  <div class="flex-container flex space-x-4">
    <div class="relative z-0 w-1/5 mb-6 group">
      <DateInput v-model:value="form.dateFrom" title="Дата с" type="date" />
    </div>

    <div class="relative z-0 w-1/5 mb-6 group">
      <DateInput v-model:value="form.dateTo" title="Дата по" type="date" />
    </div>

    <div class="flex items-center">
      <button v-show="hasFilters" @click="reset"
              class="bg-transparent hover:bg-white text-grey-dark font-semibold hover:border-b-1 py-2 px-4 border border-gray hover:border-transparent rounded ml-2">
        Очистить фильтр
      </button>
    </div>
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
          {{ conversion.pt }}
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
import DateInput from '@/Shared/DateInput.vue'
import throttle from 'lodash/throttle'
import pickBy from 'lodash/pickBy'

export default {
  components: {
    DateInput,
    Head,
  },
  layout: Layout,
  props: {
    tableConversion: {
      type: Object,
      required: true
    }
  },
  data: function() {
    return {
      form: {
        dateFrom: null,
        dateTo: null,
      },
      searchOn: false,
    }
  },
  mounted() {
    this.reset()
  },
  computed: {
    hasFilters() {
      return true
    },
  },
  methods: {
    clearFilters: function() {
    },
    dataFrom() {
      const currentDate = new Date();
      const thirtyDaysAgo = new Date(currentDate);
      thirtyDaysAgo.setDate(currentDate.getDate() - 30);

      const yyyy = thirtyDaysAgo.getFullYear();
      const mm = String(thirtyDaysAgo.getMonth() + 1).padStart(2, '0');
      const dd = String(thirtyDaysAgo.getDate()).padStart(2, '0');
      this.form.dateFrom = `${yyyy}-${mm}-${dd}`;
    },
    dataTo() {
      const currentDate = new Date();
      const yyyy = currentDate.getFullYear();
      const mm = String(currentDate.getMonth() + 1).padStart(2, '0');
      const dd = String(currentDate.getDate()).padStart(2, '0');
      this.form.dateTo = `${yyyy}-${mm}-${dd}`;
    },
    reset() {
      this.dataFrom()
      this.dataTo()
    },
  },
  watch: {
    form: {
      deep: true,
      handler: throttle(function() {
        this.$inertia.get('/statistic_1', pickBy(this.form), {
          onBefore: () => {
            this.searchOn = true
          },
          onSuccess: () => {
            this.searchOn = false
          },
          preserveState: true,
        })
      }, 150),
    },
  },
}
</script>

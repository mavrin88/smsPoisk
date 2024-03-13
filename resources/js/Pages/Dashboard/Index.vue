<template>
  <div>
    <Head title="Главная" />
    <h1 class="mb-4 text-3xl font-bold">Параметры
    </h1>
  </div>

  <div class="flex-container flex space-x-4" style="display: flex; align-items: center;">

    <div class="flex items-center px-4 py-3 bg-white border-t border-gray-100 shadow mb-4"
         data-popover-target="popover-1" type="button">
      <div class="button-container">
        <h6 class="text-uppercase text-muted leading-tight">Ваш тип партнерства </h6>
        <a class="">Revenue share</a>
      </div>
    </div>

    <div class="flex items-center px-4 py-3 bg-white border-t border-gray-100 shadow mb-4">
      <div class="button-container">
        <h6 class="text-uppercase text-muted leading-tight">Трекинг ссылка:</h6>
        <a :href="getEncodedLend_1()" target="_blank">https://smspoisk.ru/?source={{ source_name }}
        </a>
      </div>
    </div>

<!--    <div class="flex items-center px-4 py-3 bg-gray-50 border-t border-gray-100 shadow mb-8 ">-->
<!--      <div class="button-container">-->
<!--        <h6 class="text-uppercase text-muted leading-relaxed">Трекинг ссылка Лэнд 2:</h6>-->
<!--        <a :href="getEncodedLend_2()" target="_blank"> https://smspoisk.ru/land2/?source={{ source_name }}</a>-->
<!--      </div>-->
<!--    </div>-->

  </div>


  <div class="flex items-center px-8 py-4 bg-white border-t border-gray-100 shadow mb-16">
    <div class="p-1 mr-2 w-1/1">
      <h6 class="text-uppercase text-muted leading-tight">Использование параметра source в ссылке обязательно и его
        значение нельзя
        менять! Для дополнительной атрибуции
        трафика Вы можете использовать параметры URL: s1, s2, s3, s4, s5. Т.о. Трекинг ссылка будет вида:<span
          class="text-black leading-tight hover:underline link-hover"> https://smspoisk.ru/land2/?source={{
            source_name
          }}&s1=dzen&s2=article1</span>
      </h6>
    </div>
  </div>

  <!--  Widget -->
  <div style="display: flex; align-items: center;" class="mb-16">

<!--    <div data-popover-target="popover-2" type="button" class="card w-1/5 mr-4 rounded-md  shadow-xl">-->
<!--      <div class="card-body">-->
<!--        <div class="row align-items-center gx-0">-->
<!--          <div class="col">-->
<!--            &lt;!&ndash; Title &ndash;&gt;-->
<!--            <h6 class="text-uppercase text-muted mb-2">-->
<!--              Баланс:-->
<!--            </h6>-->
<!--            <span class="text-2xl pr-2 pt-4">{{ widget_total_income }}</span>-->
<!--          </div>-->
<!--        </div>-->
<!--      </div>-->
<!--    </div>-->

    <div data-popover-target="popover-3" type="button" class="card w-1/5 mr-9 rounded-md  shadow-xl">
      <div class="card-body">
        <div class="row align-items-center gx-0">
          <div class="col">
            <!-- Title -->
            <h6 class="text-uppercase text-muted">
              Доступный баланс:
            </h6>
            <span class="text-2xl pr-2 pt-4">{{ widget_available_balances }}</span>
          </div>
        </div>
      </div>
    </div>

    <div data-popover-target="popover-4" type="button" class="card w-1/5 mr-9 rounded-md shadow-xl">
      <div class="card-body">
        <div class="row align-items-center gx-0">
          <div class="col">
            <!-- Title -->
            <h6 class="text-uppercase text-muted">
              Подписчиков:
            </h6>
            <span class="text-2xl pr-2 pt-4">{{ widget_period_subscribed }}</span>
          </div>
        </div>
      </div>
    </div>

    <div data-popover-target="popover-5" type="button" class="card w-1/5">
      <div class="card-body rounded-md  shadow-xl">
        <div class="row align-items-center gx-0">
          <div class="col">
            <!-- Title -->
            <h6 class="text-uppercase text-muted">
              Активных подписчиков:
            </h6>
            <span class="text-2xl pr-2 pt-4">{{ widget_active_subscribed }}</span>
          </div>
        </div>
      </div>
    </div>

  </div>

  <div data-popover id="popover-1" role="tooltip"
       class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
    <div class="px-3 py-2 bg-gray-100 border-b border-gray-200 rounded-t-lg dark:border-gray-600 dark:bg-gray-700">
      <h3 class="font-semibold text-gray-900 dark:text-white">Revenue share</h3>
    </div>
    <div class="px-3 py-2">
      <p>Вы получаете % от каждой транзакции пользователя, которого привели.</p>
    </div>
    <div data-popper-arrow></div>
  </div>

  <div data-popover id="popover-2" role="tooltip"
       class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
    <div class="px-3 py-2 bg-gray-100 border-b border-gray-200 rounded-t-lg dark:border-gray-600 dark:bg-gray-700">
      <h3 class="font-semibold text-gray-900 dark:text-white">Баланс:</h3>
    </div>
    <div class="px-3 py-2">
      <p>And here's some amazing content. It's very engaging. Right?</p>
    </div>
    <div data-popper-arrow></div>
  </div>

  <div data-popover id="popover-3" role="tooltip"
       class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
    <div class="px-3 py-2 bg-gray-100 border-b border-gray-200 rounded-t-lg dark:border-gray-600 dark:bg-gray-700">
      <h3 class="font-semibold text-gray-900 dark:text-white">Доступный баланс:</h3>
    </div>
    <div class="px-3 py-2">
      <p>Сумма доступная для вывода. Запросите вывод в разделе Выплаты.</p>
    </div>
    <div data-popper-arrow></div>
  </div>

  <div data-popover id="popover-4" role="tooltip"
       class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
    <div class="px-3 py-2 bg-gray-100 border-b border-gray-200 rounded-t-lg dark:border-gray-600 dark:bg-gray-700">
      <h3 class="font-semibold text-gray-900 dark:text-white">Подписчиков:</h3>
    </div>
    <div class="px-3 py-2">
      <p>Количество Ваших подписчиков за всё время.</p>
    </div>
    <div data-popper-arrow></div>
  </div>

  <div data-popover id="popover-5" role="tooltip"
       class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
    <div class="px-3 py-2 bg-gray-100 border-b border-gray-200 rounded-t-lg dark:border-gray-600 dark:bg-gray-700">
      <h3 class="font-semibold text-gray-900 dark:text-white">Активных подписчиков:</h3>
    </div>
    <div class="px-3 py-2">
      <p>Столько Ваших пользователей подписано сейчас.</p>
    </div>
    <div data-popper-arrow></div>
  </div>

      <h1 class="text-3xl font-bold mb-4">Статистика: </h1>

  <div class="flex-container flex space-x-4">
    <div class="relative z-0 w-1/5 mb-3 mr-5 group">
      <DateInput v-model:value="form.dateFrom" title="Дата с" type="date" />
    </div>

    <div class="relative z-0 w-1/5 mb-6 mr-5 group">
      <DateInput v-model:value="form.dateTo" title="Дата по" type="date" />
    </div>

    <div class="flex items-center">
      <button v-show="hasFilters" @click="reset"
              class="bg-transparent hover:bg-white text-grey-dark font-semibold hover:border-b-1 py-2 px-4 border border-gray hover:border-transparent rounded ml-2">
        Очистить фильтр
      </button>
    </div>
  </div>


  <div class="bg-white rounded-md shadow-xl overflow-x-auto">
    <table class="w-full whitespace-nowrap">
      <tr class="text-left font-bold">
        <th class="pb-4 pt-6 px-6 border-r-2 text-center">Дата</th>
        <th class="pb-4 pt-6 px-6 border-r-2 text-center">Регистраций</th>
        <th class="pb-4 pt-6 px-6 border-r-2 text-center">Подписок</th>
        <th class="pb-4 pt-6 px-6 border-r-2 text-center">CR</th>
        <th class="pb-4 pt-6 px-6 border-r-2 text-center">Конверсий</th>
        <th class="pb-4 pt-6 px-6 border-r-2 text-center">Сумма</th>
      </tr>

      <tr v-for="items in tableScribers.data" :key="items.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
        <td class="w-px border-t p-2.5 border-r-2 text-center">
          {{ items.day }}
        </td>

        <td class="w-px border-t p-2.5 border-r-2 text-center">
          {{ items.registered }}
        </td>

        <td class="w-px border-t p-2.5 border-r-2 text-center">
          {{ items.subscribed }}
        </td>

        <td class="w-px border-t p-2.5 border-r-2 text-center">
          {{ items.cr }}
        </td>

        <td class="w-px border-t p-2.5 border-r-2 text-center">
          {{ items.trx }}
        </td>

        <td class="w-px border-t p-2.5 border-r-2 text-center">
          {{ items.total_income }}
        </td>
      </tr>

    </table>
  </div>

</template>

<script>
import { Head } from '@inertiajs/inertia-vue3'
import Layout from '@/Shared/Layout'
import DateInput from '@/Shared/DateInput.vue'
import throttle from 'lodash/throttle'
import pickBy from 'lodash/pickBy'

export default {
  components: {
    Head, DateInput
  },
  layout: Layout,

  props: {
    source_name: {
      type: [Number, String],
      default: ''
    },
    widget_total_income: {
      type: [Number, String],
      default: 0
    },
    widget_available_balances: {
      type: [Number, String],
      default: 0
    },
    widget_period_subscribed: {
      type: [Number, String],
      default: 0
    },
    widget_active_subscribed: {
      type: [Number, String],
      default: 0
    },
    filters: Object,
    tableScribers: Object,
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
    Lend_1() {
      return `https://smspoisk.ru/source=${this.source_name}`
    },
    Lend_2() {
      return `https://smspoisk.ru/land2/source=${this.source_name}`
    },
    hasFilters() {
      // return Object.values(this.form).some(value => value !== '' && value !== undefined)
      return true
    },
  },
  methods: {
    clearFilters: function() {
      // Object.keys(this.form).forEach(key => {
      //   this.form[key] = ''
      // })

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
      // this.form = mapValues(this.form, () => '')
      this.dataFrom()
      this.dataTo()
    },
    getEncodedLend_1() {
      const encodedSource = encodeURIComponent(this.source_name);
      return `https://smspoisk.ru/?source=${encodedSource}`;
    },
    getEncodedLend_2() {
      const encodedSource = encodeURIComponent(this.source_name);
      return `https://smspoisk.ru/land2/?source=${encodedSource}`;
    }
  },
  watch: {
    form: {
      deep: true,
      onFinish: true,
      handler: throttle(function() {
        this.$inertia.get('/', pickBy(this.form), {
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
<style>
.button-container {
  position: relative;
}

.link-hover {
  cursor: pointer;
}
</style>

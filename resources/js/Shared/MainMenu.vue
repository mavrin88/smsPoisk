<template>
  <div>
    <div class="mb-4">
      <Link class="group flex items-center py-3" href="/">
        <icon name="dashboard" class="mr-2 w-4 h-4" :class="isUrl('') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Главная</div>
      </Link>
    </div>
    
    <div class="mb-4">
      <Link class="group flex items-center py-3" href="/statistic_1">
        <icon name="office" class="mr-2 w-4 h-4" :class="isUrl('statistic_1') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('statistic_1') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Конверсии</div>
      </Link>
    </div>

    <div class="mb-4">
      <Link class="group flex items-center py-3" href="/payments">
        <icon name="printer" class="mr-2 w-4 h-4" :class="isUrl('payments') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('payments') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Выплаты</div>
      </Link>
    </div>
  </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3'
import Icon from '@/Shared/Icon'

export default {
  components: {
    Icon,
    Link,
  },
  methods: {
    isUrl(...urls) {
      let currentUrl = this.$page.url.substr(1)
      if (urls[0] === '') {
        return currentUrl === ''
      }
      return urls.filter((url) => currentUrl.startsWith(url)).length
    },
  },
}
</script>

<template>
  <div class="min-w-[180px] w-[180px]  transition-all bg-black text-white py-4 px-2">
    <router-link :to="{name: 'app.dashboard'}"
                 class="flex items-center p-2 rounded transition-colors hover:bg-black/30">
      <span class="mr-2 text-gray-300">
        <HomeIcon class="w-5"/>
      </span>
      <span class="text-xs">
        Dashboard
      </span>
    </router-link>
    <router-link :to="{name: 'app.categories'}"
                 class="flex items-center p-2 rounded transition-colors hover:bg-black/30">
      <span class="mr-2 text-gray-300">
        <ViewListIcon class="w-5"/>
      </span>
      <span class="text-xs">
        Danh mục sản phẩm
      </span>
    </router-link>
    <router-link :to="{name: 'app.products'}"
                 class="flex items-center p-2 rounded transition-colors hover:bg-black/30">
      <span class="mr-2 text-gray-300">
        <ViewListIcon class="w-5"/>
      </span>
      <span class="text-xs">
        Sản phẩm
      </span>
    </router-link>
    <router-link :to="{name: 'app.news'}"
                 class="flex items-center p-2 rounded transition-colors hover:bg-black/30">
      <span class="mr-2 text-gray-300">
        <ViewListIcon class="w-5"/>
      </span>
      <span class="text-xs">
        Bài viết
      </span>
    </router-link>
    <router-link :to="{name: 'app.newscategory'}"
                 class="flex items-center p-2 rounded transition-colors hover:bg-black/30">
      <span class="mr-2 text-gray-300">
        <ViewListIcon class="w-5"/>
      </span>
      <span class="text-xs">
      Danh mục bài viết
      </span>
    </router-link>
    <router-link :to="{name: 'app.orders'}"
                 class="flex items-center p-2 rounded transition-colors hover:bg-black/30">
      <span class="mr-2 text-gray-300">
        <ViewListIcon class="w-5"/>
      </span>
      <span class="text-xs">
        Đơn hàng
      </span>
    </router-link>
    <router-link :to="{name: 'app.users'}"
                 class="flex items-center p-2 rounded transition-colors hover:bg-black/30">
      <span class="mr-2 text-gray-300">
        <UsersIcon class="w-5"/>
      </span>
      <span class="text-xs">
        Tài khoản
      </span>
    </router-link>
    <router-link :to="{name: 'app.customers'}"
                 class="flex items-center p-2 rounded transition-colors hover:bg-black/30">
      <span class="mr-2 text-gray-300">
        <UserGroupIcon class="w-5"/>
      </span>
      <span class="text-xs">
        Khách hàng
      </span>
    </router-link>
    
  </div>
</template>

<script setup>
  import {HomeIcon, UserGroupIcon, UsersIcon, ViewListIcon, ChartBarIcon} from '@heroicons/vue/outline'
</script>

<style scoped>

</style>

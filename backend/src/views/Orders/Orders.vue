<template>
  <div class="flex items-center justify-between mb-3">
    <h1 class="text-3xl font-semibold">Đơn hàng</h1>
  </div>
  <OrdersTable @clickView="viewOrder"/>
</template>

<script setup>
import {computed, onMounted, ref} from "vue";
import store from "../../store";
import OrdersTable from "./OrdersTable.vue";

const orders = computed(() => store.state.orders);

function showOrder(p) {

}
</script>

<style scoped>

</style>

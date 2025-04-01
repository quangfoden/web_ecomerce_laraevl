<template>
  <span class="text-white py-1 px-2 rounded " :class="{
      'bg-emerald-500': ['paid', 'completed'].includes(order.status),
      'bg-orange-400': order.status === 'shipped',
      'bg-red-500': order.status === 'cancelled',
      'bg-gray-400': order.status === 'unpaid',
    }">{{ getStatusText(order.status) }}</span>
</template>

<script setup>
const {order} = defineProps({
  order: Object
})
function getStatusText(status) {
  const statusMap = {
    paid: 'Đã thanh toán',
    completed: 'Hoàn thành',
    shipped: 'Đã giao hàng',
    cancelled: 'Đã hủy',
    unpaid: 'Chưa thanh toán'
  };
  return statusMap[status] || 'Không xác định'; 
}
  </script>

<style scoped>

</style>

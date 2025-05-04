<template>
  <div class="p-4">
    <h1 class="text-xl font-bold mb-4">Đơn hàng theo đội</h1>
    <table
      class="table-auto w-full border-collapse border border-gray-300"
      style="font-size: 16px"
    >
      <thead>
        <tr class="bg-gray-100">
          <th class="border border-gray-300 px-2 py-2">STT</th>
          <th class="border border-gray-300 px-2 py-2">Tên đội</th>
          <th class="border border-gray-300 px-2 py-2">Người tạo</th>
          <th class="border border-gray-300 px-2 py-2">Sản phẩm</th>
          <th class="border border-gray-300 px-2 py-2">Số lượng</th>
          <th class="border border-gray-300 px-2 py-2">Ghi chú</th>
          <th class="border border-gray-300 px-2 py-2">Trạng thái</th>
          <th class="border border-gray-300 px-2 py-2">Ngày tạo</th>
          <th class="border border-gray-300 px-2 py-2">Hành động</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(order, index) in teamOrders" :key="order.id">
          <td class="border border-gray-300 px-2 py-2">
          
            <router-link
              :to="{ name: 'app.customers.view', params: { id: order.user?.id } }"
              :class="[
                active ? 'bg-indigo-600 text-white' : 'text-gray-900',
                'group flex w-full items-center rounded-md px-2 py-2 text-sm',
              ]"
            >  {{ index + 1 }}</router-link>
          </td>
          <td class="border border-gray-300 px-2 py-2">
            {{ order.team_name }}
          </td>
          <td class="border border-gray-300 px-2 py-2">
            {{ order.user?.email || "N/A" }}
          </td>
          <td class="border border-gray-300 px-2 py-2">
            {{ order.product?.title || "N/A" }}
          </td>
          <td class="border border-gray-300 px-2 py-2">{{ order.quantity }}</td>
          <td class="border border-gray-300 px-2 py-2">
            {{ order.note || "Không có" }}
          </td>
          <td class="border border-gray-300 px-2 py-2">
            <span
              :class="
                order.status === 'pending'
                  ? 'bg-red-500 text-xs'
                  : 'bg-green-500 text-xs'
              "
              class="text-white px-2 py-1 rounded"
            >
              {{ order.status === "pending" ? "Chờ xác nhận" : "Đã xác nhận" }}
            </span>
          </td>
          <td class="border border-gray-300 px-2 py-2">
            {{ order.created_at }}
          </td>
          <td class="border border-gray-300 px-2 py-2">
            <button
              v-if="order.status === 'pending'"
              @click="changeStatus(order.id, 'confirmed')"
              class="bg-blue-500 text-white px-2 py-2 rounded hover:bg-blue-600"
            >
              Xác nhận
            </button>
            <span v-else class="text-green-500 font-bold">Đã xác nhận</span>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import store from "../../store";
import axiosClient from "../../axios.js";

export default {
  data() {
    return {
      teamOrders: [],
    };
  },
  async created() {
    try {
      const response = await axiosClient.get("/team-orders");
      this.teamOrders = response.data.data;
    } catch (error) {
      console.error("Lỗi khi tải danh sách đơn hàng theo đội:", error);
    }
  },
  methods: {
    async changeStatus(orderId, status) {
      try {
        await axiosClient.put(`/team-orders/${orderId}/status`, { status });
        const order = this.teamOrders.find((order) => order.id === orderId);
        if (order) {
          order.status = status;
        }
        store.commit("showToast", "Đã xác nhận đơn hàng thành công!");
      } catch (error) {
        console.error("Lỗi khi cập nhật trạng thái:", error);
        alert("Không thể cập nhật trạng thái. Vui lòng thử lại.");
      }
    },
  },
};
</script>

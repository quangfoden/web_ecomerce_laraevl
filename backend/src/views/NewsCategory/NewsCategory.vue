<template>
  <div class="container mx-auto p-6">
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Quản Lý Danh Mục Tin Tức</h2>

    <!-- Button Thêm Danh Mục -->
    <button
      class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition disabled:opacity-50"
      @click="openModal(null)"
      :disabled="loading"
    >
      {{ loading ? "Đang tải..." : "Thêm Danh Mục" }}
    </button>

    <!-- Hiển thị Loading khi Fetch Data -->
    <div v-if="loading" class="text-center mt-4 text-gray-600">
      <svg class="animate-spin h-6 w-6 mx-auto text-blue-500" viewBox="0 0 24 24" fill="none">
        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" class="opacity-25" />
        <path fill="currentColor" d="M4 12a8 8 0 018-8v8z" class="opacity-75" />
      </svg>
      <p>Đang tải danh mục...</p>
    </div>

    <!-- Bảng danh mục -->
    <div v-if="!loading" class="overflow-x-auto mt-6">
      <table class="w-full border rounded-lg shadow-md">
        <thead class="bg-gray-200">
          <tr class="text-left">
            <th class="p-3 border">#</th>
            <th class="p-3 border">Tên</th>
            <th class="p-3 border">Mô Tả</th>
            <th class="p-3 border">Hành Động</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(category, index) in categories" :key="category.id" class="border-b hover:bg-gray-100">
            <td class="p-3">{{ index + 1 }}</td>
            <td class="p-3">{{ category.name }}</td>
            <td class="p-3">{{ category.description }}</td>
            <td class="p-3 space-x-2">
              <button
                class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 transition disabled:opacity-50"
                @click="openModal(category)"
                :disabled="loading"
              >
                Sửa
              </button>
              <button
                class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 transition disabled:opacity-50"
                @click="deleteCategory(category.id)"
                :disabled="loading"
              >
                Xóa
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Modal -->
    <div v-if="showModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center p-4">
      <div class="bg-white rounded-lg shadow-lg w-full max-w-md max-h-[90vh] overflow-y-auto p-6 relative">
        <button @click="closeModal" class="absolute top-2 right-2 text-gray-600 hover:text-gray-800 text-2xl">
          &times;
        </button>

        <h3 class="text-xl font-semibold text-center mb-4">{{ editingCategory ? "Chỉnh Sửa" : "Thêm" }} Danh Mục</h3>

        <form @submit.prevent="editingCategory ? updateCategory() : createCategory()">
          <div class="mb-4">
            <label class="block font-medium">Tên Danh Mục</label>
            <input
              v-model="categoryData.name"
              type="text"
              class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
              required
            />
          </div>

          <div class="mb-4">
            <label class="block font-medium">Mô Tả</label>
            <textarea
              v-model="categoryData.description"
              class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
            ></textarea>
          </div>

          <div class="flex justify-between mt-4">
            <button
              type="submit"
              class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition disabled:opacity-50"
              :disabled="loading"
            >
              {{ loading ? "Đang xử lý..." : editingCategory ? "Cập Nhật" : "Thêm" }}
            </button>
            <button
              type="button"
              class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition"
              @click="closeModal"
              :disabled="loading"
            >
              Hủy
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import axiosClient from "../../axios";

export default {
  data() {
    return {
      categories: [],
      showModal: false,
      editingCategory: null,
      categoryData: { name: "", description: "" },
      loading: false, // State loading
    };
  },
  methods: {
    async fetchCategories() {
      this.loading = true;
      try {
        const response = await axiosClient.get("newscategories");
        this.categories = response.data;
      } catch (error) {
        console.error("Lỗi khi tải danh mục:", error);
      } finally {
        this.loading = false;
      }
    },
    openModal(category) {
      this.editingCategory = category;
      this.categoryData = category ? { ...category } : { name: "", description: "" };
      this.showModal = true;
    },
    closeModal() {
      this.showModal = false;
      this.categoryData = { name: "", description: "" };
    },
    async createCategory() {
      this.loading = true;
      try {
        await axiosClient.post("newscategories", this.categoryData);
        this.fetchCategories();
        this.closeModal();
        this.$store.commit("showToast", "Thêm danh mục thành công!");
      } catch (error) {
        this.$store.commit("showToast", "Lỗi khi thêm danh mục!", { type: "error" });
      } finally {
        this.loading = false;
      }
    },
    async updateCategory() {
      this.loading = true;
      try {
        await axiosClient.put(`newscategories/${this.editingCategory.id}`, this.categoryData);
        this.fetchCategories();
        this.closeModal();
        this.$store.commit("showToast", "Cập nhật danh mục thành công!");
      } catch (error) {
        this.$store.commit("showToast", "Lỗi khi cập nhật danh mục!", { type: "error" });
      } finally {
        this.loading = false;
      }
    },
    async deleteCategory(id) {
      if (confirm("Bạn có chắc chắn muốn xóa danh mục này?")) {
        this.loading = true;
        try {
          await axiosClient.delete(`newscategories/${id}`);
          this.fetchCategories();
          this.$store.commit("showToast", "Xóa danh mục thành công!");
        } catch (error) {
          this.$store.commit("showToast", "Lỗi khi xóa danh mục!", { type: "error" });
        } finally {
          this.loading = false;
        }
      }
    },
  },
  mounted() {
    this.fetchCategories();
  },
};
</script>

<template>
  <div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Quản Lý Bài Viết</h2>
    <button @click="openModal(null)" class="bg-blue-500 text-white px-4 py-2 rounded-md" :disabled="loading">
      {{ loading ? 'Đang tải...' : 'Thêm Bài Viết' }}
    </button>
    <div v-if="loading" class="flex justify-center items-center mt-4">
      <span class="loader"></span>
    </div>

    <table v-if="!loading" class="w-full mt-4 border-collapse border border-gray-300">
      <thead>
        <tr class="bg-gray-200">
          <th class="border p-2">#</th>
          <th class="border p-2">Tiêu Đề</th>
          <th class="border p-2">Danh Mục</th>
          <th class="border p-2">Hình Ảnh</th>
          <th class="border p-2">Hành Động</th>
        </tr>
      </thead>
      <tbody>
        <tr style="text-align: center;" v-for="(news, index) in newsList" :key="news.id" class="hover:bg-gray-100">
          <td class="border p-2">{{ index + 1 }}</td>
          <td class="border p-2">{{ news.title }}</td>
          <td class="border p-2">{{ news.category?.name }}</td>
          <td class="border p-2">
            <img v-if="news.image" :src="news.url" alt="Hình ảnh" class="w-16 h-16 object-cover rounded-md" />
          </td>
          <td class="border p-2">
            <button @click="openModal(news)" class="bg-yellow-500 text-white px-3 py-1 rounded-md" :disabled="loading">
              {{ loading ? "..." : "Sửa" }}
            </button>
            <button @click="deleteNews(news.id)" class="bg-red-500 text-white px-3 py-1 rounded-md ml-2" :disabled="loading">
              {{ loading ? "..." : "Xóa" }}
            </button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Modal -->
    <div v-if="showModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 p-4">
  <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-3xl max-h-[90vh] overflow-y-auto relative">
    <button @click="closeModal" class="absolute top-2 right-2 text-gray-600 text-2xl font-bold">&times;</button>
    
    <h3 class="text-xl font-semibold mb-4 text-center">{{ editingNews ? "Chỉnh Sửa" : "Thêm" }} Bài Viết</h3>
    
    <form @submit.prevent="editingNews ? updateNews() : createNews()">
      <div class="mb-4">
        <label class="block font-medium">Tiêu đề</label>
        <input v-model="newsData.title" placeholder="Nhập tiêu đề" required class="w-full p-3 border rounded-md" />
      </div>

      <div class="mb-4">
        <label class="block font-medium">Nội dung</label>
        <Editor v-model="newsData.content" api-key="5i8j4ohss0vt2ue6qzmyd4jzphmy5dbti00y61asvmgmht73" :init="editorConfig" class="border rounded-md" />
      </div>

      <div class="mb-4">
        <label class="block font-medium">Danh mục</label>
        <select v-model="newsData.category_id" required class="w-full p-3 border rounded-md">
          <option v-for="category in categories" :key="category.id" :value="category.id">
            {{ category.name }}
          </option>
        </select>
      </div>

      <div class="mb-4">
        <label class="block font-medium">Hình ảnh</label>
        <input type="file" @change="handleFileUpload" class="w-full p-3 border rounded-md" />
        
        <div v-if="imagePreview" class="mt-2">
          <img :src="imagePreview" alt="Ảnh xem trước" class="w-full h-64 object-cover rounded-md" />
        </div>
      </div>

      <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md w-full" :disabled="loading">
            {{ loading ? "Đang xử lý..." : (editingNews ? "Cập Nhật" : "Thêm") }}
          </button>
    </form>
  </div>
</div>

  </div>
</template>

<script>
import axiosClient from "../../axios";
import Editor from '@tinymce/tinymce-vue';

export default {
  components: { Editor },
  data() {
    return {
      newsList: [],
      categories: [],
      showModal: false,
      editingNews: null,
      newsData: { title: "", content: "", category_id: "", image: null },
      imagePreview: null,
      loading: false,
      editorConfig: {
        height: 300,
        menubar: false,
        plugins: 'lists link image table code help wordcount',
        toolbar: 'undo redo | formatselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help'
      }
    };
  },
  methods: {
    async fetchNews() {
      this.loading = true;
      const response = await axiosClient.get("news");
      this.newsList = response.data;
      this.loading = false;
    },
    async fetchCategories() {
      this.loading = true;
      const response = await axiosClient.get("newscategories");
      this.categories = response.data;
      this.loading = false;
    },
    openModal(news) {
      this.editingNews = news;
      this.newsData = news ? { ...news, image: null } : { title: "", content: "", category_id: "", image: null };
      this.imagePreview = news?.url ? news.url : null;
      this.showModal = true;
    },
    closeModal() {
      this.showModal = false;
      this.newsData = { title: "", content: "", category_id: "", image: null };
      this.imagePreview = null;
    },
    handleFileUpload(event) {
      const file = event.target.files[0];
      if (file) {
        this.newsData.image = file;
        this.imagePreview = URL.createObjectURL(file);
      }
    },
    async createNews() {
      this.loading = true;
      let formData = new FormData();
      formData.append("title", this.newsData.title);
      formData.append("content", this.newsData.content);
      formData.append("category_id", this.newsData.category_id);
      if (this.newsData.image) {
        formData.append("image", this.newsData.image);
      }

      await axiosClient.post("news", formData, {
        headers: {
          "Content-Type": "multipart/form-data",
        },
      });

      this.fetchNews();
      this.closeModal();
      this.loading = false;
      this.$store.commit("showToast", "Thêm bài viết thành công!");
    },
    async updateNews() {
      this.loading = true;
      let formData = new FormData();
      formData.append("title", this.newsData.title);
      formData.append("content", this.newsData.content);
      formData.append("category_id", this.newsData.category_id);
      if (this.newsData.image instanceof File) {
        formData.append("image", this.newsData.image);
      }

      await axiosClient.post(`news/${this.editingNews.id}`, formData, {
        headers: {
          "Content-Type": "multipart/form-data",
        },
      });
      this.loading = false;
      this.fetchNews();
      this.closeModal();
      this.$store.commit("showToast", "Cập nhật bài viết thành công!");
    },
    async deleteNews(id) {
      if (confirm("Bạn có chắc chắn muốn xóa bài viết này?")) {
        await axiosClient.delete(`news/${id}`);
        this.fetchNews();
        this.$store.commit("showToast", "Xóa bài viết thành công!");
      }
    },
  },
  mounted() {
    this.fetchNews();
    this.fetchCategories();
  },
};
</script>
<style>
.loader {
  border: 4px solid #f3f3f3;
  border-top: 4px solid #3498db;
  border-radius: 50%;
  width: 40px;
  height: 40px;
  animation: spin 1s linear infinite;
}
@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
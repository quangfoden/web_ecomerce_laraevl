<template>
  <div class="flex items-center justify-between mb-3">
    <h1 v-if="!loading" class="text-3xl font-semibold">
      {{
        product.id
          ? `Cập nhật sản phẩm: "${product.title}"`
          : "Thêm sản phẩm mới"
      }}
    </h1>
  </div>
  <div class="bg-white rounded-lg shadow animate-fade-in-down">
    <Spinner
      v-if="loading"
      class="absolute left-0 top-0 bg-white right-0 bottom-0 flex items-center justify-center z-50"
    />
    <form v-if="!loading" @submit.prevent="onSubmit">
      <div class="grid grid-cols-3">
        <div class="col-span-2 px-4 pt-5 pb-4">
          <CustomInput
            class="mb-2"
            v-model="product.title"
            label="Tiêu đề"
            :errors="errors['title']"
          />
          <CustomInput
            type="richtext"
            class="mb-2"
            v-model="product.description"
            label="Mô tả"
            :errors="errors['description']"
          />
          <CustomInput
            type="number"
            class="mb-2"
            v-model="product.price"
            label="Giá"
            prepend="VNĐ"
            :errors="errors['price']"
          />

          <!-- Size và số lượng -->
          <div class="mb-4">
            <label for="sizes" class="block font-medium text-gray-700 mb-2"
              >Size và số lượng</label
            >
            <div
              v-for="(size, index) in product.sizes"
              :key="index"
              class="flex items-center space-x-4 mb-3"
            >
              <!-- Dropdown chọn size -->
              <div class="flex-1">
                <label class="block text-sm font-medium text-gray-600"
                  >Size</label
                >
                <select
                  v-model="size.id"
                  class="w-full border border-gray-300 rounded-md p-2 focus:ring-indigo-500 focus:border-indigo-500"
                >
                  <option
                    v-for="option in sizeOptions"
                    :key="option.id"
                    :value="option.id"
                  >
                    {{ option.name }}
                  </option>
                </select>
              </div>

              <!-- Input số lượng -->
              <div class="flex-1">
                <label class="block text-sm font-medium text-gray-600"
                  >Số lượng</label
                >
                <input
                  type="number"
                  v-model="size.quantity"
                  placeholder="Số lượng"
                  class="w-full border border-gray-300 rounded-md p-2 focus:ring-indigo-500 focus:border-indigo-500"
                />
              </div>

              <!-- Nút xóa -->
              <div class="flex items-end">
                <button
                  type="button"
                  @click="removeSize(index)"
                  class="text-red-500 hover:text-red-700"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M6 18L18 6M6 6l12 12"
                    />
                  </svg>
                </button>
              </div>
            </div>

            <!-- Nút thêm size -->
            <button
              type="button"
              @click="addSize"
              class="mt-2 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            >
              Thêm size
            </button>
          </div>

          <CustomInput
            type="checkbox"
            class="mb-2"
            v-model="product.published"
            label="Hiển thị"
            :errors="errors['published']"
          />
          <treeselect
            v-model="product.categories"
            :multiple="true"
            :options="options"
            :errors="errors['categories']"
          />
        </div>
        <div class="col-span-1 px-4 pt-5 pb-4">
          <image-preview
            v-model="product.images"
            :images="product.images"
            v-model:deleted-images="product.deleted_images"
            v-model:image-positions="product.image_positions"
          />
        </div>
      </div>
      <footer
        class="bg-gray-50 rounded-b-lg px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse"
      >
        <button
          type="submit"
          class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 text-base font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500"
        >
          Lưu
        </button>
        <button
          type="button"
          @click="onSubmit($event, true)"
          class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 text-base font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500"
        >
          Lưu & Đóng
        </button>
        <router-link
          :to="{ name: 'app.products' }"
          class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 text-base font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
          ref="cancelButtonRef"
        >
          Đóng
        </router-link>
      </footer>
    </form>
  </div>
</template>

<script setup>
import { onMounted, ref } from "vue";
import CustomInput from "../../components/core/CustomInput.vue";
import store from "../../store/index.js";
import Spinner from "../../components/core/Spinner.vue";
import { useRoute, useRouter } from "vue-router";
import ImagePreview from "../../components/ImagePreview.vue";
import Treeselect from "vue3-treeselect";
import "vue3-treeselect/dist/vue3-treeselect.css";
import axiosClient from "../../axios.js";

const route = useRoute();
const router = useRouter();

const product = ref({
  id: null,
  title: null,
  images: [],
  deleted_images: [],
  image_positions: {},
  description: "",
  price: null,
  sizes: [], // Danh sách size
  quantity: null,
  published: false,
  categories: [],
});

const errors = ref({});
const loading = ref(false);
const options = ref([]);
const sizeOptions = ref([]); // Danh sách size có sẵn

onMounted(() => {
  if (route.params.id) {
    loading.value = true;
    store.dispatch("getProduct", route.params.id).then((response) => {
      loading.value = false;
      product.value = response.data;

      if (!product.value.sizes) {
        product.value.sizes = [];
      }
      syncSizes();
    });
  }

  axiosClient.get("/sizes").then((response) => {
    sizeOptions.value = response.data;

    // Đồng bộ lại danh sách size nếu đã tải sản phẩm
    if (product.value.sizes) {
      syncSizes();
    }
  });

  axiosClient.get("/categories/tree").then((result) => {
    options.value = result.data;
  });
});

function addSize() {
  if (!Array.isArray(product.value.sizes)) {
    product.value.sizes = [];
  }
  product.value.sizes.push({ id: null, quantity: null });
}

function removeSize(index) {
  product.value.sizes.splice(index, 1);
}

function syncSizes() {
  if (product.value.sizes && sizeOptions.value.length) {
    product.value.sizes = product.value.sizes.map((size) => {
      const matchedSize = sizeOptions.value.find(
        (option) => option.id === size.id
      );
      return {
        id: size.id,
        quantity: size.quantity,
        name: matchedSize ? matchedSize.name : "Unknown",
      };
    });
  }
}
function onSubmit($event, close = false) {
  loading.value = true;
  errors.value = {};
  product.value.quantity = product.value.quantity || null;

  if (product.value.id) {
    store
      .dispatch("updateProduct", product.value)
      .then((response) => {
        loading.value = false;
        if (response.status === 200) {
          product.value = response.data;
          syncSizes();
          store.commit("showToast", "Cập nhật sản phẩm thành công");
          store.dispatch("getProducts");
          if (close) {
            router.push({ name: "app.products" });
          }
        }
      })
      .catch((err) => {
        loading.value = false;
        errors.value = err.response.data.errors;
      });
  } else {
    store
      .dispatch("createProduct", product.value)
      .then((response) => {
        loading.value = false;
        if (response.status === 201) {
          product.value = response.data;
          syncSizes();
          store.commit("showToast", "Tạo sản phẩm thành công");
          store.dispatch("getProducts");
          if (close) {
            router.push({ name: "app.products" });
          } else {
            product.value = response.data;
            router.push({
              name: "app.products.edit",
              params: { id: response.data.id },
            });
          }
        }
      })
      .catch((err) => {
        loading.value = false;
        errors.value = err.response.data.errors;
      });
  }
}
</script>

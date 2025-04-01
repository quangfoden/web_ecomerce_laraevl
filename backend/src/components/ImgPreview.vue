<template>
  <div class="flex flex-col items-center">
    <!-- Hiển thị ảnh xem trước nếu có -->
    <div v-if="previewUrl" class="w-40 h-40 bg-gray-200 rounded-md overflow-hidden">
      <img :src="previewUrl" alt="Preview Image" class="w-full h-full object-cover" />
    </div>
    <!-- Input chọn file -->
    <input type="file" @change="handleFileChange" accept="image/*" class="mt-2" />
  </div>
</template>

<script setup>
import { ref, watch } from "vue";

// Nhận props từ component cha
const props = defineProps({
  image: String, 
  url: String,   
});

const emit = defineEmits(["update:modelValue"]);

const previewUrl = ref(props.url || props.image || null);

function handleFileChange(event) {
  const file = event.target.files[0];
  if (file) {
    previewUrl.value = URL.createObjectURL(file);
    console.log("Preview URL:", previewUrl.value); 
    emit("update:modelValue", file);
  }
}

watch(() => props.image, (newVal) => {
  previewUrl.value = newVal || null;
});
</script>
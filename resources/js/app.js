import './bootstrap';

import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse'
import {get, post} from "./http.js";

Alpine.plugin(collapse)

window.Alpine = Alpine;

document.addEventListener("alpine:init", async () => {

  Alpine.data("toast", () => ({
    visible: false,
    delay: 5000,
    percent: 0,
    interval: null,
    timeout: null,
    message: null,
    type: null,
    close() {
      this.visible = false;
      clearInterval(this.interval);
    },
    show(message, type = 'success') {
      this.visible = true;
      this.message = message;
      this.type = type;

      if (this.interval) {
        clearInterval(this.interval);
        this.interval = null;
      }
      if (this.timeout) {
        clearTimeout(this.timeout);
        this.timeout = null;
      }

      this.timeout = setTimeout(() => {
        this.visible = false;
        this.timeout = null;
      }, this.delay);
      const startDate = Date.now();
      const futureDate = Date.now() + this.delay;
      this.interval = setInterval(() => {
        const date = Date.now();
        this.percent = ((date - startDate) * 100) / (futureDate - startDate);
        if (this.percent >= 100) {
          clearInterval(this.interval);
          this.interval = null;
        }
      }, 30);
    },
  }));

  Alpine.data("productItem", (product) => {
    return {
      product,
      selectedSize: null,
 
      addToCart(quantity = 1) {

        post(this.product.addToCartUrl, {
            size_id: this.selectedSize, // Gửi size được chọn
            quantity,
        })
            .then((result) => {
                this.$dispatch("cart-change", { count: result.count });
                this.$dispatch("notify", {
                    message: "Thêm vào giỏ hàng thành công",
                });
            })
            .catch((response) => {
                console.error(response);
                this.$dispatch("notify", {
                    message: response.message || "Có lỗi xảy ra. Vui lòng thử lại.",
                    type: "error",
                });
            });
    },
      removeItemFromCart() {
        post(this.product.removeUrl)
          .then(result => {
            this.$dispatch("notify", {
              message: "Đã xóa sản phẩm ra khỏi giỏ hàng",
            });
            this.$dispatch('cart-change', {count: result.count})
            this.cartItems = this.cartItems.filter(p => p.id !== product.id)
          })
      },
      changeQuantity() {
        fetch(product.updateQuantityUrl, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
            },
            body: JSON.stringify({ quantity: this.product.quantity }),
        })
            .then((response) => response.json())
            .then((data) => {
              this.$dispatch("notify", {
                message: "Đã cập nhật số lượng thành công.",
              });
            })
            .catch((error) => console.error("Error:", error));
    },

    async fetchComments() {
      try {
          const response = await fetch(`/products/${this.product.id}/comments`);
          this.comments = await response.json();
      } catch (error) {
          console.error('Lỗi khi tải bình luận:', error);
      }
  },
  async submitComment() {
    const content = this.$refs.content.value;
    const rating = this.$refs.rating.value;

    if (!content) {
        alert('Vui lòng nhập nội dung bình luận.');
        return;
    }

    try {
        const response = await fetch(product.addCommentUrl, {
            method: 'POST',
            headers: {
              "Content-Type": "application/json",
              "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
          },
            body: JSON.stringify({
                product_id: this.product.id,
                content: content,
                rating: rating || null
            })
        });

        if (!response.ok) {
            throw new Error('Lỗi khi gửi bình luận.');
        }

        const data = await response.json();
        this.$dispatch("notify", {
          message: data.message,
        });

        // Reset form
        this.$refs.content.value = '';
        this.$refs.rating.value = '';

        // Reload comments
        this.fetchComments();
    } catch (error) {
        console.error('Lỗi khi gửi bình luận:', error);
        alert('Không thể gửi bình luận. Vui lòng thử lại.');
    }
},
init() {
  // Gọi hàm fetchComments khi component được khởi tạo
  this.fetchComments();
}
    };
  });
});


Alpine.start();

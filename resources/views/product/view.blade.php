<x-app-layout>
    <div x-data="productItem({{ json_encode([
        'id' => $product->id,
        'slug' => $product->slug,
        'image' => $product->image ?: '/img/noimage.png',
        'title' => $product->title,
        'price' => $product->price,
        'sizes' => $product->sizes->map(fn($size) => [
            'id' => $size->id,
            'name' => $size->name,
            'quantity' => $size->pivot->quantity
        ]),
        'addToCartUrl' => route('cart.add', $product),
        'addCommentUrl' => route('comments.add'),

    ]) }})" class="product-container" style="margin-top:0;">

        <div class="product-grid">

            <!-- Hình ảnh sản phẩm -->
            <div class="image-section">
                <div x-data="{
                images: {{$product->images->count() ? $product->images->map(fn($im) => $im->url) : json_encode(['/img/noimage.png'])}},
                activeImage: null,
                prev() {
                    let index = this.images.indexOf(this.activeImage);
                    if (index === 0) index = this.images.length;
                    this.activeImage = this.images[index - 1];
                },
                next() {
                    let index = this.images.indexOf(this.activeImage);
                    if (index === this.images.length - 1) index = -1;
                    this.activeImage = this.images[index + 1];
                },
                init() {
                    this.activeImage = this.images.length > 0 ? this.images[0] : null
                }
            }" class="image-gallery">
                    <template x-for="image in images">
                        <div x-show="activeImage === image" class="main-image">
                            <img :src="image" alt="Product Image" />
                        </div>
                    </template>

                    <a @click.prevent="prev" class="nav-button prev-button">&#10094;</a>
                    <a @click.prevent="next" class="nav-button next-button">&#10095;</a>

                    <div class="thumbnails">
                        <template x-for="image in images">
                            <a @click.prevent="activeImage = image" class="thumbnail">
                                <img :src="image" alt="Thumbnail" />
                            </a>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Thông tin sản phẩm -->
            <div class="info-section">
                <h1 class="product-title">{{$product->title}} <span class="product-size">{{$product->size ? 'size' : ''}} {!! $product->size !!}</span></h1>
                <div class="product-price">{{ number_format($product->price, 0, ',', '.') }} vnđ</div>

                @if ($product->quantity === 0)
                <div class="out-of-stock">Sản phẩm này đã hết hàng</div>
                @endif

                <!-- Chọn size -->
                <template x-if="product.sizes.length > 0">
                    <div class="size-selector-container">
                        <label class="size-selector-label">Chọn size:</label>
                        <div class="size-selector-checkboxes">
                            <template x-for="size in product.sizes" :key="size.id">
                                <label class="size-checkbox">
                                    <input type="radio" :value="size.id" x-model="selectedSize" class="size-checkbox-input" />
                                    <span class="size-checkbox-label" x-text="`${size.name}`"></span>
                                </label>
                            </template>
                        </div>
                    </div>
                </template>

                <!-- Số lượng -->
                <div class="quantity-section">
                    <label for="quantity">Số lượng</label>
                    <input type="number" name="quantity" x-ref="quantityEl" value="1" min="1" />
                </div>

                <button :disabled="product.quantity === 0" @click="addToCart($refs.quantityEl.value)" class="add-to-cart-btn button">
                    <span>Thêm vào giỏ hàng</span>
                </button>
                <!-- Nút mở modal -->
                <button class="button" data-bs-toggle="modal" data-bs-target="#teamOrderModal">
                    Đặt hàng theo đội
                </button>

                <!-- Modal -->
                <div class="modal fade" id="teamOrderModal" tabindex="-1" aria-labelledby="teamOrderModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form method="POST" action="{{ route('team-orders.store') }}">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title" id="teamOrderModalLabel">Đặt hàng theo đội</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Đóng"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="team_name" class="form-label">Tên đội</label>
                                        <input type="text" class="form-control" name="team_name" required>
                                    </div>
                                    <input type="hidden" class="form-control" name="product_id" value="{{ $product->id ?? '' }}" required>
                                    <div class="mb-3">
                                        <label for="quantity" class="form-label">Số lượng</label>
                                        <input type="text" class="form-control" name="quantity" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="note" class="form-label">Ghi chú</label>
                                        <textarea class="form-control" name="note" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                    <button type="submit" class="btn btn-success">Gửi đơn</button>
                                    <div id="order-success-message" class="alert alert-success d-none mt-3"></div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="description" x-data="{ expanded: false }">
                    <h1>Mô tả</h1>
                    <div x-show="!expanded" x-collapse x-html="`{!! $product->description !!}`"></div>
                </div>
            </div>

        </div>

        <!-- Danh sách bình luận -->
        <div class="comments-list"  x-show="comments.length > 0">
            <h3 class="comments-title">Bình luận</h3>
            <template x-for="comment in comments" :key="comment.id">
                <div class="comment">
                    <div class="comment-header">
                        <img src="/img/avatadefault.jpg" alt="Avatar" class="comment-avatar" />
                        <div class="comment-info">
                            <span class="comment-author" x-text="comment.user?.name || 'Ẩn danh'"></span>
                            <span class="comment-date" x-text="new Date(comment.created_at).toLocaleString()"></span>
                        </div>
                    </div>
                    <div x-show="comment.rating" class="comment-rating">
                        <template x-for="star in comment.rating">
                            <span class="star">&#9733;</span>
                        </template>
                    </div>
                    <p class="comment-content" x-text="comment.content"></p>
                </div>
            </template>
        </div>

        <!-- Form thêm bình luận -->
        <div class="add-comment">
            <h3 class="add-comment-title">Thêm bình luận</h3>
            <form @submit.prevent="submitComment" class="add-comment-form">
                <textarea x-ref="content" class="add-comment-textarea" rows="4" placeholder="Nhập bình luận của bạn..."></textarea>
                <div class="add-comment-rating">
                    <label for="rating" class="rating-label">Đánh giá:</label>
                    <select x-ref="rating" class="rating-select">
                        <option value="">Không đánh giá</option>
                        <option value="1">1 sao</option>
                        <option value="2">2 sao</option>
                        <option value="3">3 sao</option>
                        <option value="4">4 sao</option>
                        <option value="5">5 sao</option>
                    </select>
                </div>
                <button type="submit" class="add-comment-button">Gửi bình luận</button>
            </form>
        </div>


        @if(isset($products) && count($products) > 0)
        @include('partials.relate-products', ['products' => $products])
        @endif
</x-app-layout>

<script>
    new Swiper("#productSwiper", {
        slidesPerView: 4,
        spaceBetween: 30,
        loop: true,
        autoplay: {
            delay: 3000
        },
    });

    document.querySelector('#teamOrderModal form').addEventListener('submit', async function(e) {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);

        try {
            const response = await axios.post(form.action, formData);

            const messageBox = document.getElementById('order-success-message');
            messageBox.classList.add('show');
            messageBox.innerText = response.data.message;
            setTimeout(() => {
                const modal = bootstrap.Modal.getInstance(document.getElementById('teamOrderModal'));
                modal.hide();
                messageBox.classList.remove('show');
                form.reset();
            }, 3500);

        } catch (error) {
            if (error.response && error.response.data.errors) {
                // Hiển thị lỗi nếu có
                alert('Có lỗi xảy ra: ' + JSON.stringify(error.response.data.errors));
            } else {
                alert('Đã xảy ra lỗi. Vui lòng thử lại.');
            }
        }
    });
</script>
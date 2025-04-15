<h2 class="title text-center box-title" data-aos="fade-left">Danh mục sản phẩm</h2>
<div class="category-section" data-aos="fade-right">
    @foreach ($categories as $category)
        <div class="category-box" style="background-image: url('{{ asset('storage/' . $category->image) }}');">
            <a href="{{ route('byCategory', $category) }}">
                <div class="overlay">
                    <h3>{{ strtoupper($category->name) }}</h3>
                    <span>SHOP COLLECTION ></span>
                </div>
            </a>
        </div>
    @endforeach
</div>

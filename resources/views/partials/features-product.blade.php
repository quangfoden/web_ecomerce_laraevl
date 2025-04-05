<div class="features_items" data-aos="fade-left"> <!--features_items-->
    <h2 class="title text-center box-title">{{$title}}</h2>
    @foreach($products as $product)
    <div class="col-sm-4">
        @include('partials.product-item', ['product' => $product])
    </div>
    @endforeach
</div>
<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\News;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $query = Product::query();

        return $this->renderProducts($query);
    }

    public function byCategory(Category $category)
    {
        $categories = Category::getAllChildrenByParent($category);

        $query = Product::query()
            ->select('products.*')
            ->join('product_categories AS pc', 'pc.product_id', 'products.id')
            ->whereIn('pc.category_id', array_map(fn($c) => $c->id, $categories));

        return $this->renderProducts($query);
    }

    public function view(Product $product)
    {
        // Lấy danh sách category_id của sản phẩm hiện tại từ bảng trung gian `product_categories`
        $categoryIds = $product->categories()->pluck('categories.id');

        // Lấy các sản phẩm liên quan có ít nhất một category chung
        $relatedProducts = Product::whereHas('categories', function ($query) use ($categoryIds) {
            $query->whereIn('categories.id', $categoryIds);
        })
            ->where('products.id', '!=', $product->id)
            ->latest()
            ->take(6)
            ->get();

        // Load sizes của sản phẩm
        $product->load('sizes');

        return view('product.view', [
            'product' => $product,
            'products' => $relatedProducts,
            'title' => "Sản phẩm liên quan"
        ]);
    }


    private function renderProducts(Builder $query)
    {
        $search = \request()->get('search');
        $sort = \request()->get('sort', '-updated_at');

        if ($sort) {
            $sortDirection = 'asc';
            if ($sort[0] === '-') {
                $sortDirection = 'desc';
            }
            $sortField = preg_replace('/^-?/', '', $sort);

            $query->orderBy($sortField, $sortDirection);
        }
        $products = $query
            ->with('sizes') // Load sizes
            ->where('published', '=', 1)
            ->where(function ($query) use ($search) {
                /** @var $query \Illuminate\Database\Eloquent\Builder */
                $query->where('products.title', 'like', "%$search%")
                    ->orWhere('products.description', 'like', "%$search%");
            })
            ->paginate(15);

        $news = News::latest()->take(10)->get();
        return view('product.index', [
            'products' => $products,
            'news' => $news
        ]);
    }
}

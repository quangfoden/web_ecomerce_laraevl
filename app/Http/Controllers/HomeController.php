<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index()
    {
        $products = Product::where('published', 1)
            ->orderBy('created_at', 'desc') 
            ->take(10) 
            ->get();
            $news = News::latest()->take(10)->get();
            $title='Sản phẩm mới';
            $newstitle = "Tin tức mới";
            return view('home', compact('products', 'news','title','newstitle'));
    }
}

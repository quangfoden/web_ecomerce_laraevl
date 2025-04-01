<?php

namespace App\Http\Controllers;

use App\Models\CategoryNews;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    //
    public function index(Request $request)
    {
        // Lấy tất cả danh mục tin tức
        $categories = CategoryNews::all();

        // Lấy danh mục đầu tiên làm mặc định nếu không có danh mục nào được chọn
        $selectedCategoryId = $request->category ?? $categories->first()->id;

        // Lọc tin tức theo danh mục được chọn
        $news = News::where('category_id', $selectedCategoryId)->latest()->get();

        return view('news.index', compact('news', 'categories', 'selectedCategoryId'));
    }

    public function show($slug)
    {
        // Lấy tin tức hiện tại
        $news = News::where('slug', $slug)->firstOrFail();
    
        // Lấy danh sách tin tức liên quan (cùng category nhưng không bao gồm chính nó)
        $relatedNews = News::where('category_id', $news->category_id)
                            ->where('id', '!=', $news->id) // Loại trừ chính nó
                            ->latest()
                            ->take(5) // Giới hạn 5 bài viết
                            ->get();
    
        return view('news.show', [
            'news' => $news,
            'newstitle' => "Tin tức liên quan",
            'relatedNews' => $relatedNews
        ]);
    }
    
}

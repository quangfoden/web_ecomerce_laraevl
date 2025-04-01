<?php

namespace App\Http\Controllers\Api;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\UploadedFile;

class NewsController extends Controller
{
    public function index()
    {
        return response()->json(News::with('category')->latest()->get());
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required',
            'category_id' => 'required|exists:category_news,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $slug = $request->slug ?? Str::slug($request->title, '-');
        // Lưu ảnh vào storage
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('categoriesnews', 'public');
        }

        $news = News::create([
            'title' => $request->title,
            'slug' =>  $slug,
            'content' => $request->content,
            'image' => $imagePath,
            'url' => URL::to(Storage::url($imagePath)),
            'category_id' => $request->category_id,
        ]);

        return response()->json(['message' => 'Tạo bài viết thành công!', 'data' => $news], 201);
    }

    public function update(Request $request, News $news)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'category_id' => 'required|exists:category_news,id'
        ]);
        $imagePath = $news->image; // Giữ nguyên đường dẫn ảnh cũ
        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu có
            if ($news->image) {
                Storage::disk('public')->delete($news->image);
            }
            $imagePath = $request->file('image')->store('categoriesnews', 'public');
        }
        $news->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'image' => $imagePath,
            'url' => URL::to(Storage::url($imagePath)),
            'category_id' => $request->category_id,
        ]);

        return response()->json($news);
    }

    public function destroy(News $news)
    {
        $news->delete();
        return response()->json(['message' => 'Bài viết đã bị xóa']);
    }
}

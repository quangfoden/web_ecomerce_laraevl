<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategoryTreeResource;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\UploadedFile;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sortField = request('sort_field', 'created_at');
        $sortDirection = request('sort_direction', 'desc');

        $categories = Category::query()
            ->orderBy($sortField, $sortDirection)
            ->latest()
            ->get();
        return CategoryResource::collection($categories);
    }

    public function getAsTree()
    {
        return Category::getActiveAsTree(CategoryTreeResource::class);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = $request->user()->id;
        $data['updated_by'] = $request->user()->id;
    
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('categories', 'public');
            $data['image'] = $path;
            $data['url'] = URL::to(Storage::url($path)); 
        }
    
        $category = Category::create($data);
    
        return new CategoryResource($category);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCategoryRequest $request, $id)
    {
        $data = $request->validated();
        $category = Category::findOrFail($id);

        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu có
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $path = $request->file('image')->store('categories', 'public');
            $data['image'] = $path;
            $data['url'] = URL::to(Storage::url($path)); 
        }
        $category->update($data);

        return new CategoryResource($category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return response()->noContent();
    }
}

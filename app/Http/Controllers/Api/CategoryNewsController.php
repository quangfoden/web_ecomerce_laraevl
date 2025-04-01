<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CategoryNews;
use Illuminate\Http\Request;

class CategoryNewsController extends Controller
{
    public function index()
    {
        return response()->json(CategoryNews::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:category_news|max:255',
            'description' => 'nullable|string',
        ]);

        $category = CategoryNews::create($request->all());

        return response()->json($category, 201);
    }

    public function update(Request $request, $id)
    {
        $category = CategoryNews::findOrFail($id);
        $request->validate([
            'name' => 'required|max:255|unique:category_news,name,' . $category->id,
            'description' => 'nullable|string',
        ]);

        $category->update($request->all());

        return response()->json($category);
    }

    public function destroy($id)
    {
        CategoryNews::findOrFail($id)->delete();
        return response()->json(['message' => 'Danh mục đã bị xóa!']);
    }
}

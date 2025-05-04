<?php 
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Size;

class SizeController extends Controller
{
    public function index()
    {
        try {
            $sizes = Size::all();
            return response()->json($sizes);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
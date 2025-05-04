<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index($productId)
    {
        // Lấy danh sách bình luận của sản phẩm
        $comments = Comment::where('product_id', $productId)
            ->where('status', 'approved') // Chỉ lấy bình luận đã được duyệt
            ->with('user') // Load thông tin người dùng
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($comments);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'content' => 'required|string',
            'rating' => 'nullable|integer|min:1|max:5',
        ]);

        $comment = Comment::create([
            'user_id' => auth()->id(),
            'product_id' => $request->product_id,
            'content' => $request->content,
            'rating' => $request->rating,
            'status' => 'approved', // Bình luận mới sẽ ở trạng thái chờ duyệt
        ]);

        return response()->json([
            'message' => 'Bình luận thành công.',
            'comment' => $comment,
        ]);
    }
}
<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TeamOrderResource;
use App\Models\TeamOrder;
use Illuminate\Http\Request;

class TeamOrderController extends Controller
{
    public function index(Request $request)
    {
        $teamOrders = TeamOrder::with(['user', 'product'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return TeamOrderResource::collection($teamOrders);
    }

    public function changeStatus(Request $request, TeamOrder $teamOrder)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed',
        ]);

        $teamOrder->status = $request->status;
        $teamOrder->save();

        return response()->json([
            'message' => 'Trạng thái đã được cập nhật thành công.',
            'data' => $teamOrder,
        ]);
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\TeamOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamOrderController extends Controller
{
    //
    public function store(Request $request)
    {
        $request->validate([
            'team_name' => 'required|string|max:255',
            'product_id' => 'required|integer',
            'quantity' => 'required',
            'note' => 'nullable|string',
        ]);

        TeamOrder::create([
            'team_name' => $request->team_name,
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'note' => $request->note,
        ]);

        return response()->json(['message' => 'Đặt hàng theo đội thành công!']);
    }
}

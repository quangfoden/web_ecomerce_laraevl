<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TeamOrderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'team_name' => $this->team_name,
            'user' => $this->user ? [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email,
            ] : null,
            'product' => $this->product ? [
                'id' => $this->product->id,
                'title' => $this->product->title,
            ] : null,
            'quantity' => $this->quantity,
            'note' => $this->note,
            'status' => $this->status,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
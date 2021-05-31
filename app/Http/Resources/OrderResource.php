<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_name' => $this->user->name,
            'order_status' => $this->order_status->name,
            'payment_status' => $this->payment_status->name,
            'products' => $this->products,
            'count' => $this->count,
            'total' => $this->total,
            'date' => $this->format_date
        ];
    }
}

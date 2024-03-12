<?php

namespace App\Http\Resources\Order;

use App\Http\Resources\Item\ItemResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return[
            'id'              => $this->id,
            'discount_amount' => $this->discount_amount,
            'original_amount' => $this->original_amount,
            'total_amount'    => $this->sub_total,
            'quantity'        => $this->quantity,
            'sub_total'       => $this->sub_total,
            'order_id'        => $this->order_id,
            'item_id'         => $this->item_id,
            'items'           => ItemResource::collection($this->getItems()->get())
        ];
    }
}
<?php

namespace App\Http\Resources\Order;

use App\Http\Resources\Item\ItemResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return[
            'id'              => $this->id,
            'name'            => $this->name,
            'price'           => $this->price,
            'code_no'         => $this->code_no,
            'image'           => $this->image,
            'discount_amount' => $this->discount_amount,
            'original_amount' => $this->price - $this->discount_amount,
            'total_amount'    => $this->price - $this->discount_amount,
            'quantity'        => $this->quantity ?? 1,
            // 'items'           => ItemResource::collection($this->getItems()->get())
        ];
    }
}

<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Order\OrderDetailResource;
class OrderListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'status'     => $this->status,
            'order_no'   => $this->order_no,
            'created_at' => [
                'date' => $this->created_at->format('Y-m-d'),
                'time' => $this->created_at->format('H:i:s'),
            ],
            'orderDetail' => OrderDetailResource::collection($this->getOrderDetail()->get()),
        ];
    }
}

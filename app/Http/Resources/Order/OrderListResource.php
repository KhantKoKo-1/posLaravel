<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Order\OrderDetailResource;
class OrderListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'         => isset($this['order']->id) ? $this['order']->id : $this->id,
            'status'     => isset($this['order']->status) ? $this['order']->status : $this->status,
            'order_no'   => isset($this['order']->order_no) ? $this['order']->order_no : $this->order_no,
            'created_at' => [
                'date' => isset($this['order']->created_at) ? $this['order']->created_at->format('Y-m-d') : $this->created_at->format('Y-m-d'),
                'time' => isset($this['order']->created_at) ? $this['order']->created_at->format('H:i:s') : $this->created_at->format('H:i:s'),
            ],
            'setting'     => $this['setting'] ?? null,
            'orderDetail' => OrderDetailResource::collection(isset($this['order']) ? $this['order']->getOrderDetail()->get() : $this->getOrderDetail()->get())
        ];
    }
}
<?php

namespace Database\Factories;

use App\Constant;
use App\Models\Shift;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shift>
 */
class ShiftFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    private $dateDiff = 99;

    public function definition()
    {
        Shift::truncate();
        Order::truncate();
        OrderDetail::truncate();
        $startDate = date('Y-m-d');
        $startDate = date('Y-m-d H:i:s', strtotime($startDate . '-'. $this->dateDiff .' day'));
        $this->dateDiff--;
        $endDate = date('Y-m-d H:i:s', strtotime($startDate . ' +8 hours'));
    
        return [
            'start_date_time' => $startDate,
            'end_date_time'   => $endDate,
            'created_by'      => 1,
            'updated_by'      => 1,
            'created_at'      => $startDate,
            'updated_at'      => $endDate,
        ];
    }

    public function withOrders($minCount = 1, $maxCount = 5)
    {
        return $this->afterCreating(function (Shift $shift) use ($minCount, $maxCount) {
            $count = rand($minCount, $maxCount);    
            for ($i = 0; $i < $count; $i++) {
                $order = Order::factory()->create([
                    'shift_id'        => $shift->id,
                    'total_amount'    => 30000,
                    'created_by'      => 1,
                    'updated_by'      => 1,
                    'created_at'      => $shift->created_at,
                    'updated_at'      => $shift->updated_at,
                ]);
    
                $items     = Item::whereNull('deleted_at')->get()->shuffle()->take(5);
                $subTotal  = 0;
                foreach ($items as $item) {
                    $subTotal += $item->price;
                    OrderDetail::factory()->create([
                        'quantity'         => 1,
                        'original_amount'  => $item->price,
                        'discount_amount'  => 0,
                        'sub_total'        => $item->price,
                        'order_id'         => $order->id,
                        'item_id'          => $item->id,
                        'created_by'      => 1,
                        'updated_by'      => 1,
                        'created_at'      => $order->created_at,
                        'updated_at'      => $order->updated_at,
                    ]);
                }
                $random_array = [0,100,200,500,1000,5000,1000];
                $random_index = array_rand($random_array);
                $refund = $random_array[$random_index];
                $updateOrder = Order::find($order->id);
                $updateOrder->total_amount = $subTotal;
                $updateOrder->status = Constant::PAID;
                $updateOrder->refund = $refund;
                $updateOrder->payment = $subTotal + $refund;
                $updateOrder->save();
            }
        });
    }    
}

<?php

namespace App\Repositories\Shift;

use App\Models\Order;
use App\Models\Shift;
use App\Repositories\Shift\ShiftRepositoryInterface;
use App\ReturnMessage;
use App\Utility;
use Illuminate\Support\Facades\DB;

class ShiftRepository implements ShiftRepositoryInterface
{
    public function shiftValidation()
    {
        $shift = Shift::select(DB::raw('COUNT(id) AS total'))
            ->whereNotNull('start_date_time')
            ->whereNull('end_date_time')
            ->first();
        $result = $shift['total'];
        return $result;
    }

    public function selectAllShift()
    {
        $shifts = Shift::select('id', 'start_date_time', 'end_date_time')
            ->whereNull('deleted_at')
            ->orderByDesc('id')
            ->paginate(10);
        return $shifts;
    }

    public function startShift()
    {
        $data = ['start_date_time' => now()];
        $ins_data = Utility::saveCreated((array) $data);
        $result = Shift::create($ins_data);
        if ($result) {
            $response = ReturnMessage::OK;
        } else {
            $response = ReturnMessage::INTERNAL_SERVER_ERROR;
        }
        return $response;
    }

    public function endShift()
    {
        $update_shift = Shift::whereNull('end_date_time')->first();
        $data = ['end_date_time' => now()];
        $data = Utility::saveUpdated((array) $data);
        $result = $update_shift->update($data);
        if ($result) {
            $response = ReturnMessage::OK;
        } else {
            $response = ReturnMessage::INTERNAL_SERVER_ERROR;
        }
        return $response;
    }

    public function selectOrdersByShiftId(int $shift_id, bool $download)
    {
        $orders = Order::selectRaw('CONCAT("' . $shift_id . '", "-", id, "-", DATE_FORMAT(created_at, "%Y%m%d")) as order_no')
            ->addSelect(
                DB::raw("TIME(created_at) AS order_time"),
                DB::raw("CASE 
                        WHEN payment = 0 THEN 'unpaid'
                        ELSE payment
                    END AS payment"),
                DB::raw("CASE 
                        WHEN payment = 0 AND refund = 0 THEN 'unpaid'
                        WHEN refund = 0 THEN '0'
                        ELSE refund
                    END AS refund"),
                DB::raw("CASE 
                        WHEN status = 0 THEN 'unpaid' 
                        WHEN status = 1 THEN 'paid' 
                        WHEN status = 2 THEN 'cancelled' 
                        ELSE 'unknown' 
                    END AS status"),
                'total_amount'
            )
            ->where('shift_id', $shift_id)
            ->whereNull('deleted_at')
            ->orderBy('id', 'DESC');

        if ($download) {
            $orders = $orders->get();
        } else {
            $orders = $orders->paginate(10);
        }
        return $orders;
    }

}
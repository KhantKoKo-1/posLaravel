<?php

namespace App\Repositories\Report;

use App\Constant;
use App\Models\Item;
use App\Models\Order;
use App\Models\PaymentHistory;
use App\Models\Shift;
use App\Repositories\Report\ReportRepositoryInterface;
use App\ReturnMessage;
use App\Utility;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportRepository implements ReportRepositoryInterface
{
    public function dailySaleReport($start, $end)
    {
        $dates = Utility::dailySaleDates($start, $end);
        $data = [];
        foreach ($dates as $shift_date) {
            $shifts = Shift::select('id')->whereRaw('DATE(start_date_time) = ?', [$shift_date])->get();
            $total_amount = 0;
            foreach ($shifts as $shift) {
                $total_amount = Order::where('shift_id', $shift->id)->sum('total_amount');
            }
            $data[] = (object) [
                'date' => $shift_date,
                'amount' => $total_amount,
                'total' => ''
            ];
        }
        $data[] = (object) ['total' => array_sum(array_column($data, 'amount'))];
        return $data;
    }

    public function monthlySaleReportGraph($start_month, $end_month)
    {
        $sale_months = Utility::monthlySaleDates($start_month, $end_month);
        $data = [];
        $month = [];
        $amount = [];
        foreach ($sale_months as $shift_month) {
            $shifts = Shift::select('id')->whereRaw('DATE_FORMAT(start_date_time, "%Y-%m") = ?', [$shift_month])->get();
            $total_amount = 0;
            if (!$shifts->isEmpty()) {
                foreach ($shifts as $shift) {
                    $total_amount = Order::where('shift_id', $shift->id)->sum('total_amount');
                }
                $formated_month = Carbon::createFromFormat('Y-m', $shift_month)->format('F');
                $month[] = (array) [
                    $formated_month,
                ];
                $amount[] = (array) [
                    $total_amount
                ];
            }

        }
        $data['months'] = $month;
        $data['amounts'] = $amount;
        return $data;
    }

    public function monthlySaleReport($start_month, $end_month)
    {
        $sale_months = Utility::monthlySaleDates($start_month, $end_month);
        $data = [];
        foreach ($sale_months as $shift_month) {
            $shifts = Shift::select('id')->whereRaw('DATE_FORMAT(start_date_time, "%Y-%m") = ?', [$shift_month])->get();
            $total_amount = 0;
            if (!$shifts->isEmpty()) {
                foreach ($shifts as $shift) {
                    $total_amount = Order::where('shift_id', $shift->id)->sum('total_amount');
                }
                $data[] = (object) [
                    'date' => $shift_month,
                    'amount' => $total_amount,
                    'total' => ''
                ];
            }
        }
        $data[] = (object) ['total' => array_sum(array_column($data, 'amount'))];
        return $data;
    }

    public function dailyBestSaleItemReport($start_date, $end_date)
    {
        $sale_dates = Utility::dailySaleDates($start_date, $end_date);
        $data = [];
        foreach ($sale_dates as $sale_date) {
            $item_details = Item::select('item.id', 'item.name', DB::raw('COALESCE(SUM(order_detail.original_amount * order_detail.quantity), 0) AS total_sum_price'), DB::raw('COALESCE(SUM(order_detail.quantity), 0) AS total_sum_quantity'))
                ->leftJoin('order_detail', 'item.id', '=', 'order_detail.item_id')
                ->whereRaw('DATE_FORMAT(order_detail.created_at, "%Y-%m-%d") = ?', [$sale_date])
                ->groupBy('item.id', 'item.name')
                ->orderByDesc('total_sum_quantity')
                ->get();

            if (!$item_details->isEmpty()) {
                $data[] = (object) [
                    'date' => $sale_date,
                    'item_name' => $item_details[0]->name,
                    'total_price' => $item_details[0]->total_sum_price,
                    'total_quantity' => $item_details[0]->total_sum_quantity,
                ];
            }
        }
        return $data;
    }

    public function paymentHistoryLog($shift_date)
    {

        $payments = PaymentHistory::select('payment_history.cash', DB::raw('SUM(payment_history.quantity) as total_quantity'))
            ->leftJoin('order', 'payment_history.order_id', '=', 'order.id')
            ->leftJoin('shift', 'order.shift_id', '=', 'shift.id')
            ->whereNull('payment_history.deleted_at')
            ->whereNull('order.deleted_at')
            ->whereNull('shift.deleted_at')
            ->whereDate('shift.start_date_time', $shift_date)
            ->groupBy('payment_history.cash')
            ->get();
        return $payments;
    }

    public function monthlyBestSaleItemReportGraph()
    {
        $sale_months = Utility::monthlySaleDates(null, null);
        $data = [];
        foreach ($sale_months as $sale_month) {
            $item_details = Item::select('item.id', 'item.name', DB::raw('COALESCE(SUM(order_detail.original_amount * order_detail.quantity), 0) AS total_sum_price'), DB::raw('COALESCE(SUM(order_detail.quantity), 0) AS total_sum_quantity'))
                ->leftJoin('order_detail', 'item.id', '=', 'order_detail.item_id')
                ->whereRaw('DATE_FORMAT(order_detail.created_at, "%Y-%m") = ?', [$sale_month])
                ->groupBy('item.id', 'item.name')
                ->orderByDesc('total_sum_quantity')
                ->get();

            if (!$item_details->isEmpty()) {
                $formated_month = Carbon::createFromFormat('Y-m', $sale_month)->format('F');
                $month[] = (array) [
                    $formated_month,
                ];
                $name[] = (array) [
                    $item_details[0]->name,
                ];
                $quantity[] = (array) [
                    (int) ($item_details[0]->total_sum_quantity),
                ];
            }
        }
        $data['months'] = $month;
        $data['name'] = $name;
        $data['quantities'] = $quantity;
        return $data;
    }

    public function monthlyBestSaleItemReport($start_month, $end_month)
    {
        $sale_months = Utility::monthlySaleDates($start_month, $end_month);
        $data = [];
        foreach ($sale_months as $sale_month) {
            $item_details = Item::select('item.id', 'item.name', DB::raw('COALESCE(SUM(order_detail.original_amount * order_detail.quantity), 0) AS total_sum_price'), DB::raw('COALESCE(SUM(order_detail.quantity), 0) AS total_sum_quantity'))
                ->leftJoin('order_detail', 'item.id', '=', 'order_detail.item_id')
                ->whereRaw('DATE_FORMAT(order_detail.created_at, "%Y-%m") = ?', [$sale_month])
                ->groupBy('item.id', 'item.name')
                ->orderByDesc('total_sum_quantity')
                ->get();

            if (!$item_details->isEmpty()) {
                $data[] = (object) [
                    'date' => $sale_month,
                    'item_name' => $item_details[0]->name,
                    'total_price' => $item_details[0]->total_sum_price,
                    'total_quantity' => $item_details[0]->total_sum_quantity,
                ];
            }
        }

        return $data;
    }
}

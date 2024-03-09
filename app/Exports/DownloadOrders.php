<?php

namespace App\Exports;

use App\Models\Order;
use App\Models\Shift;
use App\Repositories\Shift\ShiftRepositoryInterface;
use App\Utility;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;

class DownloadOrders implements FromCollection, WithTitle, WithHeadings,WithStyles
{
    private $shiftRepository;
 
    public function __construct( ShiftRepositoryInterface $shiftRepository) {

        DB::connection()->enableQueryLog();
        $this->shiftRepository  = $shiftRepository;
    }

    protected $orderData;
    protected $title = "Orders";

    public function title(): string
    {
        return $this->title;
    }

    public function collection()
    {
        $orderData = $this->DownloadOrderResult();
        $totalAmount = $orderData->sum('total_amount');
        $orderData->push(['Order No' => '', 'Time' => '','Payment' => '', 'Refund' => '', 'Time' => '','Status' => '',  'Total' => $totalAmount]);
        $this->totalRowNumber = count($orderData) + 1;
        return collect($orderData);
    }
    

    public function setShiftId($shift_id) {
        $this->shift_id = $shift_id;
        return $this;

    }

    public function headings(): array
    {
        return [
            'Order No',
            'Time',
            'Payment',
            'Refund',
            'Status',
            'Total',
        ];
    }

    public function DownloadOrderResult()
    {

       $result = $this->shiftRepository->selectOrdersByShiftId($this->shift_id,(bool) true);
       return collect($result);
    }

    public function styles($excel)
    {
        return [
            1 => ['font' => ['bold' => true]],
            $this->totalRowNumber => ['font' => ['bold' => true]],
        ];
    }

}
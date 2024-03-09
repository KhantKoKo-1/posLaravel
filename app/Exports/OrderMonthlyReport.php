<?php

namespace App\Exports;

use App\Models\Order;
use App\Models\Shift;
use App\Repositories\Report\ReportRepositoryInterface;
use App\Utility;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;

class OrderMonthlyReport implements FromCollection, WithTitle, WithHeadings,WithStyles
{
    private $orderMonthlyRepository;
    private $start;
    private $end;

    public function __construct( ReportRepositoryInterface $orderMonthlyRepository) {

        DB::connection()->enableQueryLog();
        $this->orderMonthlyRepository     = $orderMonthlyRepository;
        $this->start                    = null;
        $this->end                      = null;
    }

    protected $weeklyData;
    protected $title = "Monthly Report";

    public function title(): string
    {
        return $this->title;
    }

        public function collection()
    {
        $monthlyData = $this->monthlyReportDownload();
        $monthlyData->pop();
        $totalAmount = $monthlyData->sum('amount');

        $monthlyData->push(['Date' => '', 'Amount' => '', 'Total' => $totalAmount]);
        $this->totalRowNumber = $monthlyData->count() + 1;

        return $monthlyData;
    }
    public function setDateRange($start,$end) {
        $this->start = $start;
        $this->end   = $end;
        // dd($this->collection());
        return $this;

    }

    public function headings(): array
    {
        return [
            'Date',
            'Amount',
            'Total'
        ];
    }

    public function monthlyReportDownload()
    {

       $result = $this->orderMonthlyRepository->monthlySaleReport($this->start,$this->end);
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
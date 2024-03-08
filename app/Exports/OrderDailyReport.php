<?php

namespace App\Exports;

use App\Utility;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Shift;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Repositories\Report\ReportRepositoryInterface;

class OrderDailyReport implements FromCollection, WithTitle, WithHeadings,WithStyles
{
    private $reportRepository;
    private $start;
    private $end;

    public function __construct( ReportRepositoryInterface $reportRepository) {

        DB::connection()->enableQueryLog();
        $this->reportRepository     = $reportRepository;
        $this->start                    = null;
        $this->end                      = null;
    }

    protected $weeklyData;
    protected $title = "Weekly Report";

    public function title(): string
    {
        return $this->title;
    }

        public function collection()
    {
        $dailyData = $this->dailyReportDownload();
        $dailyData->pop();
        $totalAmount = $dailyData->sum('amount');

        $dailyData->push(['Date' => '', 'Amount' => '', 'Total' => $totalAmount]);
        $this->totalRowNumber = $dailyData->count() + 1;

        return $dailyData;
    }
    public function setDateRange($start,$end) {
        $this->start = $start;
        $this->end   = $end;
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

    public function dailyReportDownload()
    {

       $result = $this->reportRepository->dailySaleReport($this->start,$this->end);
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

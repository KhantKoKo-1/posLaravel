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

class PaymentHistoryReport implements FromCollection, WithTitle, WithHeadings, WithStyles
{
    private $reportRepository;
    private $shift_date;

    public function __construct(ReportRepositoryInterface $reportRepository)
    {

        DB::connection()->enableQueryLog();
        $this->reportRepository     = $reportRepository;
        $this->shift_date                = null;
    }

    protected $weeklyData;
    protected $title = "Payment History Report";

    public function title(): string
    {
        return $this->title;
    }

    public function collection()
    {
        $historyies = $this->historyReportDownload();
        $totalAmount = $historyies->sum('amount');

        $historyies->push(['Cash' => '', 'Quantity' => '', 'Total' => $totalAmount]);
        $this->totalRowNumber = $historyies->count() + 1;

        return $historyies;
    }
    public function setDateRange($shift_date)
    {
        $this->shift_date = $shift_date;
        return $this;

    }

    public function headings(): array
    {
        return [
            'Cash',
            'Quantity',
        ];
    }

    public function historyReportDownload()
    {

        $result = $this->reportRepository->paymentHistoryLog($this->shift_date);
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

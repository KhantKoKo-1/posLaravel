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

class ItemDailyReport implements FromCollection, WithTitle, WithHeadings, WithStyles
{
    private $reportRepository;
    private $start;
    private $end;

    public function __construct(ReportRepositoryInterface $reportRepository)
    {

        DB::connection()->enableQueryLog();
        $this->reportRepository     = $reportRepository;
        $this->start                    = null;
        $this->end                      = null;
    }

    protected $dailyData;
    protected $title = "Daily Report";

    public function title(): string
    {
        return $this->title;
    }

    public function collection()
    {
        $dailyData = $this->dailyItemReportDownload();
        $totalQuantity = $dailyData->sum('total_quantity');
        $totalPrice = $dailyData->sum('total_price');
        $dailyData->push(['Date' => 'Total', 'Item Name' => '','Price' => $totalPrice, 'Quantity' => $totalQuantity]);
        $this->totalRowNumber = $dailyData->count() + 1;
        return $dailyData;
    }

    public function setDateRange($start, $end)
    {
        $this->start = $start;
        $this->end   = $end;
        return $this;
    }

    public function headings(): array
    {
        return [
            'Date',
            'Item Name',
            'Price',
            'Quantity',
        ];
    }

    public function dailyItemReportDownload()
    {

        $result = $this->reportRepository->dailyBestSaleItemReport($this->start, $this->end);
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

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

class ItemMonthlyReport implements FromCollection, WithTitle, WithHeadings, WithStyles
{
    private $itemMonthlyRepository;
    private $start;
    private $end;

    public function __construct(ReportRepositoryInterface $itemMonthlyRepository)
    {
        DB::connection()->enableQueryLog();
        $this->itemMonthlyRepository     = $itemMonthlyRepository;
        $this->start                    = null;
        $this->end                      = null;
    }

    protected $monthlyData;
    protected $title = "Monthly Report";

    public function title(): string
    {
        return $this->title;
    }

    public function collection()
    {
        $monthlyData = $this->itemMonthlyReportDownload();
        $totalQuantity = $monthlyData->sum('total_quantity');
        $totalPrice = $monthlyData->sum('total_price');
        $monthlyData->push(['Date' => 'Total', 'Item Name' => '','Price' => $totalPrice, 'Quantity' => $totalQuantity]);
        $this->totalRowNumber = $monthlyData->count() + 1;
        return $monthlyData;
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

    public function itemMonthlyReportDownload()
    {
        $result = $this->itemMonthlyRepository->monthlyBestSaleItemReport($this->start, $this->end);
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
<?php

namespace App\Repositories\Report;

interface ReportRepositoryInterface
{
    public function dailySaleReport($start, $end);
    public function monthlySaleReportGraph($start_month, $end_month);
    public function monthlySaleReport($start_month, $end_month);
    public function paymentHistoryLog($shift_date);
    public function dailyBestSaleItemReport($start_date, $end_date);
    public function monthlyBestSaleItemReportGraph();
    public function monthlyBestSaleItemReport($start_month, $end_month);
}

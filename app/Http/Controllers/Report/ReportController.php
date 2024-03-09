<?php

namespace App\Http\Controllers\Report;

use App\Exports\ItemDailyReport;
use App\Exports\ItemMonthlyReport;
use App\Exports\OrderDailyReport;
use App\Exports\OrderMonthlyReport;
use App\Exports\PaymentHistoryReport;
use App\Http\Controllers\Controller;
use App\Http\Requests\DailyReportRequest;
use App\Http\Requests\MonthlyReportRequest;
use App\Repositories\Report\ReportRepositoryInterface;
use App\Utility;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    private $reportRepository;
    public function __construct(ReportRepositoryInterface $reportRepository)
    {
        DB::connection()->enableQueryLog();
        $this->reportRepository = $reportRepository;
    }

    public function getDailyReportGraph()
    {
        $screen = "Get Daily Report !!";
        try {
            $result = $this->reportRepository->dailySaleReport(null, null);
            $queryLog = DB::getQueryLog();
            Utility::saveDebugLog($screen, $queryLog);
            return $result;
        } catch (\Exception $e) {
            Utility::saveErrorLog($screen, $e->getMessage());
            abort(500);
        }
    }

    public function getDailyReport(DailyReportRequest $request)
    {
        $screen = "Daily Report!!";
        try {
            $start = isset($request['start_date']) ? $request['start_date'] : null;
            $end = isset($request['end_date']) ? $request['end_date'] : null;
            $sale_reports = $this->reportRepository->dailySaleReport($start, $end);
            $queryLog = DB::getQueryLog();
            Utility::saveDebugLog($screen, $queryLog);
            return view('backend.report.daily_report', compact('sale_reports', 'start', 'end'));
        } catch (\Exception $e) {
            Utility::saveErrorLog($screen, $e->getMessage());
            abort(500);
        }
    }

    public function dailyReportDownload(DailyReportRequest $request, OrderDailyReport $dailyOrderReport)
    {
        $screen = "Daily Report Download!!";
        try {
            $start = isset($request['start_date']) ? $request['start_date'] : null;
            $end = isset($request['end_date']) ? $request['end_date'] : null;
            $today_date = date('YmdHis');
            return Excel::download($dailyOrderReport->setDateRange($start, $end), $today_date . '-dailyReport.xlsx');
        } catch (Exception $e) {
            $screen = 'Daily Report Download:: ';
            $queryLog = DB::getQueryLog();

            Utility::saveErrorLog($screen, $e->getMessage());
            return back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function getMonthlyReportGraph()
    {
        $screen = "Get Monthly Report For Graph !!";
        try {
            $result = $this->reportRepository->monthlySaleReportGraph(null, null);
            $queryLog = DB::getQueryLog();
            Utility::saveDebugLog($screen, $queryLog);
            return $result;
        } catch (\Exception $e) {
            Utility::saveErrorLog($screen, $e->getMessage());
            abort(500);
        }
    }

    public function getMonthlyReport(MonthlyReportRequest $request)
    {
        $screen = "Monthly Report!!";
        try {
            $start_month = isset($request['start_month']) ? $request['start_month'] : null;
            $end_month = isset($request['end_month']) ? $request['end_month'] : null;
            $sale_reports = $this->reportRepository->monthlySaleReport($start_month, $end_month);
            Utility::saveInfoLog($screen);
            return view('backend.report.monthly_report', compact('sale_reports', 'start_month', 'end_month'));
        } catch (\Exception $e) {
            Utility::saveErrorLog($screen, $e->getMessage());
            abort(500);
        }
    }

    public function monthlyReportDownload(MonthlyReportRequest $request, OrderMonthlyReport $monthlyOrderReport)
    {
        $screen = "Monthly Report Download ::";
        try {
            $start = isset($request['start']) ? $request['start'] : null;
            $end = isset($request['end']) ? $request['end'] : null;
            $today_date = date('Ymd\His');
            return Excel::download($monthlyOrderReport->setDateRange($start, $end), $today_date . '-monthlyReport.xlsx');
        } catch (Exception $e) {
            $queryLog = DB::getQueryLog();
            Utility::saveErrorLog($screen, $e->getMessage());
            return back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function getPaymentHistory(DailyReportRequest $request)
    {
        $screen = "Payment History Report!!";
        try {
            $shift_date = $request->date;
            $payments = $this->reportRepository->paymentHistoryLog($shift_date);
            Utility::saveInfoLog($screen);
            return view('backend.report.payment_history', compact('payments', 'shift_date'));
        } catch (\Exception $e) {
            Utility::saveErrorLog($screen, $e->getMessage());
            abort(500);
        }
    }

    public function paymentHistoryDownload(DailyReportRequest $request, PaymentHistoryReport $paymentHistoryReport)
    {
        $screen = "Payment History Download Report!!";
        try {
            $shift_date = isset($request['shift_date']) ? $request['shift_date'] : null;
            $today_date = date('Ymd\His');
            return Excel::download($paymentHistoryReport->setDateRange($shift_date), $today_date . '-paymentHistoryReport.xlsx');
        } catch (\Exception $e) {
            Utility::saveErrorLog($screen, $e->getMessage());
            abort(500);
        }
    }

    public function getDailyItemReportGraph()
    {
        $screen = "Get Daily Item Report !!";
        try {
            $result = $this->reportRepository->dailyBestSaleItemReport(null, null);
            $queryLog = DB::getQueryLog();
            Utility::saveDebugLog($screen, $queryLog);
            return $result;
        } catch (\Exception $e) {
            Utility::saveErrorLog($screen, $e->getMessage());
            abort(500);
        }
    }

    public function getDailyBestSellerItem(DailyReportRequest $request)
    {
        $screen = "Best Seller Daily Report ::";
        try {
            $start = isset($request['start_date_picker']) ? $request['start_date_picker'] : null;
            $end = isset($request['end_date_picker']) ? $request['end_date_picker'] : null;
            $sale_datas = $this->reportRepository->dailyBestSaleItemReport($start, $end);
            return view('backend.report.daily_item_report', compact('sale_datas', 'start', 'end'));
        } catch (Exception $e) {
            $queryLog = DB::getQueryLog();
            Utility::saveErrorLog($screen, $e->getMessage());
            return back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function dailyItemReportDownload(DailyReportRequest $request, ItemDailyReport $dailyItemReport)
    {
        $screen = "Daily Item Report Download!!";
        try {
            $start = isset($request['start_date']) ? $request['start_date'] : null;
            $end = isset($request['end_date']) ? $request['end_date'] : null;
            $today_date = date('YmdHis');
            return Excel::download($dailyItemReport->setDateRange($start, $end), $today_date . '-dailyItemReport.xlsx');
        } catch (Exception $e) {
            $screen = 'Daily Item Report Download:: ';
            $queryLog = DB::getQueryLog();

            Utility::saveErrorLog($screen, $e->getMessage());
            return back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function getMonthlyItemReportGraph()
    {
        $screen = "Get Monthly Item Report Graph !!";
        try {
            $result = $this->reportRepository->monthlyBestSaleItemReportGraph(null, null);
            $queryLog = DB::getQueryLog();
            Utility::saveDebugLog($screen, $queryLog);
            return $result;
        } catch (\Exception $e) {
            Utility::saveErrorLog($screen, $e->getMessage());
            abort(500);
        }
    }

    public function getMonthlyBestSellerItem(MonthlyReportRequest $request)
    {
        $screen = "Best Seller Item Monthly Report ::";
        try {
            $start_month = isset($request['start_month']) ? $request['start_month'] : null;
            $end_month = isset($request['end_month']) ? $request['end_month'] : null;
            $sale_datas = $this->reportRepository->monthlyBestSaleItemReport($start_month, $end_month);
            return view('backend.report.monthly_item_report', compact('sale_datas', 'start_month', 'end_month'));
        } catch (Exception $e) {
            $queryLog = DB::getQueryLog();
            Utility::saveErrorLog($screen, $e->getMessage());
            return back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function monthlyItemReportDownload(MonthlyReportRequest $request, ItemMonthlyReport $monthlyItemReport)
    {
        $screen = "Monthly Report Download ::";
        try {
            $start = isset($request['start']) ? $request['start'] : null;
            $end = isset($request['end']) ? $request['end'] : null;
            $today_date = date('Ymd\His');
            return Excel::download($monthlyItemReport->setDateRange($start, $end), $today_date . '-monthlyItemReport.xlsx');
        } catch (Exception $e) {
            $queryLog = DB::getQueryLog();
            Utility::saveErrorLog($screen, $e->getMessage());
            return back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
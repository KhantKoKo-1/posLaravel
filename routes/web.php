<?php

use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Discount\DiscountController;
use App\Http\Controllers\Dashboard\AdminDashboardController;
use App\Http\Controllers\Item\ItemController;
use App\Http\Controllers\Login\LoginController;
use App\Http\Controllers\Shift\ShiftController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Setting\SettingController;
use App\Http\Controllers\Order\OrderFrontendController;
use App\Http\Controllers\Order\PaymentFrontendController;
use App\Http\Controllers\Report\ReportController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/backendLogout', [LoginController::class, 'backendLogout']);
Route::get('/unauthorize', [LoginController::class, 'unauthorizePage']);
Route::get('/sg-backend/login', [LoginController::class, 'loginForm']);
Route::post('/sg-backend/storeLogin', [LoginController::class, 'storeBackendLogin'])->name('storeLogin');

Route::get('/login', [LoginController::class, 'frontendLoginForm']);
Route::post('/storeFrontendLogin', [LoginController::class, 'storeFrontendLoginForm'])->name('storeFrontendLoginForm');
Route::get('/shift-close', [LoginController::class, 'shiftClosePage']);

Route::group(['prefix' => '/','middleware' => 'cashier' ], function () {
    Route::get('/home', function () {
        return view('frontend.home.index');
    });

    Route::group(['prefix' => 'api'], function () {
        Route::post('/get-category', [OrderFrontendController::class, 'getCategory']);
        Route::post('/get-all-items', [OrderFrontendController::class, 'getAllItems']);
        Route::post('/get-items', [OrderFrontendController::class, 'getItems']);
        Route::post('/order-item', [OrderFrontendController::class, 'orderItem']);
        Route::post('/make-order', [OrderFrontendController::class, 'makeOrder']);
        Route::post('/get-orders', [OrderFrontendController::class, 'getOrders']);
        Route::post('/change-order-status', [OrderFrontendController::class, 'changeStatus']);
        Route::post('/fetch_order_items', [OrderFrontendController::class, 'fetchOrderItems']);
        Route::post('/order-edit', [OrderFrontendController::class, 'editOrder']);
        Route::post('/fetch-order-detail', [OrderFrontendController::class, 'fetchOrderDetail']);
        Route::post('/payment/get-order-detail', [PaymentFrontendController::class, 'getOrderDetailFromPayment']);
        Route::post('/payment/store-payment', [PaymentFrontendController::class, 'storePayment']);
    });

    Route::group(['prefix' => 'payment'], function () {
        Route::get('/{id}', [PaymentFrontendController::class, 'getPayment']);
    });

    Route::get('/order', [OrderFrontendController::class, 'getOrder']);
    Route::get('/order-list', [OrderFrontendController::class, 'getList']);
    Route::get('/order_edit/{id}', [OrderFrontendController::class, 'getEditOrder']);
    Route::get('/order-detail/{id}', [OrderFrontendController::class, 'getOrderDetail']);
});

Route::group(['prefix' => 'sg-backend','middleware' => 'admin' ], function () {
    Route::get('/index', [AdminDashboardController::class, 'home'])->name('backendDashbaord');

    Route::group(['prefix' => 'graph'], function () {
        Route::get('/daily-report', [ReportController::class, 'getDailyReportGraph']);
        Route::get('/monthly-report', [ReportController::class, 'getMonthlyReportGraph']);
        Route::get('/daily-item-report', [ReportController::class, 'getDailyItemReportGraph']);
        Route::get('/monthly-item-report', [ReportController::class, 'getMonthlyItemReportGraph']);
    });

    Route::get('/daily-report', [ReportController::class, 'getDailyReport']);
    Route::post('/daily-report/download', [ReportController::class, 'dailyReportDownload'])->name('dailyReportDownload');
    Route::get('/monthly-report', [ReportController::class, 'getMonthlyReport']);
    Route::post('/monthly-report/download', [ReportController::class, 'monthlyReportDownload'])->name('monthlyReportDownload');
    Route::post('/payment-history', [ReportController::class, 'getPaymentHistory'])->name('getPaymentHistory');
    Route::post('/payment-history-download', [ReportController::class, 'paymentHistoryDownload'])->name('paymentHistoryDownload');
    Route::post('/daily-item-report/download', [ReportController::class, 'dailyItemReportDownload'])->name('dailyItemReportDownload');
    Route::post('/monthly-item-report/download', [ReportController::class, 'monthlyItemReportDownload'])->name('monthlyItemReportDownload');

    Route::group(['prefix' => 'best-seller'], function () {
        Route::get('/daily-report', [ReportController::class, 'getDailyBestSellerItem']);
        Route::get('/monthly-report', [ReportController::class, 'getMonthlyBestSellerItem']);
    });

    Route::group(['prefix' => 'shift'], function () {
        Route::get('/', [ShiftController::class, 'getShift']);
        Route::post('/start', [ShiftController::class, 'startShift']);
        Route::post('/end', [ShiftController::class, 'endShift']);
        Route::get('/order-list/{id}', [ShiftController::class, 'getOrdersFromShift']);
        Route::post('/download', [ShiftController::class, 'downloadOrders'])->name('downloadOrders');
    });

    Route::group(['prefix' => 'category'], function () {
        Route::get('/', [CategoryController::class, 'getForm']);
        Route::post('/create', [CategoryController::class, 'store'])->name('storeForm');
        Route::get('/list', [CategoryController::class, 'getList']);
        Route::get('/edit/{id}', [CategoryController::class, 'getEdit']);
        Route::post('/updateForm', [CategoryController::class, 'updateForm'])->name('updateForm');
        Route::post('/delete', [CategoryController::class, 'categoryDelete']);
    });

    Route::group(['prefix' => 'item'], function () {
        Route::get('/', [ItemController::class, 'getForm']);
        Route::post('/create', [ItemController::class, 'store'])->name('storeItemForm');
        Route::get('/list', [ItemController::class, 'getList']);
        Route::get('/edit/{id}', [ItemController::class, 'getEdit']);
        Route::post('/updateForm', [ItemController::class, 'updateForm'])->name('updateItemForm');
        Route::post('/delete', [ItemController::class, 'itemDelete']);
    });

    Route::group(['prefix' => 'discount'], function () {
        Route::get('/', [DiscountController::class, 'getForm']);
        Route::post('/create', [DiscountController::class, 'store'])->name('storeDiscountForm');
        Route::get('/list', [DiscountController::class, 'getList']);
        Route::get('/edit/{id}', [DiscountController::class, 'getEdit']);
        Route::post('/updateForm', [DiscountController::class, 'updateForm'])->name('updateDiscountForm');
        Route::post('/delete', [DiscountController::class, 'discountDelete']);
    });

    Route::group(['prefix' => 'account'], function () {
        Route::get('/store/{type}', [UserController::class, 'getForm']);
        Route::post('/create', [UserController::class, 'store'])->name('storeAccountForm');
        Route::get('/list/{type}', [UserController::class, 'getList']);
        Route::get('/edit/{type}/{editType}/{id}', [UserController::class, 'getEdit']);
        Route::post('/updateForm', [UserController::class, 'updateForm'])->name('updateAccountForm');
        Route::post('/delete', [UserController::class, 'accountDelete']);
    });

    Route::group(['prefix' => 'setting'], function () {
        Route::get('/', [SettingController::class, 'getForm']);
        Route::post('/create', [SettingController::class, 'store'])->name('storeSettingForm');
        Route::get('/list', [SettingController::class, 'getList']);
        Route::get('/edit/{id}', [SettingController::class, 'getEdit']);
        Route::post('/updateForm', [SettingController::class, 'updateForm'])->name('updateSettingForm');
        Route::post('/delete', [SettingController::class, 'settingDelete']);
    });
});
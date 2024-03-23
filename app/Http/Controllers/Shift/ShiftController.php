<?php

namespace App\Http\Controllers\Shift;

use App\Utility;
use Illuminate\Http\Request;
use App\Exports\DownloadOrders;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\ShiftCheckRequest;
use App\Http\Requests\ShiftStartRequest;
use App\Http\Requests\OrderListByShiftRequest;
use App\Repositories\Shift\ShiftRepositoryInterface;

class ShiftController extends Controller
{
    private $shiftRepository;

    public function __construct(ShiftRepositoryInterface $shiftRepository)
    {
        DB::connection()->enableQueryLog();
        $this->shiftRepository = $shiftRepository;
    }

    public function getShift()
    {
        $screen = "Show Shift List !!";
        try {
            $shifts = $this->shiftRepository->selectAllShift();
            $shiftOpened = $this->shiftRepository->shiftValidation();
            $queryLog = DB::getQueryLog();
            Utility::saveDebugLog($screen, $queryLog);
            return view('backend.shift.index', compact(['shifts','shiftOpened']));
        } catch (\Exception $e) {
            Utility::saveErrorLog($screen, $e -> getMessage());
            abort(500);
        }
    }

    public function startShift(Request $request)
    {

        $screen = "Start Shift Method !!";
        try {
            $response = $this->shiftRepository->startShift((array) $request->all());
            if ($response == '200') {
                $queryLog = DB::getQueryLog();
                Utility::saveDebugLog($screen, $queryLog);
                return redirect('sg-backend/shift')->with(['successMessage' => 'Shift is opened!'])->withInput();
            } else {
                return redirect('sg-backend/shift')->with(['errorMessages' => 'There was an unsuccessful attempt to open a shift.!'])->withInput();
            }
        } catch (\Exception $e) {
            Utility::saveErrorLog($screen, $e -> getMessage());
            abort(500);
        }
    }

    public function endShift(ShiftCheckRequest $request)
    {
        $screen = "End Shift Method !!";
        try {
            $response = $this->shiftRepository->endShift();
            if ($response == '200') {
                $queryLog = DB::getQueryLog();
                Utility::saveDebugLog($screen, $queryLog);
                return redirect('sg-backend/shift')->with(['successMessage' => 'Shift is closed.'])->withInput();
            } else {
                return redirect('sg-backend/shift')->with(['errorMessages' => 'There was an unsuccessful attempt to close a shift.'])->withInput();
            }
        } catch (\Exception $e) {
            Utility::saveErrorLog($screen, $e -> getMessage());
            abort(500);
        }
    }

    public function getOrdersFromShift($id)
    {
        $screen = "Show Shift Order List From Shift !!";
        try {
            $orders = $this->shiftRepository->selectOrdersByShiftId((int) $id,(bool) false);
            $queryLog = DB::getQueryLog();
            Utility::saveDebugLog($screen, $queryLog);
            return view('backend.shift.order-list',compact(['orders','id']));
        } catch (\Exception $e) {
            Utility::saveErrorLog($screen, $e -> getMessage());
            abort(500);
        }
    }

    public function downloadOrders(OrderListByShiftRequest $request,DownloadOrders $downloadOrder)
    {
        $screen = "Download Orders !!";
        try {
            $shif_id = $request->shift_id;
            return Excel::download( $downloadOrder->setShiftId( $shif_id ), $shif_id.'-orders.xlsx' );
        } catch( Exception $e ) {
            $queryLog = DB::getQueryLog();
            Utility::saveErrorLog( $screen, $e->getMessage() );
            return back()->with( 'error', 'An error occurred: ' . $e->getMessage() );
        }
    }
}

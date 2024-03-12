<?php

namespace App\Http\Middleware;


use App\CONSTANT;
use App\Utility;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CashierPermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $screen = "Cashier Permission Middleware";
        try {
            $cashierUser = Auth::guard('cashier')->user();
            if ($cashierUser !== null && $cashierUser->username !== null) {
                $role = $cashierUser->role;
                if ($role == CONSTANT::CASHIER_ROLE) {
                    $shiftId = Utility::shiftValidation();
                    if (!isset($shiftId)) {
                        return redirect('/shift-close');
                    }else {
                        session(['shift_id' => $shiftId->id]);
                        return $next($request);
                    }
                } else {
                    return redirect('/unauthorize');
                }
            } else {
                return redirect('/login');
            }
        } catch (\Exception $e) {
            Utility::saveErrorLog($screen, $e -> getMessage());
            abort(500);
        }
    }
}
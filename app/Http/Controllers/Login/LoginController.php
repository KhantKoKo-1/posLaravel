<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginRequest;
use App\Http\Requests\CashierLoginRequest;
use App\Utility;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function __construct()
    {
        DB::connection()->enableQueryLog();
    }
    public function loginForm()
    {
        $screen = "Show Login Form";
        try {
            Utility::saveInfoLog($screen);
            return view('auth.backend_login');
        } catch (\Exception $e) {
            Utility::saveErrorLog($screen, $e -> getMessage());
            abort(500);
        }
    }

    public function storeBackendLogin(AdminLoginRequest $request)
    {
        $screen = "Login Post Method";
        try {
            $credentials = Auth::guard('admin')->attempt(
                            [
                            'username' => $request -> username,
                            'password' => $request -> password,
                            ]);
            if ($credentials) {
                $queryLog = DB::getQueryLog();
                Utility::saveDebugLog($screen, $queryLog);
                return redirect('/sg-backend/index');
            } else {
                return redirect()->back()->withErrors(['loginError' => 'Credential does not match.'])->withInput();
            }
        } catch (\Exception $e) {
            Utility::saveErrorLog($screen, $e -> getMessage());
            abort(500);
        }
    }

    public function unauthorizePage()
    {
        $screen = "Show Unauthorize Page";
        try {
            Utility::saveInfoLog($screen);
            return view('auth.unauthorize');
        } catch (\Exception $e) {
            Utility::saveErrorLog($screen, $e -> getMessage());
            abort(500);
        }
    }
    public function shiftClosePage()
    {
        $screen = "Show Shift Close Page";
        try {
            Utility::saveInfoLog($screen);
            return view('frontend.shift_close');
        } catch (\Exception $e) {
            Utility::saveErrorLog($screen, $e -> getMessage());
            abort(500);
        }
    }

    public function backendLogout()
    {
        $screen = "Work Backend Logout !!";
        try {
            Auth::guard('admin')->logout();
            Utility::saveInfoLog($screen);
            return redirect('/sg-backend/login');
        } catch (\Exception $e) {
            Utility::saveErrorLog($screen, $e -> getMessage());
            abort(500);
        }
    }

    public function logout()
    {
        $screen = "Work Logout !!";
        try {
            Auth::guard('cashier')->logout();
            Utility::saveInfoLog($screen);
            return redirect('/login');
        } catch (\Exception $e) {
            Utility::saveErrorLog($screen, $e -> getMessage());
            abort(500);
        }
    }

    public function frontendLoginForm()
    {
        $screen = "Show frontend Login Form";
        try {
            Utility::saveInfoLog($screen);
            return view('auth.frontend_login');
        } catch (\Exception $e) {
            Utility::saveErrorLog($screen, $e -> getMessage());
            abort(500);
        }
    }

    public function storeFrontendLoginForm(CashierLoginRequest $request)
    {
        $screen = "Frontend Login Post Method";
        try {
            $credentials = Auth::guard('cashier')->attempt(
                         [
                            'username' => $request -> username,
                            'password' => $request -> password,
                            ]
            );

            if ($credentials) {
                $queryLog = DB::getQueryLog();
                Utility::saveDebugLog($screen, $queryLog);
                return redirect('/home');
            } else {
                return redirect()->back()->withErrors(['loginError' => 'Username or password is wrong'])->withInput();
            }
        } catch (\Exception $e) {
            Utility::saveErrorLog($screen, $e -> getMessage());
            abort(500);
        }
    }
}

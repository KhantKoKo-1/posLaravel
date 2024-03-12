<?php

namespace App\Http\Middleware;

use Closure;
use App\Utility;
use App\CONSTANT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminPermissionMiddleware
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
        $screen = "Login Post Method";
        try {
            $adminUser = Auth::guard('admin')->user();
            if ($adminUser !== null && $adminUser->username !== null) {
                $role = $adminUser->role;
                if ($role == CONSTANT::ADMIN_ROLE) {
                    return $next($request);
                } else {
                    return redirect('/unauthorize');
                }
            } else {
                return redirect('/sg-backend/login');
            }
        } catch (\Exception $e) {
            Utility::saveErrorLog($screen, $e -> getMessage());
            abort(500);
        }
    }
}
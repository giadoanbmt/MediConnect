<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureRoleAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $isDoctor = $request->session()->get('auth_type') === 'doctor';
        $isAuthUser = Auth::check();

        // 1. Nếu chưa đăng nhập ở bất kỳ vai trò nào -> Chuyển hướng về trang login
        if (!$isDoctor && !$isAuthUser) {
            return redirect()->route('login')->withErrors([
                'username' => 'Please log in to perform this action.'
            ]);
        }

        // 2. Nếu route yêu cầu 'doctor' và người dùng là Doctor
        if (in_array('doctor', $roles) && $isDoctor) {
            $response = $next($request);
            $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
            $response->headers->set('Pragma', 'no-cache');
            $response->headers->set('Expires', '0');
            return $response;
        }

        // 3. Nếu route yêu cầu 'admin' hoặc 'patient'
        if ($isAuthUser) {
            $userRole = (int) Auth::user()->Role;

            $isAdminAllowed = in_array('admin', $roles) && $userRole === 1;
            $isPatientAllowed = in_array('patient', $roles) && $userRole === 2;

            if ($isAdminAllowed || $isPatientAllowed) {
                $response = $next($request);
                $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
                $response->headers->set('Pragma', 'no-cache');
                $response->headers->set('Expires', '0');
                return $response;
            }
        }

        // 4. Trường hợp đã đăng nhập (Doctor, Admin hoặc Patient) nhưng vào sai khu vực -> Báo lỗi 403
        abort(403, 'You do not have permission to access this page.');
    }
}

<?php

// namespace App\Http\Middleware;

// use Closure;
// use App\Models\User\AccountUser;
// use Illuminate\Http\RedirectResponse;
// use Illuminate\Http\Request;
// use Illuminate\Http\Response;
// use Illuminate\Support\Facades\Auth;
// use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

// class EnsureRoleAccess
// {
//     /**
//      * @param  string  $roles  Comma-separated list of allowed roles.
//      */
//     public function handle(Request $request, Closure $next, string $roles): SymfonyResponse|RedirectResponse|Response
//     {
//         $allowedRoles = array_values(array_filter(array_map('trim', explode(',', $roles))));

//         if ($request->session()->get('auth_type') === 'doctor' && in_array('doctor', $allowedRoles, true)) {
//             return $next($request);
//         }

//         if (! Auth::check()) {
//             return redirect()->route('login');
//         }

//         $user = Auth::user();

//         if (! $user) {
//             return redirect()->route('login');
//         }

//         $currentRole = (int) $user->Role;

//         foreach ($allowedRoles as $role) {
//             if ($role === 'admin' && $currentRole === 1) {
//                 return $next($request);
//             }

//             if ($role === 'patient' && $currentRole === 2) {
//                 return $next($request);
//             }
//         }

//         return redirect()->route('login');
//     }
// }
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureRoleAccess
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Kiểm tra truy cập cho DOCTOR (Session auth_type === 'doctor')
        if (in_array('doctor', $roles)) {
            if ($request->session()->get('auth_type') === 'doctor') {
                return $next($request);
            }
        }

        // 2. Kiểm tra truy cập cho ADMIN hoặc PATIENT (Dựa trên Auth::user())
        if (Auth::check()) {
            $userRole = (int) Auth::user()->Role;

            // Chỉ Admin mới được vào route có 'admin' (Role = 1)
            if (in_array('admin', $roles) && $userRole === 1) {
                return $next($request);
            }

            // Chỉ Patient mới được vào route có 'patient' (Role = 2)
            if (in_array('patient', $roles) && $userRole === 2) {
                return $next($request);
            }
        }

        // 3. Xử lý truy cập trái quyền hoặc chưa đăng nhập
        if (!Auth::check() && $request->session()->get('auth_type') !== 'doctor') {
            return redirect()->route('login')->withErrors([
                'username' => 'Vui lòng đăng nhập để thực hiện thao tác này.'
            ]);
        }

        // Đã đăng nhập nhưng cố tình vào khu vực của Role khác
        abort(403, 'Bạn không có quyền truy cập vào khu vực này.');
    }
}

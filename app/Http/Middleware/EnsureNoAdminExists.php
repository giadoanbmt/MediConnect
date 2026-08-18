<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EnsureNoAdminExists
{
    public function handle(Request $request, Closure $next)
    {
        // Kiểm tra xem đã có tài khoản Role = 1 (Admin) trong DB hay chưa
        $adminExists = DB::table('AccountUser')->where('Role', 1)->exists();

        if ($adminExists) {
            return redirect()->route('login')->with('error', 'The system already has an administrator account!');
        }

        return $next($request);
    }
}

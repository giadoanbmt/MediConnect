<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User\AccountUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class EnsureRoleAccess
{
    /**
     * @param  string  $roles  Comma-separated list of allowed roles.
     */
    public function handle(Request $request, Closure $next, string $roles): SymfonyResponse|RedirectResponse|Response
    {
        $allowedRoles = array_values(array_filter(array_map('trim', explode(',', $roles))));

        if ($request->session()->get('auth_type') === 'doctor' && in_array('doctor', $allowedRoles, true)) {
            return $next($request);
        }

        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login');
        }

        $currentRole = (int) $user->Role;

        foreach ($allowedRoles as $role) {
            if ($role === 'admin' && $currentRole === 1) {
                return $next($request);
            }

            if ($role === 'patient' && $currentRole === 2) {
                return $next($request);
            }
        }

        return redirect()->route('login');
    }
}

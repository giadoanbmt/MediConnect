<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    // Đăng ký tài khoản Bệnh nhân
    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:100', Rule::unique('AccountUser', 'Username')],
            'email' => ['required', 'string', 'email', 'max:100', Rule::unique('AccountUser', 'Email')],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $user = User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => 2,
            'is_active' => true,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('public.home');
    }

    // Đăng nhập an toàn
    public function login(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string'],
        ]);

        $loginValue = trim($validated['username']);
        $loginField = filter_var($loginValue, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $user = User::where($loginField, $loginValue)->first();

        if (! $user) {
            return back()
                ->withInput($request->only('username', 'remember'))
                ->withErrors(['username' => 'Account not found']);
        }

        if ((int) $user->role !== 2) {
            return back()
                ->withInput($request->only('username', 'remember'))
                ->withErrors(['username' => 'Only patient accounts can log in here.']);
        }

        if (! $user->is_active) {
            return back()
                ->withInput($request->only('username', 'remember'))
                ->withErrors(['username' => 'This account is inactive.']);
        }

        if (! Hash::check($validated['password'], $user->password)) {
            return back()
                ->withInput($request->only('username', 'remember'))
                ->withErrors(['password' => 'Incorrect password']);
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('public.home');
    }

    // Đăng xuất
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('public.home')->with('status', 'Đã đăng xuất thành công.');
    }
}

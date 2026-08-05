<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    // Đăng ký tài khoản Bệnh nhân
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:4',
        ]);

        $user = User::create([
            'name'     => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect('/');
    }

    // Đăng nhập an toàn
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $loginField = filter_var($request->input('username'), FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
        $loginValue = $request->input('username');

        // Kiểm tra xem tài khoản có tồn tại trong CSDL không
        $userExists = User::where($loginField, $loginValue)->exists();
        if (!$userExists) {
            return back()->withErrors(['username' => 'Account not found']);
        }

        $credentials = [
            $loginField => $loginValue,
            'password'  => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('/');
        }

        return back()->withErrors(['password' => 'Incorrect password']);
    }

    // Đăng xuất
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Đã đăng xuất!']);
    }
}
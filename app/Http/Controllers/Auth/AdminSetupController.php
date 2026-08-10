<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSetupController extends Controller
{
    // Hiển thị form đăng ký Admin
    public function showRegisterForm()
    {
        return view('auth.admin-register');
    }

    // Xử lý lưu Admin
    public function register(Request $request)
    {
        // Double-check để tránh race condition
        if (DB::table('AccountUser')->where('Role', 1)->exists()) {
            return redirect()->route('login')->with('error', 'Hệ thống đã có tài khoản Admin!');
        }

        $request->validate([
            'username' => 'required|string|max:100|unique:AccountUser,Username',
            'email'    => 'required|email|max:100|unique:AccountUser,Email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Tạo tài khoản Admin (Role = 1)
        DB::table('AccountUser')->insert([
            'Username'  => $request->username,
            'Email'     => $request->email,
            'Password'  => Hash::make($request->password),
            'Role'      => 1, // 1: Admin
            'IsActive'  => 1,
            'CreatedAt' => now(),
        ]);

        return redirect()->route('login')->with('success', 'Khởi tạo tài khoản Admin thành công! Vui lòng đăng nhập.');
    }
}

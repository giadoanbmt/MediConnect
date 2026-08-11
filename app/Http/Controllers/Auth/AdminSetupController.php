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
            return redirect()->route('login')->with('error', 'The system already has an Admin account!');
        }

        // Validation dữ liệu đầu vào
        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:100|unique:AccountUser,Username',
            'email'    => 'required|email|max:100|unique:AccountUser,Email',
            'gender'   => 'nullable|string|in:Male,Female',
            'address'  => 'nullable|string|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Tạo tài khoản Admin (Role = 1)
        DB::table('AccountUser')->insert([
            'FullName'  => $request->name,
            'Username'  => $request->username,
            'Email'     => $request->email,
            'Password'  => Hash::make($request->password),
            'Gender'    => $request->gender,
            'Address'   => $request->address,
            'Role'      => 1, // 1: Admin
            'IsActive'  => 1,
            'CreatedAt' => now(),
            'UpdatedAt' => now(),
        ]);

        return redirect()->route('login')->with('success', 'Admin account created successfully! Please log in.');
    }
}

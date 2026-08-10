<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    // Hiển thị form chỉnh sửa hồ sơ
    public function edit()
    {
        return view('admin.profile.edit');
    }

    // Cập nhật thông tin tài khoản Admin
    public function update(Request $request)
    {
        // Lấy UserId của tài khoản đang đăng nhập
        $userId = Auth::id();

        if (!$userId) {
            return redirect()->route('login')->with('error', 'Session has expired.');
        }

        $request->validate([
            'username' => 'required|string|max:100|unique:AccountUser,Username,' . $userId . ',UserId',
            'email'    => 'required|email|max:100|unique:AccountUser,Email,' . $userId . ',UserId',
            'password' => 'nullable|string|min:6',
        ]);

        $updateData = [
            'Username' => $request->input('username'),
            'Email'    => $request->input('email'),
        ];

        // Cập nhật mật khẩu nếu có nhập
        if ($request->filled('password')) {
            $updateData['Password'] = Hash::make($request->input('password'));
        }

        DB::table('AccountUser')
            ->where('UserId', $userId)
            ->update($updateData);

        return redirect()->back()->with('success', 'Profile information updated successfully.!');
    }
}

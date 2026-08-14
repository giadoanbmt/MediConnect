<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Hiển thị form chỉnh sửa hồ sơ
     */
    public function edit()
    {
        $user = Auth::user();
        return view('admin.profile.edit', compact('user'));
    }

    /**
     * Cập nhật thông tin tài khoản Admin
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Phiên đăng nhập đã hết hạn.');
        }

        // Lấy ID để loại trừ trong kiểm tra unique email/username
        $userId = $user->UserId ?? $user->id;

        // 1. Validate thông tin gửi lên
        $request->validate([
            'name'     => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:AccountUser,Username,' . $userId . ',UserId',
            'email'    => 'required|email|max:100|unique:AccountUser,Email,' . $userId . ',UserId',
            'gender'   => 'nullable|string|max:10',
            'address'  => 'nullable|string|max:255',
            'password' => 'nullable|string|min:6',
            'avatar'   => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // 2. Xử lý Upload Ảnh Avatar nếu có chọn file
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $fileName = time() . '_' . $file->getClientOriginalName();

            // Di chuyển file vào public/uploads/avatars/
            $file->move(public_path('uploads/avatars'), $fileName);

            // Xóa ảnh cũ nếu tồn tại
            if ($user->AvatarUrl && file_exists(public_path($user->AvatarUrl))) {
                @unlink(public_path($user->AvatarUrl));
            }

            // Gán đường dẫn ảnh mới
            $user->AvatarUrl = '/uploads/avatars/' . $fileName;
        }

        // 3. Cập nhật các trường thông tin khác
        $user->FullName = $request->input('name');
        $user->Username = $request->input('username');
        $user->Email    = $request->input('email');
        $user->Gender   = $request->input('gender');
        $user->Address  = $request->input('address');

        // Cập nhật mật khẩu nếu có nhập
        if ($request->filled('password')) {
            $user->Password = Hash::make($request->input('password'));
        }

        // 4. Lưu lại vào Database
        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
}

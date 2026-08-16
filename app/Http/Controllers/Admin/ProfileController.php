<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File; // Import File Facade
use Illuminate\Support\Str;          // Import Str Helper

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('admin.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        /** @var \App\Models\AccountUser $user */ // Gợi ý cho IDE nhận diện Eloquent Model
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'The login session has expired..');
        }

        $userId = $user->UserId ?? $user->id;

        // 1. Validate
        $request->validate([
            'name'     => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:AccountUser,Username,' . $userId . ',UserId',
            'email'    => 'required|email|max:100|unique:AccountUser,Email,' . $userId . ',UserId',
            'gender'   => 'nullable|string|max:10',
            'address'  => 'nullable|string|max:255',
            'password' => 'nullable|string|min:6',
            'avatar'   => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // 2. Xử lý Upload Ảnh Avatar (Tên file: timestamp_avatar_userId.ext)
        if ($request->boolean('remove_avatar')) {
            // Trường hợp 1: Người dùng chọn XÓA ảnh
            if ($user->AvatarUrl && File::exists(public_path($user->AvatarUrl))) {
                File::delete(public_path($user->AvatarUrl));
            }
            $user->AvatarUrl = null; // Đặt về NULL để View tự lấy ảnh mặc định

        } elseif ($request->hasFile('avatar')) {
            // Trường hợp 2: Người dùng UPLOAD ảnh mới
            $file = $request->file('avatar');
            $fileName = time() . '_avatar_' . $userId . '.' . $file->getClientOriginalExtension();

            $destinationPath = public_path('uploads/avatars');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            // Xóa ảnh cũ trước khi lưu ảnh mới
            if ($user->AvatarUrl && File::exists(public_path($user->AvatarUrl))) {
                File::delete(public_path($user->AvatarUrl));
            }

            $file->move($destinationPath, $fileName);
            $user->AvatarUrl = '/uploads/avatars/' . $fileName;
        }

        // 3. Cập nhật thông tin khác
        $user->FullName = $request->input('name');
        $user->Username = $request->input('username');
        $user->Email    = $request->input('email');
        $user->Gender   = $request->input('gender');
        $user->Address  = $request->input('address');

        if ($request->filled('password')) {
            $user->Password = Hash::make($request->input('password'));
        }

        // 4. Lưu lại
        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
}

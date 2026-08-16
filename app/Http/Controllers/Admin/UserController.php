<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccountUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Hiển thị danh sách Bệnh nhân (Role = 2)
     */
    public function index()
    {
        $users = AccountUser::where('Role', 2)
            ->orderBy('CreatedAt', 'asc')
            ->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Form tạo tài khoản Bệnh nhân mới
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Lưu thông tin Bệnh nhân mới (Cố định Role = 2)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'max:50', Rule::unique('AccountUser', 'Username')],
            'email'    => ['required', 'string', 'email', 'max:100', Rule::unique('AccountUser', 'Email')],
            'password' => ['required', 'string', 'min:6'],
            'gender'   => ['nullable', 'string'],
            'address'  => ['nullable', 'string', 'max:255'],
        ]);

        AccountUser::create([
            'FullName' => $validated['name'],
            'Username' => $validated['username'],
            'Email'    => $validated['email'],
            'Password' => Hash::make($validated['password']),
            'Gender'   => $validated['gender'] ?? null,
            'Address'  => $validated['address'] ?? null,
            'Role'     => 2, // Cố định tạo tài khoản Patient
            'IsActive' => 0,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Patient account created successfully.');
    }

    /**
     * Form chỉnh sửa tài khoản Bệnh nhân
     */
    public function edit($id)
    {
        // Chỉ cho phép tìm kiếm tài khoản có Role = 2
        $user = AccountUser::where('Role', 2)->findOrFail($id);

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Cập nhật thông tin Bệnh nhân
     */
    public function update(Request $request, $id)
    {
        $user = AccountUser::where('Role', 2)->findOrFail($id);

        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'max:50', Rule::unique('AccountUser', 'Username')->ignore($user->UserId, 'UserId')],
            'email'    => ['required', 'string', 'email', 'max:100', Rule::unique('AccountUser', 'Email')->ignore($user->UserId, 'UserId')],
            'password' => ['nullable', 'string', 'min:6'],
            'gender'   => ['nullable', 'string'],
            'address'  => ['nullable', 'string', 'max:255'],
        ]);

        $updateData = [
            'FullName' => $validated['name'],
            'Username' => $validated['username'],
            'Email'    => $validated['email'],
            'Gender'   => $validated['gender'] ?? null,
            'Address'  => $validated['address'] ?? null,
            'Role'     => 2, // Đảm bảo giữ vững Role = 2
        ];

        if (!empty($validated['password'])) {
            $updateData['Password'] = Hash::make($validated['password']);
        }

        $user->update($updateData);

        return redirect()->route('admin.users.index')
            ->with('success', 'Patient account updated successfully.');
    }

    /**
     * Xóa tài khoản Bệnh nhân
     */
    public function destroy($id)
    {
        $user = AccountUser::where('Role', 2)->findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Patient account deleted successfully.');
    }
}

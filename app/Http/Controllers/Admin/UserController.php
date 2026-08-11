<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // 1. Danh sách Users (Admin & Patient)
    public function index()
    {
        $users = DB::table('AccountUser')
            ->whereIn('Role', [1, 2]) // Lấy cả Admin (1) và Patient (2)
            ->whereNull('DeletedAt')
            ->orderBy('CreatedAt', 'asc')
            ->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    // 2. Form tạo tài khoản
    public function create()
    {
        return view('admin.users.create');
    }

    // 3. Xử lý lưu tài khoản mới
    public function store(Request $request)
    {
        $request->validate([
            'role'     => 'required|in:Admin,Patient',
            'name'     => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:AccountUser,Username',
            'email'    => 'required|email|max:100|unique:AccountUser,Email',
            'password' => 'required|string|min:6',
            'gender'   => 'nullable|string|max:10',
            'address'  => 'nullable|string|max:255',
        ]);

        $roleValue = ($request->input('role') === 'Admin') ? 1 : 2;

        DB::table('AccountUser')->insert([
            'FullName'  => $request->input('name'),
            'Username'  => $request->input('username'),
            'Email'     => $request->input('email'),
            'Password'  => Hash::make($request->input('password')),
            'Gender'    => $request->input('gender'),
            'Address'   => $request->input('address'),
            'Role'      => $roleValue,
            'IsActive'  => 1,
            'CreatedAt' => now(),
            'UpdatedAt' => now(),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Create account successfully!');
    }

    // 4. Form sửa tài khoản
    public function edit($id)
    {
        $user = DB::table('AccountUser')
            ->where('UserId', $id)
            ->whereNull('DeletedAt')
            ->first();

        if (!$user) {
            return redirect()->route('admin.users.index')->with('error', 'Account not found!');
        }

        return view('admin.users.edit', compact('user'));
    }

    // 5. Cập nhật tài khoản
    public function update(Request $request, $id)
    {
        $request->validate([
            'role'     => 'required|in:Admin,Patient',
            'name'     => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:AccountUser,Username,' . $id . ',UserId',
            'email'    => 'required|email|max:100|unique:AccountUser,Email,' . $id . ',UserId',
            'gender'   => 'nullable|string|max:10',
            'address'  => 'nullable|string|max:255',
        ]);

        $roleValue = ($request->input('role') === 'Admin') ? 1 : 2;

        $data = [
            'FullName'  => $request->input('name'),
            'Username'  => $request->input('username'),
            'Email'     => $request->input('email'),
            'Gender'    => $request->input('gender'),
            'Address'   => $request->input('address'),
            'Role'      => $roleValue,
            'UpdatedAt' => now(),
        ];

        if ($request->filled('password')) {
            $data['Password'] = Hash::make($request->input('password'));
        }

        DB::table('AccountUser')->where('UserId', $id)->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Update account successfully!');
    }

    // 6. Xóa mềm tài khoản
    public function destroy($id)
    {
        DB::table('AccountUser')->where('UserId', $id)->update(['DeletedAt' => now()]);

        return redirect()->route('admin.users.index')->with('success', 'Delete account successfully!');
    }
}

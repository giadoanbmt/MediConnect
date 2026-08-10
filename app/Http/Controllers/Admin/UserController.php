<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // 1. Hiển thị danh sách toàn bộ tài khoản
    public function index()
    {
        // 1. Lấy danh sách AccountUser (1: Admin, 2: User)
        $accountUsers = DB::table('AccountUser')
            ->select(
                'UserId',
                'Username',
                'Email',
                'Role',
                'Username as FullName',
                DB::raw("'account' as AccountType")
            );

        // 2. Lấy danh sách Doctor (Quy ước Role = 3 cho Bác sĩ)
        $doctors = DB::table('Doctor')
            ->select(
                'DoctorId as UserId',
                'DoctorAccount as Username',
                'Email',
                DB::raw("3 as Role"), // 3: Bác sĩ
                'DoctorName as FullName',
                DB::raw("'doctor' as AccountType")
            );

        // 3. UNION 2 bảng và phân trang 15 mục/trang
        $users = $accountUsers->union($doctors)->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    // 2. Hiển thị form tạo tài khoản
    public function create()
    {
        $cities = DB::table('City')->get();
        $specializations = DB::table('Specialization')->get();

        return view('admin.users.create', compact('cities', 'specializations'));
    }

    // 3. Xử lý lưu dữ liệu tạo mới
    // public function store(Request $request)
    // {
    //     $role = $request->input('role');

    //     if ($role === 'Doctor') {
    //         $request->validate([
    //             'name' => 'required|string|max:50',
    //             'username' => 'required|string|max:100',
    //             'email' => 'required|email|max:100',
    //             'password' => 'required|string|min:6',
    //             'phone_number' => 'required|string|max:20',
    //             'qualifications' => 'required|string|max:50',
    //             'city_id' => 'required|integer',
    //             'address' => 'required|string',
    //         ]);

    //         DB::table('Doctor')->insert([
    //             'DoctorName' => $request->input('name'),
    //             'DoctorAccount' => $request->input('username'),
    //             'Password' => Hash::make($request->input('password')),
    //             'Sex' => $request->input('sex'),
    //             'PhoneNumber' => $request->input('phone_number'),
    //             'Email' => $request->input('email'),
    //             'SpecializationId' => $request->input('specialization_id') ?: null,
    //             'Qualifications' => $request->input('qualifications'),
    //             'CityId' => $request->input('city_id'),
    //             'Address' => $request->input('address'),
    //         ]);
    //     } else {
    //         $request->validate([
    //             'username' => 'required|string|max:100',
    //             'email' => 'required|email|max:100',
    //             'password' => 'required|string|min:6',
    //         ]);

    //         // Phân biệt: Admin = 1, Bệnh nhân (Patient) = 0
    //         $roleId = ($role === 'Admin') ? 1 : 0;

    //         DB::table('AccountUser')->insert([
    //             'Username' => $request->input('username'),
    //             'Password' => Hash::make($request->input('password')),
    //             'Email' => $request->input('email'),
    //             'Role' => $roleId,
    //             'IsActive' => 1,
    //             'CreatedAt' => now(),
    //         ]);
    //     }

    //     return redirect()->route('admin.users.index')->with('success', 'Tạo tài khoản ' . $role . ' thành công!');
    // }

    public function store(Request $request)
    {
        // 1. Validate dữ liệu
        $request->validate([
            'role'     => 'required|in:Admin,Doctor,Patient',
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'email'    => 'required|email|max:255',
            'password' => 'required|string|min:6',
        ]);

        // 2. Xử lý lưu CSDL tùy theo Role...
        if ($request->role === 'Doctor') {
            DB::table('Doctor')->insert([
                'DoctorName'       => $request->name,
                'DoctorAccount'    => $request->username,
                'Email'            => $request->email,
                'Password'         => bcrypt($request->password),
                'PhoneNumber'      => $request->phone_number,
                'Sex'              => $request->sex,
                'Qualifications'   => $request->qualifications,
                'SpecializationId' => $request->specialization_id,
                'CityId'           => $request->city_id,
                'Address'          => $request->address,
            ]);
        } else {
            DB::table('AccountUser')->insert([
                'Username' => $request->username,
                'Email'    => $request->email,
                'Password' => bcrypt($request->password),
                'Role'     => $request->role === 'Admin' ? 1 : 0,
            ]);
        }

        return redirect()->route('admin.users.index')->with('success', 'Create successful!');
    }

    // 4. Xóa tài khoản (phân biệt xóa bên Doctor hay AccountUser)
    public function destroy(Request $request, $id)
    {
        $type = $request->query('type', 'account');

        if ($type === 'doctor') {
            DB::table('Doctor')->where('DoctorId', $id)->delete();
        } else {
            DB::table('AccountUser')->where('UserId', $id)->delete();
        }

        return redirect()->route('admin.users.index')->with('success', 'Delete successful!');
    }
    // 5. Hiển thị form chỉnh sửa & Reset Mật khẩu
    public function edit(Request $request, $id)
    {
        $type = $request->query('type', 'account');
        $cities = DB::table('City')->get();
        $specializations = DB::table('Specialization')->get();

        if ($type === 'doctor') {
            $user = DB::table('Doctor')->where('DoctorId', $id)->first();
        } else {
            $user = DB::table('AccountUser')->where('UserId', $id)->first();
        }

        if (!$user) {
            return redirect()->route('admin.users.index')->with('error', 'Account does not exist.!');
        }

        return view('admin.users.edit', compact('user', 'type', 'cities', 'specializations'));
    }

    // 6. Cập nhật thông tin & Reset Mật khẩu
    public function update(Request $request, $id)
    {
        // 1. Validate dữ liệu đầu vào
        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'email'    => 'required|email|max:255',
            'role'     => 'required',
        ]);

        // 2. Chuyển chuỗi Role nhận từ Form về dạng số (INT) cho Database
        $roleInt = match ($request->input('role')) {
            'Admin'   => 1,
            'Patient' => 2,
            default   => 2,
        };

        // 3. Lấy loại tài khoản hiện tại từ hidden field (đã truyền ở View)
        $accountType = $request->input('account_type', 'account');

        if ($accountType === 'doctor') {
            // Cập nhật cho bảng Doctor
            $data = [
                'DoctorName'       => $request->input('name'),
                'DoctorAccount'    => $request->input('username'),
                'Email'            => $request->input('email'),
                'PhoneNumber'      => $request->input('phone_number'),
                'Sex'              => $request->input('sex'),
                'Qualifications'   => $request->input('qualifications'),
                'SpecializationId' => $request->input('specialization_id'),
                'CityId'           => $request->input('city_id'),
                'Address'          => $request->input('address'),
            ];

            if ($request->filled('password')) {
                $data['Password'] = Hash::make($request->input('password'));
            }

            DB::table('Doctor')->where('DoctorId', $id)->update($data);
        } else {
            // Cập nhật cho bảng AccountUser
            $data = [
                'Username' => $request->input('username'),
                'Email'    => $request->input('email'),
                'Role'     => $roleInt, // Dùng biến $roleInt kiểu INT đã ép về 1 hoặc 2
            ];

            if ($request->filled('password')) {
                $data['Password'] = Hash::make($request->input('password'));
            }

            DB::table('AccountUser')->where('UserId', $id)->update($data);
        }

        return redirect()->route('admin.users.index')->with('success', 'Update successful!');
    }
}

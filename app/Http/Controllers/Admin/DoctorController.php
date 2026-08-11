<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{
    // 1. Danh sách Bác sĩ
    public function index()
    {
        $doctors = DB::table('Doctor')
            ->leftJoin('Specialization', 'Doctor.SpecializationId', '=', 'Specialization.SpecializationId')
            ->leftJoin('ClinicRoom', 'Doctor.RoomId', '=', 'ClinicRoom.RoomId')
            ->leftJoin('City', 'Doctor.CityId', '=', 'City.CityId')
            ->whereNull('Doctor.DeletedAt')
            ->select(
                'Doctor.*',
                'Specialization.SpecializationName',
                'ClinicRoom.RoomName',
                'ClinicRoom.RoomNumber',
                'City.CityName'
            )
            ->orderBy('Doctor.CreatedAt', 'desc')
            ->paginate(15);

        return view('admin.doctors.index', compact('doctors'));
    }

    // 2. Form tạo Bác sĩ
    public function create()
    {
        $cities = DB::table('City')->get();
        $specializations = DB::table('Specialization')->get();
        $rooms = DB::table('ClinicRoom')->where('IsActive', 1)->get();

        return view('admin.doctors.create', compact('cities', 'specializations', 'rooms'));
    }

    // 3. Xử lý lưu Bác sĩ
    public function store(Request $request)
    {
        $request->validate([
            'name'             => 'required|string|max:100',
            'username'         => 'required|string|max:50|unique:Doctor,Username',
            'email'            => 'required|email|max:100|unique:Doctor,Email',
            'password'         => 'required|string|min:6',
            'phone_number'     => 'required|string|max:20',
            'gender'           => 'nullable|string|max:10',
            'qualifications'   => 'nullable|string|max:100',
            'specialization_id' => 'nullable|integer',
            'city_id'          => 'nullable|integer',
            'room_id'          => 'nullable|integer',
            'address'          => 'nullable|string|max:255',
        ]);

        DB::table('Doctor')->insert([
            'FullName'         => $request->input('name'),
            'Username'         => $request->input('username'),
            'Email'            => $request->input('email'),
            'Password'         => Hash::make($request->input('password')),
            'PhoneNumber'      => $request->input('phone_number'),
            'Gender'           => $request->input('gender'),
            'Qualifications'   => $request->input('qualifications'),
            'SpecializationId' => $request->input('specialization_id') ?: null,
            'CityId'           => $request->input('city_id') ?: null,
            'RoomId'           => $request->input('room_id') ?: null,
            'Address'          => $request->input('address'),
            'CreatedAt'        => now(),
            'UpdatedAt'        => now(),
        ]);

        return redirect()->route('admin.doctors.index')->with('success', 'Thêm bác sĩ thành công!');
    }

    // 4. Form sửa Bác sĩ
    public function edit($id)
    {
        $doctor = DB::table('Doctor')
            ->where('DoctorId', $id)
            ->whereNull('DeletedAt')
            ->first();

        if (!$doctor) {
            return redirect()->route('admin.doctors.index')->with('error', 'Không tìm thấy bác sĩ!');
        }

        $cities = DB::table('City')->get();
        $specializations = DB::table('Specialization')->get();
        $rooms = DB::table('ClinicRoom')->where('IsActive', 1)->get();

        return view('admin.doctors.edit', compact('doctor', 'cities', 'specializations', 'rooms'));
    }

    // 5. Cập nhật Bác sĩ
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'         => 'required|string|max:100',
            'username'     => 'required|string|max:50|unique:Doctor,Username,' . $id . ',DoctorId',
            'email'        => 'required|email|max:100|unique:Doctor,Email,' . $id . ',DoctorId',
            'phone_number' => 'required|string|max:20',
        ]);

        $data = [
            'FullName'         => $request->input('name'),
            'Username'         => $request->input('username'),
            'Email'            => $request->input('email'),
            'PhoneNumber'      => $request->input('phone_number'),
            'Gender'           => $request->input('gender'),
            'Qualifications'   => $request->input('qualifications'),
            'SpecializationId' => $request->input('specialization_id') ?: null,
            'CityId'           => $request->input('city_id') ?: null,
            'RoomId'           => $request->input('room_id') ?: null,
            'Address'          => $request->input('address'),
            'UpdatedAt'        => now(),
        ];

        if ($request->filled('password')) {
            $data['Password'] = Hash::make($request->input('password'));
        }

        DB::table('Doctor')->where('DoctorId', $id)->update($data);

        return redirect()->route('admin.doctors.index')->with('success', 'Cập nhật bác sĩ thành công!');
    }

    // 6. Xóa mềm Bác sĩ
    public function destroy($id)
    {
        DB::table('Doctor')->where('DoctorId', $id)->update(['DeletedAt' => now()]);

        return redirect()->route('admin.doctors.index')->with('success', 'Xóa bác sĩ thành công!');
    }
}

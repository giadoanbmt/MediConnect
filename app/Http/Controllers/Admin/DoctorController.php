<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{
    // 1. Danh sách Bác sĩ - Sắp xếp mới nhất & Tìm kiếm
    public function index(Request $request)
    {
        $keyword = trim($request->get('keyword', ''));

        $query = DB::table('Doctor')
            ->leftJoin('Specialization', 'Doctor.SpecializationId', '=', 'Specialization.SpecializationId')
            ->leftJoin('ClinicRoom', 'Doctor.RoomId', '=', 'ClinicRoom.RoomId')
            ->leftJoin('City', 'Doctor.CityId', '=', 'City.CityId')
            ->whereNull('Doctor.DeletedAt')
            ->select(
                'Doctor.*',
                'Specialization.SpecializationName',
                'ClinicRoom.RoomName',
                'ClinicRoom.RoomNumber',
                'City.CityName',
                'City.DistrictName'
            );

        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('Doctor.FullName', 'like', "%{$keyword}%")
                    ->orWhere('Doctor.Username', 'like', "%{$keyword}%")
                    ->orWhere('Doctor.Email', 'like', "%{$keyword}%")
                    ->orWhere('Doctor.PhoneNumber', 'like', "%{$keyword}%")
                    ->orWhere('Specialization.SpecializationName', 'like', "%{$keyword}%")
                    ->orWhere('ClinicRoom.RoomName', 'like', "%{$keyword}%")
                    ->orWhere('City.CityName', 'like', "%{$keyword}%")
                    ->orWhere('City.DistrictName', 'like', "%{$keyword}%");
            });
        }

        $doctors = $query->orderBy('Doctor.CreatedAt', 'desc')
            ->orderBy('Doctor.DoctorId', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('admin.doctors.index', compact('doctors', 'keyword'));
    }

    // 2. Form tạo Bác sĩ (Lọc trực tiếp từ Request)
    public function create(Request $request)
    {
        $selectedSpecId = $request->get('specialization_id');
        $selectedCity   = $request->get('city_name');

        // Lấy danh sách Tên Thành phố duy nhất
        $cities = DB::table('City')
            ->select('CityName')
            ->distinct()
            ->orderBy('CityName', 'asc')
            ->get();

        // Lọc danh sách Quận/Huyện dựa trên Thành phố được chọn
        $districts = DB::table('City')
            ->when($selectedCity, function ($query) use ($selectedCity) {
                return $query->where('CityName', $selectedCity);
            })
            ->orderBy('DistrictName', 'asc')
            ->get();

        // Lấy danh sách Chuyên khoa
        $specializations = DB::table('Specialization')
            ->orderBy('SpecializationName', 'asc')
            ->get();

        // Lọc danh sách Phòng khám dựa trên Chuyên khoa được chọn
        $rooms = DB::table('ClinicRoom')
            ->where('IsActive', 1)
            ->when($selectedSpecId, function ($query) use ($selectedSpecId) {
                return $query->where('SpecializationId', $selectedSpecId);
            })
            ->orderBy('RoomNumber', 'asc')
            ->get();

        return view('admin.doctors.create', compact(
            'cities',
            'districts',
            'specializations',
            'rooms',
            'selectedSpecId',
            'selectedCity'
        ));
    }

    // 3. Xử lý lưu Bác sĩ
    public function store(Request $request)
    {
        $request->validate([
            'name'              => 'required|string|max:100',
            'username'          => 'required|string|max:50|unique:Doctor,Username',
            'email'             => 'required|email|max:100|unique:Doctor,Email',
            'password'          => 'required|string|min:6',
            'phone_number'      => 'required|string|max:20',
            'gender'            => 'nullable|string|max:10',
            'qualifications'    => 'nullable|string|max:100',
            'specialization_id'  => 'nullable|integer',
            'city_id'           => 'nullable|integer',
            'room_id'           => 'nullable|integer',
            'address'           => 'nullable|string|max:255',
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

        return redirect()->route('admin.doctors.index')->with('success', 'Add doctor successfully!');
    }

    // 4. Form sửa Bác sĩ (Khôi phục dữ liệu đã chọn hoặc lọc mới từ Request)
    public function edit(Request $request, $id)
    {
        // Thêm leftJoin với bảng City để lấy thuộc tính CityName cho $doctor
        $doctor = DB::table('Doctor')
            ->leftJoin('City', 'Doctor.CityId', '=', 'City.CityId')
            ->where('Doctor.DoctorId', $id)
            ->whereNull('Doctor.DeletedAt')
            ->select('Doctor.*', 'City.CityName')
            ->first();

        if (!$doctor) {
            return redirect()->route('admin.doctors.index')->with('error', 'Doctor not found!');
        }

        $specializations = DB::table('Specialization')->get();
        $cities = DB::table('City')->select('CityName')->distinct()->get();

        // Lọc phòng khám theo chuyên khoa
        $selectedSpecId = $request->get('specialization_id', $doctor->SpecializationId);
        $rooms = DB::table('ClinicRoom')
            ->when($selectedSpecId, fn($q) => $q->where('SpecializationId', $selectedSpecId))
            ->get();

        // Lọc quận/huyện theo thành phố ($doctor->CityName đã khả dụng)
        $selectedCityName = $request->get('city_name', $doctor->CityName);
        $districts = DB::table('City')
            ->when($selectedCityName, fn($q) => $q->where('CityName', $selectedCityName))
            ->get();

        return view('admin.doctors.edit', compact('doctor', 'specializations', 'rooms', 'cities', 'districts'));
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

        return redirect()->route('admin.doctors.index')->with('success', 'Update doctor information successfully!');
    }

    // 6. Xóa mềm Bác sĩ
    public function destroy($id)
    {
        DB::table('Doctor')->where('DoctorId', $id)->update(['DeletedAt' => now()]);

        return redirect()->route('admin.doctors.index')->with('success', 'Delete account doctor successfully!');
    }
}

<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use App\Models\Doctor;
use Illuminate\Http\Request;


class DoctorController extends Controller
{
    public function dashboard(): View
    {
        return view('doctor.dashboard');
    }

    // Tìm kiếm bác sĩ theo bộ lọc
    public function index(Request $request)
    {
        $query = Doctor::with('user');

        // Lọc theo thành phố
        if ($request->filled('city')) {
            $query->where('city', 'LIKE', '%' . $request->city . '%');
        }

        // Lọc theo chuyên ngành (specialization)
        if ($request->filled('specialization')) {
            $query->where('specialization', 'LIKE', '%' . $request->specialization . '%');
        }

        $doctors = $query->get();

        return response()->json($doctors);
    }

    // Xem chi tiết bác sĩ và danh sách khung giờ trống (Available)
    public function show($id)
    {
        $doctor = Doctor::with(['user', 'appointments' => function ($q) {
            $q->where('status', 'Available')
                ->where('appointment_date', '>=', now());
        }])->findOrFail($id);

        return response()->json($doctor);
    }
    // Xem hồ sơ bác sĩ
    public function profile()
    {
        $doctor = Doctor::findOrFail(session('doctor_id'));

        return view('doctor.profile', compact('doctor'));
    }

    // Cập nhật hồ sơ bác sĩ
    public function updateProfile(Request $request)
    {
        $doctor = Doctor::findOrFail(session('doctor_id'));

        $validated = $request->validate([
            'DoctorName' => 'required|string|max:255',
<<<<<<< HEAD
            'Gender' => 'required|string|max:20',
=======
            'Sex' => 'required|string|max:20',
>>>>>>> 9055961252df2b6344616ae09933e26c5b164dd2
            'PhoneNumber' => 'required|string|max:20',
            'Email' => 'required|email|max:255',
            'Qualifications' => 'nullable|string|max:255',
            'Address' => 'nullable|string|max:255',
        ]);

        $doctor->update($validated);

        // Cập nhật tên trong session luôn
        session(['doctor_name' => $doctor->DoctorName]);

        return redirect()
            ->route('doctor.profile')
            ->with('success', 'Cập nhật hồ sơ thành công!');
    }


    /**
     * Màn hình danh sách bài viết của Bác sĩ
     */
    public function blogIndex()
    {
        return view('doctor.blog.blogIndex');
    }

    /**
     * Màn hình tạo bài viết mới
     */
    public function createBlog()
    {
        return view('doctor.blog.createBlog');
    }

    /**
     * Màn hình chỉnh sửa bài viết
     */
    public function editBlog($id)
    {
        return view('doctor.blog.edit', compact('id'));
    }
}

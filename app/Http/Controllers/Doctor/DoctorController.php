<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use App\Models\Doctor\Doctor;
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

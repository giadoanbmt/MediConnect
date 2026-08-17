<?php

namespace App\Http\Controllers\Patient;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use App\Models\Doctor;
use App\Models\Specialization;
use App\Models\City;


class PatientController extends Controller
{
    public function index(): View
    {
        return view('patient.index');
    }

    public function about(): View
    {
        return view('patient.about');
    }

    public function service(): View
    {
        return view('patient.service');
    }

    public function specialization(): View
    {
        return view('patient.specialization');
    }

    public function specializationCardiology(): View
    {
        return view('patient.specializations-single.Cardiology');
    }

    public function specializationDermatology(): View
    {
        return view('patient.specializations-single.Dermatology');
    }

    public function specializationOrthopedics(): View
    {
        return view('patient.specializations-single.Orthopedics');
    }

    public function specializationPediatrics(): View
    {
        return view('patient.specializations-single.Pediatrics');
    }

    public function appointment(): View
    {
        return view('patient.appointment');
    }

    public function confirmation(): View
    {
        return view('patient.confirmation');
    }

    public function blogSidebar(): View
    {
        return view('patient.blog-sidebar');
    }

    public function blogSingle(): View
    {
        return view('patient.blog-single');
    }

    // Hiển thị trang contact
    public function contact(): View
    {
        return view('patient.contact');
    }
    
    // Xử lý lưu form vào DB


    /**
     * Hiển thị trang chi tiết chuyên khoa động dựa vào tên chuyên khoa
     */
    public function specializationSingle(string $slug)
    {
        // Chuẩn hóa tên view (Ví dụ: cardiology -> Cardiology)
        $formattedName = ucfirst($slug);
        $viewPath = "patient.specializations-single.{$formattedName}";

        // Kiểm tra nếu view tồn tại thì render, ngược lại trả về 404
        if (view()->exists($viewPath)) {
            return view($viewPath);
        }

        abort(404);
    }

    // Hiển thị danh sách doctor
    public function Doctor(Request $request)
    {
        // 1. Lấy danh sách cho các bộ lọc
        $specializations = Specialization::all();
        $cities = City::all()->unique('CityName');

        // 2. Lấy từ khóa tìm kiếm
        $keyword = $request->input('keyword');

        // 3. Truy vấn danh sách Doctor (Eager loading quan hệ + Tìm kiếm)
        $doctors = Doctor::with(['specialization', 'city'])
            ->when($keyword, function ($query, $keyword) {
                return $query->where('FullName', 'like', "%{$keyword}%");
            })
            ->paginate(9)
            ->withQueryString();

        // 4. Trả dữ liệu sang View
        return view('patient.doctor', compact('doctors', 'specializations', 'cities'));
    }

    // Hiển thị Profile chi tiết của 1 Bác sĩ
    public function doctorProfile($id)
    {
        $doctor = Doctor::with('specialization')->findOrFail($id);

        return view('patient.doctorProfile  ', compact('doctor'));
    }
}

<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

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

    public function department(): View
    {
        return view('patient.department');
    }

    public function departmentSingle(): View
    {
        return view('patient.department-single');
    }

    public function doctor(): View
    {
        return view('patient.doctor');
    }

    public function doctorSingle(): View
    {
        return view('patient.doctor-single');
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

    public function contact(): View
    {
        return view('patient.contact');
    }

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
}

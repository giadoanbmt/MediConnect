<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FrontendController extends Controller
{
    // Trang chủ
    public function index()
    {
        return view('patient.index');
    }

    // Trang giới thiệu
    public function about()
    {
        return view('patient.about');
    }

    // Trang dịch vụ
    public function service()
    {
        return view('patient.service');
    }

    // Trang danh sách khoa phòng
    public function specialization() {
        return view('patient.specialization');
    }

    // Trang chi tiết khoa phòng
    public function specializationSingle() {
        return view('patient.specializations-single.Example');
    }

    // Trang danh sách bác sĩ
    public function doctor()
    {
        return view('patient.doctor');
    }

    // Trang chi tiết bác sĩ
    public function doctorSingle()
    {
        return view('patient.doctor-single');
    }

    // Trang đặt lịch khám
    public function appointment()
    {
        return view('patient.appointment');
    }

    // Trang xác nhận đặt lịch
    public function confirmation()
    {
        return view('patient.confirmation');
    }

    // Trang tin tức / bài viết (Blog sidebar)
    public function blogSidebar()
    {
        return view('patient.blog-sidebar');
    }

    // Trang chi tiết bài viết (Blog single)
    public function blogSingle()
    {
        return view('patient.blog-single');
    }

    // Trang liên hệ
    public function contact()
    {
        return view('patient.contact');
    }

    // Trang login
    public function login()
    {
        return view('patient.login');
    }

    // Trang register
    public function register()
    {
        return view('patient.register');
    }


}

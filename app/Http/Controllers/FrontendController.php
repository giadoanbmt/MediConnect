<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontendController extends Controller
{
    // Trang chủ
    public function index()
    {
        return view('index');
    }

    // Trang giới thiệu
    public function about()
    {
        return view('about');
    }

    // Trang dịch vụ
    public function service()
    {
        return view('service');
    }

    // Trang danh sách khoa phòng
    public function department()
    {
        return view('department');
    }

    // Trang chi tiết khoa phòng
    public function departmentSingle()
    {
        return view('department-single');
    }

    // Trang danh sách bác sĩ
    public function doctor()
    {
        return view('doctor');
    }

    // Trang chi tiết bác sĩ
    public function doctorSingle()
    {
        return view('doctor-single');
    }

    // Trang đặt lịch khám
    public function appointment()
    {
        return view('appointment');
    }

    // Trang xác nhận đặt lịch
    public function confirmation()
    {
        return view('confirmation');
    }

    // Trang tin tức / bài viết (Blog sidebar)
    public function blogSidebar()
    {
        return view('blog-sidebar');
    }

    // Trang chi tiết bài viết (Blog single)
    public function blogSingle()
    {
        return view('blog-single');
    }

    // Trang liên hệ
    public function contact()
    {
        return view('contact');
    }

    // Trang login
    public function login()
    {
        return view('login');
    }

    // Trang register
    public function register()
    {
        return view('register');
    }
}

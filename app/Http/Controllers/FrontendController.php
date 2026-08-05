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
    public function department() {
        return view('patient.department');
    }

    // Trang chi tiết khoa phòng
    public function departmentSingle() {
        return view('patient.department-single');
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

    // Trang doctor/login
    public function doctorLogin() {
        return view('doctor.login');
    }

    // Trang Doctor Dashboard
    public function doctorDashboard(Request $request)
    {
        // Lấy giá trị 'username' đang lưu trong session lúc bác sĩ đăng nhập
    $currentUsername = session('username'); 

        // Dùng giá trị đó để so khớp trực tiếp với cột 'DoctorAccount' trong bảng Doctor
    $doctor = DB::table('Doctor')
                ->where('DoctorAccount', $currentUsername) // <--- So sanh biến currentUsername với dữ liệu trong cột DoctorAccount
                ->first(); // Lấy 1 dữ liệu đầu tiên trùng khớp

        // Kiểm tra xem có tìm thấy bác sĩ ứng với tài khoản đó không
    if (!$doctor) {
        return redirect('/login')->with('error', 'The account does not exist.');
    }

    $doctorId = $doctor->DoctorId; // Lấy được ID chính xác của bác sĩ

    // Lấy 5 lịch hẹn gần nhất của bác sĩ show lên màn hình
    $upcomingAppointments = DB::table('Appointment')
        ->leftJoin('AccountUser', 'Appointment.UserId', '=', 'AccountUser.UserId')
        ->where('Appointment.DoctorId', $doctorId)
        ->select('Appointment.*', 'AccountUser.Username as PatientName')
        ->take(5)
        ->get();

    return view('doctor.dashboard', compact('doctor', 'upcomingAppointments'));
    }
}

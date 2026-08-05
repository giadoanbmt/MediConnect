<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FrontendController extends Controller
{
    // Trang chủ
    public function index() {
        return view('index');
    }

    // Trang giới thiệu
    public function about() {
        return view('about');
    }

    // Trang dịch vụ
    public function service() {
        return view('service');
    }

    // Trang danh sách khoa phòng (sẽ đổi lại thành chuyên khoa)
    public function department() {
        return view('department');
    }

    // Trang chi tiết khoa phòng (sẽ đổi lại thành chuyên khoa)
    public function departmentSingle() {
        return view('department-single');
    }

    // Trang danh sách bác sĩ
    public function doctor() {
        return view('doctor');
    }

    // Trang chi tiết bác sĩ
    public function doctorSingle() {
        return view('doctor-single');
    }

    // Trang đặt lịch khám
    public function appointment() {
        return view('appointment');
    }

    // Trang xác nhận đặt lịch
    public function confirmation() {
        return view('confirmation');
    }

    // Trang tin tức / bài viết (Blog sidebar)
    public function blogSidebar() {
        return view('blog-sidebar');
    }

    // Trang chi tiết bài viết (Blog single)
    public function blogSingle() {
        return view('blog-single');
    }

    // Trang liên hệ
    public function contact() {
        return view('contact');
    }

    // Trang login
    public function login() {
        return view('login');
    }

    // Trang register
    public function register() {
        return view('register');
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

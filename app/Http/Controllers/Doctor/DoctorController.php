<?php

namespace App\Http\Controllers\Doctor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;


class DoctorController extends Controller
{
    public function dashboard(): View
    {
        return view('doctor.dashboard');
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

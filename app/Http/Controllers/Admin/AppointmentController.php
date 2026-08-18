<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    /**
     * Hiển thị danh sách lịch hẹn dành cho Admin (Lọc theo trạng thái, không có Action)
     */
    public function index(Request $request)
    {
        // Mặc định hiển thị tất cả (All) nếu không truyền status
        $status = $request->get('status', 'All');

        // Truy vấn danh sách lịch hẹn kết hợp Bệnh nhân, Bác sĩ & Phòng khám
        $query = DB::table('Appointment')
            ->leftJoin('AccountUser as Patient', 'Appointment.UserId', '=', 'Patient.UserId')
            ->leftJoin('Doctor', 'Appointment.DoctorId', '=', 'Doctor.DoctorId')
            ->leftJoin('ClinicRoom', 'Appointment.RoomId', '=', 'ClinicRoom.RoomId')
            ->select(
                'Appointment.*',
                'Patient.FullName as PatientName',
                'Patient.Email as PatientEmail',
                'Doctor.FullName as DoctorName',
                'ClinicRoom.RoomNumber'
            )
            ->orderBy('Appointment.AppointmentDate', 'desc')
            ->orderBy('Appointment.StartTime', 'desc');

        // Lọc theo từng trạng thái cụ thể
        if ($status !== 'All') {
            if ($status === 'Approved') {
                $query->whereIn('Appointment.Status', ['Approved', 'Accept', 'Accepted']);
            } elseif ($status === 'Rejected' || $status === 'Cancelled') {
                // Kiểm tra cả 'Cancelled' và 'Rejected' trong DB
                $query->whereIn('Appointment.Status', ['Cancelled', 'cancelled', 'Rejected', 'Reject']);
            } else {
                $query->where('Appointment.Status', $status);
            }
        }

        $appointments = $query->paginate(10)->withQueryString();

        // Thống kê số lượng chuẩn cho các Tab Lọc
        $counts = [
            'All'       => DB::table('Appointment')->count(),
            'Pending'   => DB::table('Appointment')->where('Status', 'Pending')->count(),
            'Approved'  => DB::table('Appointment')->whereIn('Status', ['Approved', 'Accept', 'Accepted'])->count(),
            'Rejected'  => DB::table('Appointment')->whereIn('Status', ['Cancelled', 'cancelled', 'Rejected', 'Reject'])->count(),
            'Completed' => DB::table('Appointment')->where('Status', 'Completed')->count(),
        ];

        return view('admin.appointments.index', compact('appointments', 'status', 'counts'));
    }
}

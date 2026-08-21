<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    /**
     * Hiển thị danh sách lịch hẹn dành cho Admin (Lọc theo trạng thái & Tìm kiếm)
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'All');
        $keyword = trim($request->get('keyword', ''));

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
            );

        // Lọc theo trạng thái
        if ($status !== 'All') {
            if ($status === 'Approved') {
                $query->whereIn('Appointment.Status', ['Approved', 'Accept', 'Accepted']);
            } elseif ($status === 'Rejected' || $status === 'Cancelled') {
                $query->whereIn('Appointment.Status', ['Cancelled', 'cancelled', 'Rejected', 'Reject']);
            } else {
                $query->where('Appointment.Status', $status);
            }
        }

        // Tìm kiếm theo từ khóa (Bệnh nhân, Bác sĩ, Số phòng, Lý do)
        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('Patient.FullName', 'like', "%{$keyword}%")
                    ->orWhere('Patient.Email', 'like', "%{$keyword}%")
                    ->orWhere('Doctor.FullName', 'like', "%{$keyword}%")
                    ->orWhere('ClinicRoom.RoomNumber', 'like', "%{$keyword}%")
                    ->orWhere('Appointment.Reason', 'like', "%{$keyword}%");
            });
        }

        // Sắp xếp danh sách mới tạo/mới đăng ký lên đầu tiên
        $query->orderBy('Appointment.CreatedAt', 'desc')
            ->orderBy('Appointment.AppointmentId', 'desc');

        $appointments = $query->paginate(10)->withQueryString();

        // Thống kê số lượng (có áp dụng tìm kiếm nếu có từ khóa)
        $baseCount = DB::table('Appointment')
            ->leftJoin('AccountUser as Patient', 'Appointment.UserId', '=', 'Patient.UserId')
            ->leftJoin('Doctor', 'Appointment.DoctorId', '=', 'Doctor.DoctorId')
            ->leftJoin('ClinicRoom', 'Appointment.RoomId', '=', 'ClinicRoom.RoomId');

        if (!empty($keyword)) {
            $baseCount->where(function ($q) use ($keyword) {
                $q->where('Patient.FullName', 'like', "%{$keyword}%")
                    ->orWhere('Patient.Email', 'like', "%{$keyword}%")
                    ->orWhere('Doctor.FullName', 'like', "%{$keyword}%")
                    ->orWhere('ClinicRoom.RoomNumber', 'like', "%{$keyword}%")
                    ->orWhere('Appointment.Reason', 'like', "%{$keyword}%");
            });
        }

        $counts = [
            'All'       => (clone $baseCount)->count(),
            'Pending'   => (clone $baseCount)->where('Appointment.Status', 'Pending')->count(),
            'Approved'  => (clone $baseCount)->whereIn('Appointment.Status', ['Approved', 'Accept', 'Accepted'])->count(),
            'Rejected'  => (clone $baseCount)->whereIn('Appointment.Status', ['Cancelled', 'cancelled', 'Rejected', 'Reject'])->count(),
            'Completed' => (clone $baseCount)->where('Appointment.Status', 'Completed')->count(),
        ];

        return view('admin.appointments.index', compact('appointments', 'status', 'keyword', 'counts'));
    }
}

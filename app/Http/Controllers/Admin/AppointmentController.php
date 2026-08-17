<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    /**
     * Hiển thị danh sách lịch hẹn dành cho Admin (Phân trang 10 mục)
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'Pending');

        // Truy vấn danh sách lịch hẹn kết hợp lấy thông tin Bệnh nhân & Bác sĩ
        $query = DB::table('Appointment')
            ->leftJoin('AccountUser as Patient', 'Appointment.UserId', '=', 'Patient.UserId')
            ->leftJoin('Doctor', 'Appointment.DoctorId', '=', 'Doctor.DoctorId')
            ->select(
                'Appointment.*',
                'Patient.FullName as PatientName',
                'Patient.Email as PatientEmail',
                'Doctor.FullName as DoctorName'
            )
            ->orderBy('Appointment.AppointmentId', 'asc');

        if ($status !== 'All') {
            $query->where('Appointment.Status', $status);
        }

        $appointments = $query->paginate(10);

        // Đếm số lượng theo từng trạng thái phục vụ hiển thị Tab
        $counts = [
            'Pending'  => DB::table('Appointment')->where('Status', 'Pending')->count(),
            'Approved' => DB::table('Appointment')->where('Status', 'Approved')->count(),
            'Rejected' => DB::table('Appointment')->where('Status', 'Rejected')->count(),
            'All'      => DB::table('Appointment')->count(),
        ];

        return view('admin.appointments.index', compact('appointments', 'status', 'counts'));
    }

    /**
     * Chấp nhận / Duyệt lịch hẹn
     */
    public function approve($id)
    {
        DB::table('Appointment')
            ->where('AppointmentId', $id)
            ->update([
                'Status'    => 'Approved',
                'UpdatedAt' => now(),
            ]);

        return redirect()->back()->with('success', 'The appointment has been approved successfully!');
    }

    /**
     * Từ chối lịch hẹn kèm lý do
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'reject_reason' => 'required|string|max:500',
        ]);

        DB::table('Appointment')
            ->where('AppointmentId', $id)
            ->update([
                'Status'             => 'Rejected',
                'CancellationReason' => $request->input('reject_reason'),
                'UpdatedAt'          => now(),
            ]);

        return redirect()->back()->with('success', 'The appointment has been rejected successfully!');
    }
}

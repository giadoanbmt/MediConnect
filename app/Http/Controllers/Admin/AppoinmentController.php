<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    // 1. Hiển thị danh sách lịch hẹn (Phân trang 10 mục)
    public function index(Request $request)
    {
        $status = $request->get('status', 'Pending'); // Mặc định hiển thị 'Pending'

        $query = DB::table('Appointments')
            ->leftJoin('AccountUser as Patient', 'Appointments.PatientId', '=', 'Patient.AccountId')
            ->leftJoin('AccountUser as Doctor', 'Appointments.DoctorId', '=', 'Doctor.AccountId')
            ->select(
                'Appointments.*',
                'Patient.FullName as PatientName',
                'Patient.Email as PatientEmail',
                'Doctor.FullName as DoctorName'
            )
            ->orderBy('Appointments.AppointmentId', 'desc');

        if ($status !== 'All') {
            $query->where('Appointments.Status', $status);
        }

        $appointments = $query->paginate(10);

        // Đếm số lượng theo trạng thái để hiển thị trên các Tab
        $counts = [
            'Pending'  => DB::table('Appointments')->where('Status', 'Pending')->count(),
            'Approved' => DB::table('Appointments')->where('Status', 'Approved')->count(),
            'Rejected' => DB::table('Appointments')->where('Status', 'Rejected')->count(),
            'All'      => DB::table('Appointments')->count(),
        ];

        return view('admin.appointments.index', compact('appointments', 'status', 'counts'));
    }

    // 2. Duyệt lịch hẹn và chuyển đến Bác sĩ
    public function approve($id)
    {
        $adminId = auth()->user()->AccountId ?? auth()->user()->id ?? null;

        DB::table('Appointments')->where('AppointmentId', $id)->update([
            'Status'     => 'Approved',
            'ApprovedBy' => $adminId,
            'UpdatedAt'  => now(),
        ]);

        return redirect()->back()->with('success', 'Lịch hẹn đã được duyệt và chuyển tới Bác sĩ thành công!');
    }

    // 3. Từ chối lịch hẹn kèm lý do
    public function reject(Request $request, $id)
    {
        $request->validate([
            'reject_reason' => 'required|string|max:500',
        ]);

        $adminId = auth()->user()->AccountId ?? auth()->user()->id ?? null;

        DB::table('Appointments')->where('AppointmentId', $id)->update([
            'Status'       => 'Rejected',
            'RejectReason' => $request->reject_reason,
            'ApprovedBy'   => $adminId,
            'UpdatedAt'    => now(),
        ]);

        return redirect()->back()->with('success', 'Đã từ chối lịch hẹn thành công!');
    }
}

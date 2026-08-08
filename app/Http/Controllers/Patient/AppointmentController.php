<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    // Xem danh sách lịch hẹn cá nhân
    public function index()
    {
        $appointments = Appointment::with('doctor.user')
            ->where('patient_id', Auth::id())
            ->orderBy('appointment_date', 'desc')
            ->get();

        return response()->json($appointments);
    }

    // Logic Đặt lịch hẹn (Booking) dựa trên khung giờ Available của Bác sĩ
    public function book(Request $request, $id)
    {
        $appointment = Appointment::where('id', $id)
            ->where('status', 'Available')
            ->firstOrFail();

        // Chuyển trạng thái sang Booked và gán patient_id
        $appointment->update([
            'patient_id' => Auth::id(),
            'status'     => 'Booked',
            'notes'      => $request->input('notes', null)
        ]);

        return response()->json(['message' => 'Đặt lịch hẹn thành công!', 'appointment' => $appointment]);
    }

    // Dời lịch hẹn sang khung giờ trống khác
    public function reschedule(Request $request, $id)
    {
        $request->validate([
            'new_appointment_id' => 'required|exists:appointments,id',
        ]);

        // Hủy lịch cũ
        $oldAppointment = Appointment::where('id', $id)
            ->where('patient_id', Auth::id())
            ->firstOrFail();

        $oldAppointment->update([
            'patient_id' => null,
            'status'     => 'Available'
        ]);

        // Đặt lịch mới
        $newAppointment = Appointment::where('id', $request->new_appointment_id)
            ->where('status', 'Available')
            ->firstOrFail();

        $newAppointment->update([
            'patient_id' => Auth::id(),
            'status'     => 'Booked'
        ]);

        return response()->json(['message' => 'Dời lịch hẹn thành công!']);
    }

    // Hủy lịch hẹn
    public function cancel($id)
    {
        $appointment = Appointment::where('id', $id)
            ->where('patient_id', Auth::id())
            ->firstOrFail();

        $appointment->update([
            'patient_id' => null,
            'status'     => 'Available',
        ]);

        return response()->json(['message' => 'Đã hủy lịch hẹn thành công!']);
    }
}

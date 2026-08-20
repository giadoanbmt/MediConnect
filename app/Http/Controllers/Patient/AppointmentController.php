<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\Specialization;


class AppointmentController extends Controller
{
    // Xem danh sách lịch hẹn cá nhân
    public function index()
    {
        $appointments = Appointment::with('doctor.user')
            ->where('PatientId', Auth::id())
            ->orderBy('AppointmentDate', 'desc')
            ->get();

        return response()->json($appointments);
    }

    // Hiển thị trang đặt lịch hẹn
    public function create(Request $request)
    {
        // 1. Lấy danh sách Chuyên khoa
        try {
            $specializations = class_exists(Specialization::class)
                ? Specialization::all()
                : DB::table('specializations')->get();
        } catch (\Exception $e) {
            $specializations = DB::table('Specialization')->get();
        }

        // 2. Lấy trực tiếp danh sách Bác sĩ từ bảng Doctor (không dùng relationship user)
        $doctors = Doctor::all();
        $selectedDoctorId = $request->query('doctorId');

        return view('patient.appointment', compact('specializations', 'doctors', 'selectedDoctorId'));
    }

    /**
     * API AJAX: Lấy Bác sĩ theo Chuyên khoa
     */
    public function getDoctorsBySpecialization(Request $request)
    {
        $specId = $request->query('specialization_id');

        $query = Doctor::query();
        if ($specId) {
            $query->where('SpecializationId', $specId);
        }

        $doctors = $query->get()->map(function ($doc) {
            return [
                'DoctorId' => $doc->DoctorId ?? $doc->id,
                'FullName' => $doc->FullName ?? $doc->DoctorName ?? $doc->Name ?? ('Dr. ' . ($doc->DoctorId ?? $doc->id))
            ];
        });

        return response()->json($doctors);
    }

    /**
     * API AJAX: Lấy các khung giờ trống theo Bác sĩ & Ngày
     */
    public function getSlots(Request $request)
    {
        $doctorId = $request->query('doctor_id');
        $date = $request->query('date');

        if (!$doctorId || !$date) {
            return response()->json([]);
        }

        // Truy vấn chính xác theo các cột trong bảng DoctorSchedule
        $slots = DB::table('DoctorSchedule')
            ->where('DoctorId', $doctorId)
            ->whereDate('WorkDate', $date)
            ->where('Status', 'Available')
            ->get();

        $data = $slots->map(function ($slot) {
            $startTime = Carbon::parse($slot->StartTime)->format('H:i');
            $endTime = Carbon::parse($slot->EndTime)->format('H:i');

            return [
                'AppointmentId' => $slot->ScheduleId, // Map ScheduleId thành AppointmentId để khớp với AJAX View
                'ScheduleId'    => $slot->ScheduleId,
                'TimeDisplay'   => "{$startTime} - {$endTime}",
            ];
        });

        return response()->json($data);
    }
    // Logic Đặt lịch hẹn (Booking) dựa trên khung giờ Available của Bác sĩ
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to use this feature!');
        }

        $request->validate([
            'DoctorId'        => 'required',
            'AppointmentId'   => 'required',
            'AppointmentDate' => 'required|date',
            'Phone'           => 'required|string|max:20',
        ]);

        $scheduleId = $request->input('AppointmentId');

        // Lấy thông tin khung giờ từ DoctorSchedule
        $schedule = DB::table('DoctorSchedule')
            ->where('ScheduleId', $scheduleId)
            ->where('Status', 'Available')
            ->where('IsBooked', '0')
            ->first();

        if (!$schedule) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'This appointment time slot is no longer available. Please choose another time!');
        }

        //  Thêm dữ liệu vào bảng Appointment
        DB::table('Appointment')->insert([
            'DoctorId'        => $request->input('DoctorId'),
            'UserId'          => Auth::id(),
            'AppointmentDate' => $request->input('AppointmentDate'),
            'StartTime'       => $schedule->StartTime,
            'EndTime'         => $schedule->EndTime,
            'Reason'          => $request->input('Message'),
            'Status'          => 'Pending',
            'CreatedAt'       => now(),
            'UpdatedAt'       => now(),
        ]);

        //  Đổi trạng thái khung giờ trong DoctorSchedule
        DB::table('DoctorSchedule')
            ->where('ScheduleId', $scheduleId)
            ->update([
                'IsBooked' => '1'
            ]);

        return redirect()->back()->with('success', 'Appointment booked successfully! We will contact you soon.');
    }



    // Dời lịch hẹn sang khung giờ trống khác
    public function reschedule(Request $request, $id)
    {
        $request->validate([
            'new_appointment_id' => 'required|exists:Appointments,AppointmentId',
        ]);

        // Hủy lịch cũ
        $oldAppointment = Appointment::where('AppointmentId', $id)
            ->where('PatientId', Auth::id())
            ->firstOrFail();

        $oldAppointment->update([
            'PatientId' => null,
            'Status'    => 'Available'
        ]);

        // Đặt lịch mới
        $newAppointment = Appointment::where('AppointmentId', $request->new_appointment_id)
            ->where('Status', 'Available')
            ->firstOrFail();

        $newAppointment->update([
            'PatientId' => Auth::id(),
            'Status'    => 'Booked'
        ]);

        return response()->json(['message' => 'Dời lịch hẹn thành công!']);
    }

    // Hủy lịch hẹn
    public function cancel($id)
    {
        $appointment = Appointment::where('AppointmentId', $id)
            ->where('PatientId', Auth::id())
            ->firstOrFail();

        $appointment->update([
            'PatientId' => null,
            'Status'    => 'Available',
        ]);

        return response()->json(['message' => 'Đã hủy lịch hẹn thành công!']);
    }
}

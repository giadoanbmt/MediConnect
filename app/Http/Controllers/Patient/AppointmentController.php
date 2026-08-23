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
        $userId = Auth::id() ?? session('UserId');

        $appointments = DB::table('Appointment')
            ->join('Doctor', 'Appointment.DoctorId', '=', 'Doctor.DoctorId')
            ->leftJoin('Specialization', 'Doctor.SpecializationId', '=', 'Specialization.SpecializationId')
            ->where('Appointment.UserId', $userId)
            ->select(
                'Appointment.*',
                'Doctor.FullName as DoctorName',
                'Doctor.RoomId',
                'Specialization.SpecializationName'
            )
            ->orderBy('AppointmentDate', 'desc')
            ->orderBy('StartTime', 'desc')
            ->get();

        return view('patient.appointments.index', compact('appointments'));
    }

    // Hiển thị trang đặt lịch hẹn
    public function create(Request $request)
    {
        $specializations = DB::table('Specialization')->get();

        // Lấy doctor_id truyền từ URL (?doctor_id=X)
        $selectedDoctorId = $request->query('doctor_id');
        $selectedSpecializationId = null;

        if ($selectedDoctorId) {
            // Tìm bác sĩ theo ID để lấy SpecializationId tương ứng
            $selectedDoctor = DB::table('Doctor')->where('DoctorId', $selectedDoctorId)->first();

            if ($selectedDoctor) {
                $selectedSpecializationId = $selectedDoctor->SpecializationId;
                // Chỉ lấy các bác sĩ thuộc cùng Chuyên khoa này
                $doctors = DB::table('Doctor')->where('SpecializationId', $selectedSpecializationId)->get();
            } else {
                $doctors = DB::table('Doctor')->get();
            }
        } else {
            $doctors = DB::table('Doctor')->get();
        }

        return view('patient.appointments.appointment', compact(
            'specializations',
            'doctors',
            'selectedDoctorId',
            'selectedSpecializationId'
        ));
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
            ->where('IsBooked', '0')
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
        $doctorId = $request->input('DoctorId');

        // Lấy thông tin RoomId từ Doctor
        $roomId = DB::table('Doctor')
            ->where('DoctorId', $doctorId)
            ->value('RoomId');

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
            'RoomId'          => $roomId,
            'AppointmentDate' => $request->input('AppointmentDate'),
            'StartTime'       => $schedule->StartTime,
            'EndTime'         => $schedule->EndTime,
            'Reason'          => $request->input('Reason'),
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

    // Hiển thị trang dời lịch
    public function reschedule(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in!');
        }

        // Lấy thông tin lịch hẹn hiện tại của bệnh nhân
        $appointment = DB::table('Appointment')
            ->join('Doctor', 'Appointment.DoctorId', '=', 'Doctor.DoctorId')
            ->leftJoin('Specialization', 'Doctor.SpecializationId', '=', 'Specialization.SpecializationId')
            ->where('Appointment.AppointmentId', $id)
            ->where('Appointment.UserId', Auth::id())
            ->select(
                'Appointment.*',
                'Doctor.FullName as DoctorName',
                'Specialization.SpecializationName'
            )
            ->first();

        if (!$appointment) {
            return redirect()->back()->with('error', 'Appointment not found!');
        }

        // Kiểm tra không cho dời lịch đã bị hủy
        if ($appointment->Status === 'Cancelled') {
            return redirect()->back()->with('error', 'Cannot reschedule a past or canceled appointment!');
        }

        return view('patient.appointments.reschedule', compact('appointment'));
    }

    /**
     * 2. Xử lý Cập nhật Dời lịch (Giữ nguyên AppointmentId, đổi khung giờ & ngày)
     */
    public function updateReschedule(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in');
        }

        $request->validate([
            'AppointmentDate' => 'required|date|after_or_equal:today',
            'ScheduleId'      => 'required', // ID khung giờ mới được chọn từ DoctorSchedule
        ], [
            'AppointmentDate.required'       => 'Please select a new appointment date.',
            'AppointmentDate.after_or_equal' => 'The new appointment date cannot be in the past.',
            'ScheduleId.required'            => 'Please select new appointment time slot.',
        ]);

        $userId = Auth::id();
        $newScheduleId = $request->input('ScheduleId');

        // Kiểm tra cuộc hẹn cũ
        $appointment = DB::table('Appointment')
            ->where('AppointmentId', $id)
            ->where('UserId', $userId)
            ->first();

        if (!$appointment) {
            return redirect()->back()->with('error', 'The appointment does not exist!');
        }

        // Kiểm tra khung giờ mới trong DoctorSchedule
        $newSchedule = DB::table('DoctorSchedule')
            ->where('ScheduleId', $newScheduleId)
            ->where('Status', 'Available')
            ->where('IsBooked', '0')
            ->first();


        DB::transaction(function () use ($appointment, $newSchedule, $request, $id) {
            // A. Giải phóng khung giờ CŨ trong DoctorSchedule (chuyển IsBooked về '0')
            DB::table('DoctorSchedule')
                ->where('DoctorId', $appointment->DoctorId)
                ->whereDate('WorkDate', $appointment->AppointmentDate)
                ->where('StartTime', $appointment->StartTime)
                ->where('EndTime', $appointment->EndTime)
                ->update(['IsBooked' => '0']);

            // B. Đánh dấu khung giờ MỚI trong DoctorSchedule (chuyển IsBooked thành '1')
            DB::table('DoctorSchedule')
                ->where('ScheduleId', $newSchedule->ScheduleId)
                ->update(['IsBooked' => '1']);

            // C. Cập nhật trực tiếp bản ghi Appointment CŨ (Giữ nguyên AppointmentId)
            DB::table('Appointment')
                ->where('AppointmentId', $id)
                ->update([
                    'AppointmentDate' => $request->input('AppointmentDate'),
                    'StartTime'       => $newSchedule->StartTime,
                    'EndTime'         => $newSchedule->EndTime,
                    'Reason'          => $request->input('Reason', $appointment->Reason),
                    'Status'          => 'Pending', // Đưa về trạng thái chờ duyệt
                    'UpdatedAt'       => now(),
                ]);
        });

        return redirect()->route('patient.appointments.index')
            ->with('success', 'Appointment rescheduled successfully! Your appointment is now pending confirmation.');
    }

    // Hủy lịch hẹn
    public function cancel($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to cancel appointments!');
        }

        $userId = Auth::id();

        // 1. Lấy thông tin cuộc hẹn
        $appointment = DB::table('Appointment')
            ->where('AppointmentId', $id)
            ->where('UserId', $userId)
            ->first();

        if (!$appointment) {
            return redirect()->back()->with('error', 'Appointment not found!');
        }

        // 2. Chỉ cho phép hủy nếu trạng thái đang là Pending hoặc Confirmed
        if (!in_array($appointment->Status, ['Pending', 'Confirmed'])) {
            return redirect()->back()->with('error', 'This appointment cannot be cancelled!');
        }

        // 3. Cập nhật trạng thái cuộc hẹn & Nhả khung giờ trống trong DoctorSchedule
        DB::transaction(function () use ($appointment, $id) {
            // Cập nhật trạng thái lịch hẹn thành Cancelled
            DB::table('Appointment')
                ->where('AppointmentId', $id)
                ->update([
                    'Status'    => 'Cancelled',
                    'UpdatedAt' => now(),
                ]);

            // Trả lại khung giờ trống cho Bác sĩ (chuyển IsBooked = '0')
            DB::table('DoctorSchedule')
                ->where('DoctorId', $appointment->DoctorId)
                ->whereDate('WorkDate', $appointment->AppointmentDate)
                ->where('StartTime', $appointment->StartTime)
                ->where('EndTime', $appointment->EndTime)
                ->update(['IsBooked' => '0']);
        });

        return redirect()->back()->with('success', 'Appointment cancelled successfully!');
    }
}

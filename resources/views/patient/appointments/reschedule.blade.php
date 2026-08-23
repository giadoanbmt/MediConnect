@extends('components.layouts.patient.dashboard')
@section('title', 'Reschedule Appointment - MediConnect')

@section('content')

<section class="page-title bg-1">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="block text-center">
                    <span class="text-white">Change Your Schedule</span>
                    <h1 class="text-capitalize mb-5 text-lg">Reschedule Appointment #{{ $appointment->AppointmentId }}</h1>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="appoinment section">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="mt-3">
                    <div class="feature-icon mb-3">
                        <i class="icofont-support text-lg"></i>
                    </div>
                    <span class="h3">Call for Emergency Service!</span>
                    <h2 class="text-color mt-3">+84 789 1256</h2>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="appoinment-wrap mt-5 mt-lg-0 pl-lg-5">
                    <h2 class="mb-2 title-color">Reschedule Your Appointment</h2>
                    <p class="mb-4">Specialization and Doctor are fixed for this appointment. Please select a new date and available time slot.</p>

                    @if(session('success'))
                    <div class="alert alert-success mb-4">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                    <div class="alert alert-danger mb-4">{{ session('error') }}</div>
                    @endif
                    @if ($errors->any())
                    <div class="alert alert-danger mb-4">
                        <ul class="mb-0 pl-3">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form id="rescheduleForm" class="appoinment-form" method="POST" action="{{ route('patient.appointments.updateReschedule', $appointment->AppointmentId) }}">
                        @csrf
                        @method('POST')

                        {{-- Hidden DoctorId để gửi sang AJAX & Submit --}}
                        <input type="hidden" name="DoctorId" id="doctorId" value="{{ $appointment->DoctorId }}">

                        <div class="row">
                            <!-- 1. Chuyên khoa (Cố định / Disabled) -->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Specialization</label>
                                    <select class="form-control" disabled style="background-color: #e9ecef; cursor: not-allowed;">
                                        <option selected>{{ $appointment->SpecializationName ?? 'N/A' }}</option>
                                    </select>
                                </div>
                            </div>

                            <!-- 2. Bác sĩ (Cố định / Disabled) -->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Doctor</label>
                                    <select class="form-control" disabled style="background-color: #e9ecef; cursor: not-allowed;">
                                        <option selected>{{ $appointment->DoctorName }}</option>
                                    </select>
                                </div>
                            </div>

                            <!-- 3. Ngày khám mới -->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">New Date <span class="text-danger">*</span></label>
                                    <input name="AppointmentDate" id="date" type="date" class="form-control"
                                        value="{{ old('AppointmentDate', $appointment->AppointmentDate) }}"
                                        min="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>

                            <!-- 4. Khung giờ trống mới (Tải qua AJAX getSlots) -->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">New Available Time <span class="text-danger">*</span></label>
                                    <select name="ScheduleId" id="timeSlotSelect" class="form-control" required>
                                        <option value="">Select Available Time</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Ghi chú / Lý do khám -->
                        <div class="form-group-2 mb-4">
                            <label class="font-weight-bold">Message / Reason</label>
                            <textarea name="Reason" id="Reason" class="form-control" rows="4" placeholder="Reason for reschedule...">{{ old('Reason', $appointment->Reason) }}</textarea>
                        </div>

                        <!-- Nút Submit -->
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('patient.appointments.index') }}" class="btn btn-secondary">
                                <i class="icofont-arrow-left mr-1"></i> Back
                            </a>
                            <button type="submit" class="btn btn-main btn-round-full" style="border: none;">
                                Confirm Reschedule <i class="icofont-simple-right ml-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Script AJAX gọi getSlots -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        function refreshNiceSelect() {
            if ($.fn.niceSelect) {
                $('select').niceSelect('update');
            }
        }

        // Tải danh sách khung giờ trống từ API getSlots
        function loadAvailableSlots() {
            var doctorId = $('#doctorId').val();
            var date = $('#date').val();
            var $timeSelect = $('#timeSlotSelect');

            $timeSelect.html('<option value="">Loading time slots...</option>');
            refreshNiceSelect();

            if (doctorId && date) {
                $.ajax({
                    url: "{{ route('patient.appointments.get-slots') }}",
                    type: "GET",
                    data: {
                        doctor_id: doctorId,
                        date: date
                    },
                    success: function(response) {
                        $timeSelect.empty();
                        if (response && response.length > 0) {
                            $timeSelect.append('<option value="">Select Available Time</option>');
                            $.each(response, function(index, slot) {
                                $timeSelect.append('<option value="' + slot.ScheduleId + '">' + slot.TimeDisplay + '</option>');
                            });
                        } else {
                            $timeSelect.append('<option value="">No available slots on this date</option>');
                        }
                        refreshNiceSelect();
                    },
                    error: function() {
                        $timeSelect.html('<option value="">Error loading slots</option>');
                        refreshNiceSelect();
                    }
                });
            } else {
                $timeSelect.html('<option value="">Select Available Time</option>');
                refreshNiceSelect();
            }
        }

        // Bắt sự kiện khi chọn lại ngày
        $('#date').on('change', loadAvailableSlots);

        // Tự động tải danh sách khung giờ trống ngay khi mở trang
        loadAvailableSlots();
    });
</script>

@endsection
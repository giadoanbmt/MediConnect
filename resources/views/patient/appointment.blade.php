@extends('components.layouts.partials.frontend')
@section('title', 'Book Appointment - MediConnect')

@section('content')

<section class="page-title bg-1">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="block text-center">
                    <span class="text-white">Book your Seat</span>
                    <h1 class="text-capitalize mb-5 text-lg">Appoinment</h1>
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
                    <span class="h3">Call for an Emergency Service!</span>
                    <h2 class="text-color mt-3">+84 789 1256</h2>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="appoinment-wrap mt-5 mt-lg-0 pl-lg-5">
                    <h2 class="mb-2 title-color">Book an appoinment</h2>
                    <p class="mb-4">Mollitia dicta commodi est recusandae iste, natus eum asperiores corrupti qui velit. Iste dolorum atque similique praesentium soluta.</p>

                    {{-- Thông báo thành công / lỗi --}}
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

                    <form id="appointmentForm" class="appoinment-form" method="POST" action="{{ route('patient.appointments.store') }}"> @csrf
                        <div class="row">
                            <!-- 1. Chuyên khoa (Specialization) -->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <select class="form-control" name="specialization_id" id="specializationSelect">
                                        <option value="">Choose Specialization</option>
                                        @foreach($specializations ?? [] as $spec)
                                        <option value="{{ $spec->SpecializationId ?? $spec->id }}">
                                            {{ $spec->SpecializationName ?? $spec->name ?? $spec->specialization_name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- 2. Bác sĩ (Tự động lọc theo Specialization) -->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <select class="form-control" name="DoctorId" id="doctorSelect" required>
                                        <option value="">Select Doctors</option>
                                        @foreach($doctors ?? [] as $doc)
                                        <option value="{{ $doc->DoctorId ?? $doc->id }}"
                                            {{ (request('doctorId') == ($doc->DoctorId ?? $doc->id) || (isset($selectedDoctorId) && $selectedDoctorId == ($doc->DoctorId ?? $doc->id))) ? 'selected' : '' }}>
                                            {{ $doc->FullName ?? $doc->DoctorName ?? $doc->Name ?? ('Dr. ' . ($doc->DoctorId ?? $doc->id)) }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- 3. Ngày khám -->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <input name="AppointmentDate" id="date" type="date" class="form-control"
                                        value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>

                            <!-- 4. Khung giờ trống (Tự động lọc theo Bác sĩ & Ngày) -->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <select name="AppointmentId" id="timeSlotSelect" class="form-control" required>
                                        <option value="">Select Available Time</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Họ tên bệnh nhân -->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <input name="PatientName" id="name" type="text" class="form-control"
                                        placeholder="Full Name" value="{{ Auth::check() ? (Auth::user()->FullName ?? Auth::user()->name) : old('PatientName') }}" required>
                                </div>
                            </div>

                            <!-- Số điện thoại -->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <input name="Phone" id="phone" type="text" class="form-control"
                                        placeholder="Phone Number" value="{{ Auth::check() ? (Auth::user()->Phone ?? Auth::user()->phone) : old('Phone') }}" required>
                                </div>
                            </div>
                        </div>

                        <!-- Ghi chú -->
                        <div class="form-group-2 mb-4">
                            <textarea name="Reason" id="Reason" class="form-control" rows="6" placeholder="Your Message / Reason for visit">{{ old('Notes') }}</textarea>
                        </div>

                        <!-- Nút Submit -->
                        <button type="submit" class="btn btn-main btn-round-full" style="border: none;">
                            Make Appoinment <i class="icofont-simple-right ml-2"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Script AJAX lọc 3 cấp: Specialization -> Doctor -> TimeSlots -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Cập nhật UI NiceSelect sau khi render option từ AJAX
        function refreshNiceSelect() {
            if ($.fn.niceSelect) {
                $('select').niceSelect('update');
            }
        }

        // A. KHI CHỌN CHUYÊN KHOA -> TẢI DANH SÁCH BÁC SĨ THUỘC KHOA
        $('#specializationSelect').on('change', function() {
            var specId = $(this).val();
            var $docSelect = $('#doctorSelect');
            var $timeSelect = $('#timeSlotSelect');

            $docSelect.html('<option value="">Loading doctors...</option>');
            $timeSelect.html('<option value="">Select Available Time</option>');
            refreshNiceSelect();

            $.ajax({
                url: "{{ route('appointments.get-doctors') }}",
                type: "GET",
                data: {
                    specialization_id: specId
                },
                success: function(response) {
                    $docSelect.empty().append('<option value="">Select Doctors</option>');
                    if (response && response.length > 0) {
                        $.each(response, function(index, doc) {
                            $docSelect.append('<option value="' + doc.DoctorId + '">' + doc.FullName + '</option>');
                        });
                    } else {
                        $docSelect.append('<option value="">No doctors available</option>');
                    }
                    refreshNiceSelect();
                },
                error: function() {
                    $docSelect.html('<option value="">Error loading doctors</option>');
                    refreshNiceSelect();
                }
            });
        });

        // B. KHI CHỌN BÁC SĨ HOẶC NGÀY -> TẢI DANH SÁCH KHUNG GIỜ TRỐNG
        function loadAvailableSlots() {
            var doctorId = $('#doctorSelect').val();
            var date = $('#date').val();
            var $timeSelect = $('#timeSlotSelect');

            $timeSelect.html('<option value="">Loading time slots...</option>');
            refreshNiceSelect();

            if (doctorId && date) {
                $.ajax({
                    url: "{{ route('appointments.get-slots') }}",
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
                                $timeSelect.append('<option value="' + slot.AppointmentId + '">' + slot.TimeDisplay + '</option>');
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

        // Bắt sự kiện thay đổi Bác sĩ hoặc Ngày
        $('#doctorSelect, #date').on('change', loadAvailableSlots);

        // Tự động tải khung giờ nếu Bác sĩ đã được chọn từ trước (qua URL profile)
        if ($('#doctorSelect').val()) {
            loadAvailableSlots();
        }
    });
</script>

@endsection
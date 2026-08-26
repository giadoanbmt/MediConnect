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
                                        <option value="{{ $spec->SpecializationId ?? $spec->id }}"
                                            {{ (isset($selectedSpecializationId) && $selectedSpecializationId == ($spec->SpecializationId ?? $spec->id)) ? 'selected' : '' }}>
                                            {{ $spec->SpecializationName ?? $spec->name ?? $spec->specialization_name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- 2. Bác sĩ -->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <select class="form-control" name="DoctorId" id="doctorSelect" required>
                                        <option value="">Select Doctors</option>
                                        @foreach($doctors ?? [] as $doc)
                                        <option value="{{ $doc->DoctorId ?? $doc->id }}"
                                            {{ (request('doctor_id') == ($doc->DoctorId ?? $doc->id) || (isset($selectedDoctorId) && $selectedDoctorId == ($doc->DoctorId ?? $doc->id))) ? 'selected' : '' }}>
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
                            <textarea name="Reason" id="Reason" class="form-control" rows="6" placeholder="Your Message / Reason for visit">{{ old('Reason') }}</textarea>
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

@push('scripts')
<script>
    (function() {
        function initAppointmentForm() {
            var $specSelect = $('#specializationSelect');
            var $docSelect = $('#doctorSelect');
            var $timeSelect = $('#timeSlotSelect');
            var $dateInput = $('#date');

            if (!$specSelect.length) return; // Nếu không ở trang booking thì bỏ qua

            // Hàm đồng bộ UI NiceSelect (nếu template có sử dụng)
            function updateNiceSelect() {
                if ($.fn.niceSelect) {
                    $('select').niceSelect('update');
                }
            }

            // Hàm load khung giờ trống
            function loadAvailableSlots() {
                var doctorId = $docSelect.val();
                var date = $dateInput.val();

                if (!doctorId || !date) {
                    $timeSelect.html('<option value="">Select Available Time</option>');
                    updateNiceSelect();
                    return;
                }

                $timeSelect.html('<option value="">Loading time slots...</option>');
                updateNiceSelect();

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
                                $timeSelect.append('<option value="' + slot.AppointmentId + '">' + slot.TimeDisplay + '</option>');
                            });
                        } else {
                            $timeSelect.append('<option value="">No available slots on this date</option>');
                        }
                        updateNiceSelect();
                    },
                    error: function() {
                        $timeSelect.html('<option value="">Error loading slots</option>');
                        updateNiceSelect();
                    }
                });
            }

            // Lắng nghe sự kiện chọn Chuyên khoa
            $(document).off('change', '#specializationSelect').on('change', '#specializationSelect', function() {
                var specId = $(this).val();

                $docSelect.html('<option value="">Loading doctors...</option>');
                $timeSelect.html('<option value="">Select Available Time</option>');
                updateNiceSelect();

                if (!specId) {
                    $docSelect.html('<option value="">Select Doctors</option>');
                    updateNiceSelect();
                    return;
                }

                $.ajax({
                    url: "{{ route('patient.appointments.get-doctors') }}",
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
                        updateNiceSelect();
                    },
                    error: function() {
                        $docSelect.html('<option value="">Error loading doctors</option>');
                        updateNiceSelect();
                    }
                });
            });

            // Lắng nghe sự kiện chọn Bác sĩ / Ngày
            $(document).off('change', '#doctorSelect, #date').on('change', '#doctorSelect, #date', loadAvailableSlots);

            // Tự động kích hoạt nếu đã có Bác sĩ được chọn từ URL
            if ($docSelect.val()) {
                loadAvailableSlots();
            }
        }

        // Chạy khi nạp trang lần đầu hoặc khi SPA Navigation hoàn tất chuyển trang
        $(document).ready(initAppointmentForm);
        $(document).on('pjax:end page:loaded turbolinks:load content:loaded', initAppointmentForm);
    })();
</script>
@endpush

@endsection
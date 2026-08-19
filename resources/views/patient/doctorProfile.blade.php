@extends('components.layouts.partials.frontend')
@section('title', 'Home - MediConnect')

@section('content')

<!-- Banner Tiêu đề -->
<section class="page-title bg-1">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="block text-center">
                    <span class="text-white">Doctor Details</span>
                    <!-- Tên Bác sĩ từ DB -->
                    <h1 class="text-capitalize mb-5 text-lg">{{ $doctor->FullName ?? $doctor->Name ?? 'Doctor Profile' }}</h1>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Thông tin chi tiết Bác sĩ -->
<section class="section doctor-single">
    <div class="container">
        <div class="row">
            <!-- Cột Trái: Ảnh Avatar & Thông tin Liên hệ -->
            <div class="col-lg-4 col-md-6">
                <div class="doctor-img-block">
                    <!-- Avatar từ DB (có fallback ảnh mặc định) -->
                    @php
                    $avatar = ($doctor->AvatarUrl && file_exists(public_path($doctor->AvatarUrl)))
                    ? asset($doctor->AvatarUrl)
                    : (($doctor->Gender == 'Male')
                    ? asset('images/avatars/default_doctor_male.png')
                    : asset('images/avatars/default_doctor_female.png'));
                    @endphp
                    <img src="{{ $avatar }}"
                        alt="{{ $doctor->FullName ?? $doctor->Name }}"
                        class="img-fluid w-100 rounded">

                    <div class="info-block mt-4">
                        <h4 class="mb-1">{{ $doctor->FullName ?? $doctor->Name }}</h4>

                        <!-- Chuyên ngành -->
                        <p class="text-primary font-weight-bold mb-3">
                            {{ $doctor->specialization->SpecializationName ?? $doctor->SpecializationName ?? 'Specialist' }}
                        </p>

                        <!-- Danh sách Thông tin SĐT, Email, Bằng cấp -->
                        <ul class="list-unstyled text-left border-top pt-3">
                            <li class="mb-2">
                                <i class="icofont-ui-call mr-2 text-primary"></i>
                                <strong>Phone:</strong> {{ $doctor->Phone ?? $doctor->PhoneNumber ?? 'Update soon' }}
                            </li>
                            <li class="mb-2">
                                <i class="icofont-ui-email mr-2 text-primary"></i>
                                <strong>Email:</strong> {{ $doctor->Email ?? 'Update soon' }}
                            </li>
                            <li class="mb-2">
                                <i class="icofont-badge mr-2 text-primary"></i>
                                <strong>Degree:</strong> {{ $doctor->Degree ?? $doctor->Qualification ?? 'Medical Doctor' }}
                            </li>
                        </ul>

                        <ul class="list-inline mt-4 doctor-social-links">
                            <li class="list-inline-item"><a href="#!"><i class="icofont-facebook"></i></a></li>
                            <li class="list-inline-item"><a href="#!"><i class="icofont-twitter"></i></a></li>
                            <li class="list-inline-item"><a href="#!"><i class="icofont-skype"></i></a></li>
                            <li class="list-inline-item"><a href="#!"><i class="icofont-linkedin"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Cột Phải: Đoạn Giới thiệu (Bio) & Nút Đặt lịch -->
            <div class="col-lg-8 col-md-6">
                <div class="doctor-details mt-4 mt-lg-0">
                    <h2 class="text-md">Introducing to myself</h2>
                    <div class="divider my-4"></div>

                    <!-- Nội dung Bio / Giới thiệu lấy từ DB -->
                    <div class="doctor-bio text-secondary">
                        @if(!empty($doctor->Bio) || !empty($doctor->Description))
                        {!! nl2br(e($doctor->Bio ?? $doctor->Description)) !!}
                        @else
                        <p>Dr. {{ $doctor->FullName ?? $doctor->Name }} is a highly dedicated specialist in {{ $doctor->specialization->SpecializationName ?? 'healthcare' }} with extensive clinical experience and a deep commitment to providing high-quality patient care.</p>
                        @endif
                    </div>

                    <!-- ================= BẢNG LỊCH LÀM VIỆC (DOCTOR SCHEDULE) ================= -->
                    <div class="schedule-light-container p-3 p-md-4 rounded-lg my-4" style="background-color: #f0f7ff; border: 1px solid #cce3fd; box-shadow: 0 4px 15px rgba(0, 123, 255, 0.06);">

                        <!-- Tiêu đề -->
                        <div class="d-flex align-items-center mb-3">
                            <i class="icofont-wall-clock text-primary mr-2" style="font-size: 20px;"></i>
                            <h5 class="mb-0 text-primary font-weight-bold" style="color: #1e3a8a !important; font-size: 17px;">Weekly Doctor Schedule</h5>
                        </div>

                        <!-- Khung 7 cột -->
                        <div class="d-flex w-100" style="gap: 6px;">
                            @php
                            $daysOfWeek = [
                            'Monday' => 'Mon',
                            'Tuesday' => 'Tue',
                            'Wednesday' => 'Wed',
                            'Thursday' => 'Thu',
                            'Friday' => 'Fri',
                            'Saturday' => 'Sat',
                            'Sunday' => 'Sun'
                            ];

                            $schedulesByDay = $doctor->schedules ? $doctor->schedules->groupBy(function($item) {
                            return $item->DayOfWeek ?? \Carbon\Carbon::parse($item->WorkDate)->format('l');
                            }) : collect();
                            @endphp

                            @foreach($daysOfWeek as $fullDay => $shortDay)
                            @php
                            $daySchedules = $schedulesByDay->get($fullDay, collect());

                            $morning = $daySchedules->first(function($s) {
                            return strtolower($s->Shift ?? '') === 'morning' || (\Carbon\Carbon::parse($s->StartTime)->format('H') < 12);
                                });

                                $afternoon=$daySchedules->first(function($s) {
                                return strtolower($s->Shift ?? '') === 'afternoon' || (\Carbon\Carbon::parse($s->StartTime)->format('H') >= 12);
                                });
                                @endphp

                                <div class="day-column text-center" style="flex: 1; min-width: 0;">
                                    <!-- Tên Thứ  -->
                                    <div class="font-weight-bold py-2 mb-2 rounded text-truncate"
                                        style="background-color: #e0f2fe; color: #0369a1; font-size: 13px;"
                                        title="{{ $fullDay }}">
                                        <span class="d-none d-xl-inline">{{ $fullDay }}</span>
                                        <span class="d-inline d-xl-none">{{ $shortDay }}</span>
                                    </div>

                                    <!-- CA SÁNG (MORNING) -->
                                    <div class="card-shift p-2 mb-2 rounded bg-white border shadow-sm" style="border-color: #bae6fd !important;">
                                        <div class="d-flex align-items-center justify-content-center mb-1">
                                            <i class="icofont-sun text-warning mr-1" style="font-size: 14px;"></i>
                                            <span class="font-weight-bold text-dark" style="font-size: 12px;">Morning</span>
                                        </div>
                                        <div class="text-muted mb-2" style="font-size: 10px; line-height: 1.2;">08:00 - 12:00</div>

                                        @if($morning && !$morning->IsOff && !$morning->IsDayOff)
                                        <span class="badge badge-light-success text-success font-weight-bold px-1 py-1.5 rounded d-block text-truncate" style="background-color: #dcfce7; font-size: 11px;">
                                            Available
                                        </span>
                                        @else
                                        <div class="text-secondary font-weight-bold mb-1" style="font-size: 11px;">Off</div>
                                        <div class="reason-box p-1 rounded text-muted text-truncate" style="background-color: #f8fafc; border: 1px solid #e2e8f0; font-size: 10px; min-height: 28px;" title="{{ $morning->Reason ?? $morning->DayOffReason ?? 'Day off' }}">
                                            {{ $morning->Reason ?? $morning->DayOffReason ?? 'Off' }}
                                        </div>
                                        @endif
                                    </div>

                                    <!-- CA CHIỀU (AFTERNOON) -->
                                    <div class="card-shift p-2 rounded bg-white border shadow-sm" style="border-color: #bae6fd !important;">
                                        <div class="d-flex align-items-center justify-content-center mb-1">
                                            <i class="icofont-cloud-sun text-info mr-1" style="font-size: 14px;"></i>
                                            <span class="font-weight-bold text-dark" style="font-size: 12px;">Afternoon</span>
                                        </div>
                                        <div class="text-muted mb-2" style="font-size: 10px; line-height: 1.2;">13:00 - 17:00</div>

                                        @if($afternoon && !$afternoon->IsOff && !$afternoon->IsDayOff)
                                        <span class="badge badge-light-success text-success font-weight-bold px-1 py-1.5 rounded d-block text-truncate" style="background-color: #dcfce7; font-size: 11px;">
                                            Available
                                        </span>
                                        @else
                                        <div class="text-secondary font-weight-bold mb-1" style="font-size: 11px;">Off</div>
                                        <div class="reason-box p-1 rounded text-muted text-truncate" style="background-color: #f8fafc; border: 1px solid #e2e8f0; font-size: 10px; min-height: 28px;" title="{{ $afternoon->Reason ?? $afternoon->DayOffReason ?? 'Day off' }}">
                                            {{ $afternoon->Reason ?? $afternoon->DayOffReason ?? 'Off' }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                        </div>
                    </div>

                    <!-- Make Appointment -->
                    <div class="d-flex justify-content-end">
                        <a href="{{ url('/appoinment?doctor_id=' . ($doctor->DoctorId ?? $doctor->id)) }}" class="btn btn-main-2 btn-round-full mt-4 ">
                            Make an Appoinment<i class="icofont-simple-right ml-2"></i>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<!-- Bằng cấp & Trình độ học vấn -->
<section class="section doctor-qualification gray-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="section-title">
                    <h3>Educational Qualifications & Degree</h3>
                    <div class="divider my-4"></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="edu-block p-4 bg-white rounded shadow-sm border-left border-primary" style="border-left-width: 5px !important;">
                    <span class="h6 text-muted"><i class="icofont-graduation-cap mr-1 text-primary"></i> Qualification</span>
                    <h4 class="mb-2 mt-1 title-color">{{ $doctor->Degree ?? 'Medical Doctor (M.D.)' }}</h4>
                    <p class="mb-0">
                        {{ $doctor->Qualifications ?? $doctor->Education ?? 'Graduated from prestigious medical institutions with specialized training certificates and years of clinical practice in diagnosis and treatment.' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
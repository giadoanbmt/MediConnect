@extends('components.layouts.partials.frontend')

@section('title', 'Doctor Profile - MediConnect')

@section('content')

<section class="page-title bg-1">
    <div class="overlay"></div>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="block text-center">
                    <span class="text-white">Doctor Details</span>

                    <h1 class="text-capitalize mb-5 text-lg">
                        {{ $doctor->FullName }}
                    </h1>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section doctor-single">

    <div class="container">

        @php
        $avatar = null;

        if (
        !empty($doctor->AvatarUrl) &&
        file_exists(public_path($doctor->AvatarUrl))
        ) {
        $avatar = asset($doctor->AvatarUrl);
        }

        if (!$avatar) {
        $avatar = strtolower($doctor->Gender ?? '') === 'female'
        ? asset('images/avatars/default_doctor_female.png')
        : asset('images/avatars/default_doctor_male.png');
        }

        $specialization = $doctor->specialization;
        $room = $doctor->room;
        $city = $doctor->city;

        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();

        $weeklySchedules = $doctor->schedules
        ? $doctor->schedules
        ->filter(function ($schedule) use ($startOfWeek, $endOfWeek) {
        $date = \Carbon\Carbon::parse($schedule->WorkDate);

        return $date->between(
        $startOfWeek,
        $endOfWeek
        );
        })
        ->sortBy(function ($schedule) {
        return $schedule->WorkDate . ' ' . $schedule->StartTime;
        })
        : collect();

        $schedulesByDate = $weeklySchedules->groupBy(function ($schedule) {
        return \Carbon\Carbon::parse(
        $schedule->WorkDate
        )->format('Y-m-d');
        });
        @endphp

        <div class="row">

            {{-- Doctor information --}}
            <div class="col-lg-4 col-md-5">

                <div class="doctor-img-block">

                    <img
                        src="{{ $avatar }}"
                        alt="{{ $doctor->FullName }}"
                        class="img-fluid w-100 rounded">

                    <div class="info-block mt-4">

                        <h4 class="mb-1">
                            {{ $doctor->FullName }}
                        </h4>

                        @if($specialization)
                        <p class="text-primary font-weight-bold mb-3">
                            {{ $specialization->SpecializationName }}
                        </p>
                        @endif

                        <ul class="list-unstyled text-left border-top pt-3">

                            @if($doctor->PhoneNumber)
                            <li class="mb-3">
                                <i class="icofont-ui-call mr-2 text-primary"></i>
                                <strong>Phone:</strong>
                                {{ $doctor->PhoneNumber }}
                            </li>
                            @endif

                            @if($doctor->Email)
                            <li class="mb-3">
                                <i class="icofont-ui-email mr-2 text-primary"></i>
                                <strong>Email:</strong>
                                {{ $doctor->Email }}
                            </li>
                            @endif

                            @if($doctor->Qualifications)
                            <li class="mb-3">
                                <i class="icofont-graduation-cap mr-2 text-primary"></i>
                                <strong>Qualification:</strong>
                                {{ $doctor->Qualifications }}
                            </li>
                            @endif

                            @if($room)
                            <li class="mb-3">
                                <i class="icofont-hospital mr-2 text-primary"></i>
                                <strong>Clinic:</strong>
                                {{ $room->RoomName }}

                                @if($room->RoomNumber)
                                - Room {{ $room->RoomNumber }}
                                @endif
                            </li>
                            @endif

                            @if($room && $room->LocationFloor)
                            <li class="mb-3">
                                <i class="icofont-building mr-2 text-primary"></i>
                                <strong>Floor:</strong>
                                {{ $room->LocationFloor }}
                            </li>
                            @endif

                            @if($city)
                            <li class="mb-3">
                                <i class="icofont-location-pin mr-2 text-primary"></i>
                                <strong>Location:</strong>

                                @if($city->DistrictName)
                                {{ $city->DistrictName }},
                                @endif

                                {{ $city->CityName }}
                            </li>
                            @endif

                            @if($doctor->Address)
                            <li class="mb-3">
                                <i class="icofont-map-pins mr-2 text-primary"></i>
                                <strong>Address:</strong>
                                {{ $doctor->Address }}
                            </li>
                            @endif

                        </ul>

                    </div>

                </div>

            </div>

            {{-- Doctor details --}}
            <div class="col-lg-8 col-md-7">

                <div class="doctor-details mt-4 mt-lg-0">


                    {{-- Weekly Doctor Schedule --}}
                    <div
                        class="schedule-light-container p-3 p-md-4 rounded-lg my-4"
                        style="
                            background-color: #f0f7ff;
                            border: 1px solid #cce3fd;
                            box-shadow: 0 4px 15px rgba(0,123,255,.06);
                        ">

                        <!-- BẢNG LỊCH LÀM VIỆC (DOCTOR SCHEDULE) -->
                        <div class="schedule-light-container p-3 p-md-4 rounded-lg my-4" style="background-color: #f0f7ff; border: 1px solid #cce3fd; box-shadow: 0 4px 15px rgba(0, 123, 255, 0.06);">

                            <!-- Tiêu đề -->
                            <div class="d-flex align-items-center mb-3">

                                <i
                                    class="icofont-wall-clock text-primary mr-2"
                                    style="font-size: 20px;"></i>

                                <h5
                                    class="mb-0 font-weight-bold"
                                    style="
                                    color: #1e3a8a;
                                    font-size: 17px;
                                ">
                                    Weekly Doctor Schedule
                                </h5>

                            </div>


                            {{-- 7 days --}}
                            <div
                                class="weekly-doctor-schedule"
                                style="
                                display: grid;
                                grid-template-columns: repeat(7, minmax(0, 1fr));
                                gap: 6px;
                            ">

                                @for($dayIndex = 0; $dayIndex < 7; $dayIndex++)

                                    @php
                                    $date=$startOfWeek
                                    ->copy()
                                    ->addDays($dayIndex);

                                    $dateKey = $date->format('Y-m-d');

                                    $daySchedules = $schedulesByDate->get(
                                    $dateKey,
                                    collect()
                                    );

                                    $morningSchedules = $daySchedules->filter(function ($schedule) {
                                    return \Carbon\Carbon::parse(
                                    $schedule->StartTime
                                    )->format('H:i') < '12:00' ;
                                        });

                                        $afternoonSchedules=$daySchedules->filter(function ($schedule) {
                                        return \Carbon\Carbon::parse(
                                        $schedule->StartTime
                                        )->format('H:i') >= '12:00';
                                        });
                                        @endphp


                                        {{-- DAY --}}
                                        <div style="min-width: 0;">

                                            {{-- Day header --}}
                                            <div
                                                class="font-weight-bold py-2 mb-2 rounded text-center"
                                                style="
                                            background-color: #e0f2fe;
                                            color: #0369a1;
                                            font-size: 12px;
                                        ">

                                                {{ $date->format('l') }}

                                                <div
                                                    class="font-weight-normal mt-1"
                                                    style="
                                                font-size: 10px;
                                                color: #64748b;
                                            ">
                                                    {{ $date->format('d/m/Y') }}
                                                </div>

                                            </div>


                                            {{-- MORNING --}}
                                            <div
                                                class="p-2 mb-2 rounded bg-white border shadow-sm"
                                                style="
                                            border-color: #bae6fd !important;
                                        ">

                                                <div
                                                    class="d-flex align-items-center mb-2">

                                                    <i
                                                        class="icofont-sun text-warning mr-1"
                                                        style="font-size: 13px;"></i>

                                                    <span
                                                        class="font-weight-bold text-dark"
                                                        style="font-size: 12px;">
                                                        Morning
                                                    </span>

                                                </div>


                                                @forelse($morningSchedules as $schedule)

                                                @php
                                                $status = $schedule->Status;

                                                $startTime = \Carbon\Carbon::parse(
                                                $schedule->StartTime
                                                )->format('H:i');

                                                $endTime = \Carbon\Carbon::parse(
                                                $schedule->EndTime
                                                )->format('H:i');

                                                if ($status === 'Off') {

                                                $displayStatus = 'Off';
                                                $statusColor = '#64748b';
                                                $backgroundColor = '#f8fafc';
                                                $borderColor = '#cbd5e1';

                                                } elseif ((int) $schedule->IsBooked === 1) {

                                                $displayStatus = 'Booked';
                                                $statusColor = '#dc2626';
                                                $backgroundColor = '#fef2f2';
                                                $borderColor = '#fecaca';

                                                } else {

                                                $displayStatus = 'Available';
                                                $statusColor = '#16a34a';
                                                $backgroundColor = '#f0fdf4';
                                                $borderColor = '#bbf7d0';

                                                }
                                                @endphp


                                                {{-- EACH MORNING SLOT --}}
                                                <div
                                                    class="schedule-slot"
                                                    style="
                                                    margin-bottom: 8px;
                                                    padding: 8px;
                                                    border: 1px solid {{ $borderColor }};
                                                    border-radius: 6px;
                                                    background-color: {{ $backgroundColor }};
                                                ">

                                                    <div
                                                        style="
                                                        font-size: 10px;
                                                        color: #475569;
                                                        white-space: nowrap;
                                                    ">
                                                        <i
                                                            class="icofont-circle"
                                                            style="
                                                            font-size: 7px;
                                                            color: #0088cc;
                                                        "></i>

                                                        {{ $startTime }}
                                                        -
                                                        {{ $endTime }}
                                                    </div>

                                                    <div
                                                        class="mt-1 font-weight-bold"
                                                        style="
                                                        font-size: 10px;
                                                        color: {{ $statusColor }};
                                                    ">
                                                        {{ $displayStatus }}
                                                    </div>

                                                </div>

                                                @empty

                                                <div
                                                    class="text-muted"
                                                    style="font-size: 10px;">
                                                    No schedule
                                                </div>

                                                @endforelse

                                            </div>


                                            {{-- AFTERNOON --}}
                                            <div
                                                class="p-2 rounded bg-white border shadow-sm"
                                                style="
                                            border-color: #bae6fd !important;
                                        ">

                                                <div
                                                    class="d-flex align-items-center mb-2">

                                                    <i
                                                        class="icofont-cloud-sun text-info mr-1"
                                                        style="font-size: 13px;"></i>

                                                    <span
                                                        class="font-weight-bold text-dark"
                                                        style="font-size: 12px;">
                                                        Afternoon
                                                    </span>

                                                </div>


                                                @forelse($afternoonSchedules as $schedule)

                                                @php
                                                $status = $schedule->Status;

                                                $startTime = \Carbon\Carbon::parse(
                                                $schedule->StartTime
                                                )->format('H:i');

                                                $endTime = \Carbon\Carbon::parse(
                                                $schedule->EndTime
                                                )->format('H:i');

                                                if ($status === 'Off') {

                                                $displayStatus = 'Off';
                                                $statusColor = '#64748b';
                                                $backgroundColor = '#f8fafc';
                                                $borderColor = '#cbd5e1';

                                                } elseif ((int) $schedule->IsBooked === 1) {

                                                $displayStatus = 'Booked';
                                                $statusColor = '#dc2626';
                                                $backgroundColor = '#fef2f2';
                                                $borderColor = '#fecaca';

                                                } else {

                                                $displayStatus = 'Available';
                                                $statusColor = '#16a34a';
                                                $backgroundColor = '#f0fdf4';
                                                $borderColor = '#bbf7d0';

                                                }
                                                @endphp


                                                {{-- EACH AFTERNOON SLOT --}}
                                                <div
                                                    class="schedule-slot"
                                                    style="
                                                    margin-bottom: 8px;
                                                    padding: 8px;
                                                    border: 1px solid {{ $borderColor }};
                                                    border-radius: 6px;
                                                    background-color: {{ $backgroundColor }};
                                                ">

                                                    <div
                                                        style="
                                                        font-size: 10px;
                                                        color: #475569;
                                                        white-space: nowrap;
                                                    ">
                                                        <i
                                                            class="icofont-circle"
                                                            style="
                                                            font-size: 7px;
                                                            color: #0088cc;
                                                        "></i>

                                                        {{ $startTime }}
                                                        -
                                                        {{ $endTime }}
                                                    </div>

                                                    <div
                                                        class="mt-1 font-weight-bold"
                                                        style="
                                                        font-size: 10px;
                                                        color: {{ $statusColor }};
                                                    ">
                                                        {{ $displayStatus }}
                                                    </div>

                                                </div>

                                                @empty

                                                <div
                                                    class="text-muted"
                                                    style="font-size: 10px;">
                                                    No schedule
                                                </div>

                                                @endforelse

                                            </div>

                                        </div>

                                        @endfor

                            </div>


                            {{-- Legend --}}
                            <div
                                class="mt-3 pt-3"
                                style="
                                border-top: 1px solid #cce3fd;
                            ">

                                <div
                                    class="d-flex flex-wrap align-items-center"
                                    style="gap: 15px;">

                                    <div
                                        class="d-flex align-items-center"
                                        style="font-size: 11px;">
                                        <span
                                            style="
                                            width: 10px;
                                            height: 10px;
                                            border-radius: 3px;
                                            background: #f0fdf4;
                                            border: 1px solid #bbf7d0;
                                            margin-right: 5px;
                                        "></span>

                                        Available
                                    </div>


                                    <div
                                        class="d-flex align-items-center"
                                        style="font-size: 11px;">
                                        <span
                                            style="
                                            width: 10px;
                                            height: 10px;
                                            border-radius: 3px;
                                            background: #fef2f2;
                                            border: 1px solid #fecaca;
                                            margin-right: 5px;
                                        "></span>

                                        Booked
                                    </div>


                                    <div
                                        class="d-flex align-items-center"
                                        style="font-size: 11px;">
                                        <span
                                            style="
                                            width: 10px;
                                            height: 10px;
                                            border-radius: 3px;
                                            background: #f8fafc;
                                            border: 1px solid #cbd5e1;
                                            margin-right: 5px;
                                        "></span>

                                        Off
                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- Appointment --}}
                        <div class="d-flex justify-content-end">
                            <<<<<<< Updated upstream

                                <a
                                href="{{ route('patient.appointments.book', ['doctor_id' => $doctor->DoctorId]) }}"
                                class="btn btn-main-2 btn-round-full mt-4">
                                Make an Appointment
                                <i class="icofont-simple-right ml-2"></i>
                                </a>

                                =======
                                @auth
                                <a href="{{ route('patient.appointments.book', ['doctor_id' => $doctor->DoctorId ?? $doctor->id]) }}" class="btn btn-main-2 btn-round-full mt-4 ">
                                    Make an Appoinment<i class="icofont-simple-right ml-2"></i>
                                </a>
                                @else
                                <a href="{{ url('/login') }}" class="btn btn-main-2 btn-icon btn-round-full">
                                    Make an appointment<i class="icofont-simple-right ml-2"></i>
                                </a>
                                @endauth
                                >>>>>>> Stashed changes
                        </div>

                    </div>

                </div>

            </div>

        </div>

</section>

@endsection
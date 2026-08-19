<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'MediConnect - Doctor')</title>

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        :root {
            --primary-blue: #223a66;
            --accent-blue: #0088cc;
            --doctor-bg: #f4f7f6;
            --doctor-text: #172a45;
            --doctor-card: #ffffff;
            --doctor-border: #e5eaf0;
            --doctor-muted: #7d8da3;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            min-height: 100%;
        }

        body {
            background: var(--doctor-bg);
            color: var(--doctor-text);
            font-family: Arial, sans-serif;
            transition: background-color .2s ease, color .2s ease;
        }

        .doctor-sidebar {
            width: 235px;
            min-height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            background: linear-gradient(
                180deg,
                #203861 0%,
                #162947 100%
            );
            color: white;
        }

        .doctor-brand {
            padding: 22px 20px 18px;
            border-bottom: 1px solid rgba(255,255,255,.12);
        }

        .doctor-brand h4 {
            margin: 0;
            font-size: 22px;
            font-weight: 700;
        }

        .doctor-brand small {
            display: block;
            margin-top: 5px;
            color: #aabbd1;
        }

        .doctor-profile-box {
            padding: 22px 10px;
            text-align: center;
        }

        .doctor-profile-box img {
            width: 75px;
            height: 75px;
            object-fit: cover;
            display: block;
            margin: 0 auto;
            border-radius: 50%;
            border: 3px solid #0088cc;
        }

        .doctor-profile-box h6 {
            margin: 10px 0 2px;
            color: white;
            font-weight: 700;
        }

        .doctor-profile-box small {
            color: #aabbd1;
        }

        .doctor-menu {
            margin-top: 5px;
        }

        .doctor-menu a {
            display: flex;
            align-items: center;
            min-height: 45px;
            padding: 0 20px;
            color: #c1d0e3;
            text-decoration: none;
            border-left: 4px solid transparent;
            transition: .2s;
        }

        .doctor-menu a i {
            width: 25px;
            margin-right: 5px;
            font-size: 14px;
        }

        .doctor-menu a:hover {
            color: white;
            background: rgba(0,136,204,.25);
            text-decoration: none;
        }

        .doctor-menu a.active {
            color: white;
            background: #0088cc;
            border-left-color: white;
        }

        .logout-form {
            margin: 25px 0 0;
            padding: 0;
        }

        .doctor-menu .logout {
            display: flex;
            align-items: center;
            width: 100%;
            min-height: 45px;
            padding: 0 20px;
            border: none;
            border-left: 4px solid transparent;
            outline: none;
            background: transparent;
            color: #ff4050;
            font-family: Arial, sans-serif;
            font-size: 16px;
            text-align: left;
            cursor: pointer;
            transition: .2s;
        }

        .doctor-menu .logout i {
            width: 25px;
            margin-right: 5px;
            font-size: 14px;
        }

        .doctor-menu .logout:hover {
            color: #ff4050;
            background: rgba(255,64,80,.1);
            border-left-color: #ff4050;
        }

        .doctor-main {
            margin-left: 235px;
            min-height: 100vh;
            background: var(--doctor-bg);
        }

        .doctor-navbar {
            height: 57px;
            padding: 0 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #223f72;
            color: white;
            position: relative;
            z-index: 1100;
        }

        .doctor-navbar-title {
            font-size: 18px;
            font-weight: 700;
        }

        .doctor-content {
            padding: 30px;
            min-height: calc(100vh - 57px);
            background: var(--doctor-bg);
        }

        .notification-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            z-index: 2000;
        }

        .notification-button {
            position: relative;
            width: 38px;
            height: 38px;
            padding: 0;
            border: none;
            outline: none;
            background: transparent;
            color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .notification-button:hover {
            color: #dcecff;
        }

        .notification-button:focus {
            outline: none;
        }

        .notification-button i {
            font-size: 16px;
        }

        .notification-badge {
            position: absolute;
            top: 0;
            right: 0;
            min-width: 17px;
            height: 17px;
            padding: 0 4px;
            border-radius: 20px;
            background: #ff4050;
            color: white;
            font-size: 10px;
            font-weight: 700;
            line-height: 17px;
            text-align: center;
        }

        .notification-dropdown {
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            left: auto;
            width: 360px;
            max-width: calc(100vw - 30px);
            max-height: 500px;
            padding: 0;
            margin: 0;
            background: var(--doctor-card);
            border: 1px solid var(--doctor-border);
            border-radius: 8px;
            box-shadow: 0 10px 30px rgba(0,0,0,.35);
            overflow: hidden;
            display: none;
            z-index: 99999;
        }

        .notification-dropdown.show {
            display: block;
        }

        .notification-header {
            width: 100%;
            height: 52px;
            padding: 0 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: var(--doctor-card);
            border-bottom: 1px solid var(--doctor-border);
            color: var(--doctor-text);
        }

        .notification-header strong {
            font-size: 15px;
            font-weight: 700;
        }

        .notification-settings {
            border: none;
            padding: 5px;
            background: transparent;
            color: var(--doctor-muted);
            cursor: pointer;
        }

        .notification-settings:hover {
            color: var(--accent-blue);
        }

        .notification-list {
            width: 100%;
            max-height: 390px;
            padding: 0;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .notification-item {
            width: 100%;
            min-height: 78px;
            margin: 0;
            padding: 12px 15px;
            display: flex;
            align-items: flex-start;
            gap: 11px;
            background: transparent;
            color: var(--doctor-text) !important;
            text-decoration: none !important;
            border-bottom: 1px solid var(--doctor-border);
        }

        .notification-item:hover {
            background: rgba(0,136,204,.08);
            color: var(--doctor-text) !important;
            text-decoration: none !important;
        }

        .notification-icon {
            width: 36px;
            height: 36px;
            min-width: 36px;
            flex-shrink: 0;
            margin-top: 1px;
            border-radius: 50%;
            background: rgba(0,136,204,.12);
            color: var(--accent-blue);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .notification-content {
            min-width: 0;
            flex: 1;
            width: auto;
            overflow: hidden;
        }

        .notification-content strong {
            display: block;
            margin: 0 0 4px;
            padding: 0;
            color: var(--doctor-text);
            font-size: 13px;
            font-weight: 700;
            line-height: 1.3;
        }

        .notification-content span {
            display: block;
            margin: 0;
            padding: 0;
            color: var(--doctor-muted);
            font-size: 12px;
            line-height: 1.45;
            white-space: normal;
            overflow-wrap: anywhere;
        }

        .notification-content .notification-appointment {
            display: block;
            margin-top: 5px;
            color: var(--accent-blue);
            font-size: 11px;
            line-height: 1.3;
        }

        .notification-content small {
            display: block;
            margin: 5px 0 0;
            padding: 0;
            color: var(--doctor-muted);
            font-size: 10px;
            line-height: 1.3;
        }

        .notification-empty {
            width: 100%;
            min-height: 120px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 8px;
            color: var(--doctor-muted);
            font-size: 13px;
        }

        .notification-empty i {
            font-size: 22px;
            color: var(--accent-blue);
        }

        .notification-footer {
            width: 100%;
            padding: 11px;
            margin: 0;
            text-align: center;
            border-top: 1px solid var(--doctor-border);
        }

        .notification-footer a {
            color: var(--accent-blue) !important;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none !important;
        }

        .notification-footer a:hover {
            text-decoration: underline !important;
        }

        @media (prefers-color-scheme: dark) {
            :root {
                --doctor-bg: #0f1724;
                --doctor-text: #e8edf5;
                --doctor-card: #172235;
                --doctor-border: #2a3950;
                --doctor-muted: #9aa8bb;
            }

            body {
                background: var(--doctor-bg);
                color: var(--doctor-text);
            }

            .doctor-main,
            .doctor-content {
                background: var(--doctor-bg);
            }

            .card {
                background-color: var(--doctor-card);
                border-color: var(--doctor-border);
                color: var(--doctor-text);
            }

            .table {
                color: var(--doctor-text);
            }

            .table thead,
            .thead-light {
                background-color: #1d2a3d !important;
                color: #e8edf5;
            }

            .table td,
            .table th {
                border-color: var(--doctor-border);
            }

            .table-hover tbody tr:hover {
                color: var(--doctor-text);
                background-color: #1d2a3d;
            }

            .text-dark {
                color: #e8edf5 !important;
            }

            .text-muted {
                color: #9aa8bb !important;
            }

            .bg-white {
                background-color: var(--doctor-card) !important;
            }

            .alert-success {
                background-color: #173c2b;
                border-color: #246044;
                color: #b9f1d0;
            }

            .alert-danger {
                background-color: #451f25;
                border-color: #71323b;
                color: #ffc5ca;
            }

            input,
            textarea,
            select {
                background-color: #172235 !important;
                color: #e8edf5 !important;
                border-color: #34445b !important;
            }

            input::placeholder,
            textarea::placeholder {
                color: #8290a3 !important;
            }
        }

        @media (max-width: 768px) {
            .doctor-sidebar {
                width: 200px;
            }

            .doctor-main {
                margin-left: 200px;
            }

            .doctor-content {
                padding: 20px;
            }
        }

        @media (max-width: 500px) {
            .notification-dropdown {
                position: fixed;
                top: 65px;
                right: 10px;
                left: 10px;
                width: auto;
                max-width: none;
            }
        }
    </style>

    @stack('style')
</head>

<body>

@php
    $sidebarDoctor = \App\Models\Doctor::with('specialization')
        ->find(session('doctor_id'));

    $sidebarGender = strtolower(
        trim((string) ($sidebarDoctor->Gender ?? ''))
    );

    $sidebarAvatarPath = trim(
        (string) ($sidebarDoctor->AvatarUrl ?? '')
    );

    if ($sidebarAvatarPath !== '') {

        $sidebarAvatar = asset(
            ltrim($sidebarAvatarPath, '/')
        );

    } elseif ($sidebarGender === 'female') {

        $sidebarAvatar = asset(
            'images/avatars/default_female.png'
        );

    } else {

        $sidebarAvatar = asset(
            'images/avatars/default_male.png'
        );
    }

    $notifications = \App\Models\Appointment::with('accountUser')
    ->where(
        'DoctorId',
        $sidebarDoctor?->DoctorId
    )
    ->orderByDesc('UpdatedAt')
    ->limit(8)
    ->get();

$notificationReadAt = session(
    'doctor_notifications_read_at'
);

if ($notificationReadAt) {

    $notificationCount = \App\Models\Appointment::where(
        'DoctorId',
        $sidebarDoctor?->DoctorId
    )
        ->where(
            'UpdatedAt',
            '>',
            $notificationReadAt
        )
        ->count();

} else {

    $notificationCount = \App\Models\Appointment::where(
        'DoctorId',
        $sidebarDoctor?->DoctorId
    )
        ->count();
}

if ($notificationReadAt) {

    $notificationCount = \App\Models\Appointment::where(
        'DoctorId',
        $sidebarDoctor?->DoctorId
    )
        ->where(
            'UpdatedAt',
            '>',
            $notificationReadAt
        )
        ->count();

} else {

    $notificationCount = \App\Models\Appointment::where(
        'DoctorId',
        $sidebarDoctor?->DoctorId
    )->count();
}
@endphp
<div class="doctor-sidebar">

    <div class="doctor-brand">

        <h4>
            MediConnect
        </h4>

        <small>
            Doctor portal
        </small>

    </div>

  <div class="doctor-profile-box">

    <img
        src="{{ $sidebarAvatar }}"
        alt="Avatar"
        onerror="this.onerror=null;this.src='{{ $sidebarGender === 'female'
            ? asset('images/avatars/default_doctor_female.png')
            : asset('images/avatars/default_doctor_male.png') }}';"
    >

    <h6>
        {{ $sidebarDoctor->FullName ?? 'Doctor' }}
    </h6>

    <small>
        {{ $sidebarDoctor?->specialization?->SpecializationName ?? 'Doctor' }}
    </small>

</div>

    <div class="doctor-menu">

        <a
            href="{{ url('/doctor/dashboard') }}"
            class="{{ request()->is('doctor/dashboard') ? 'active' : '' }}"
        >
            <i class="fas fa-th-large"></i>
            <span>Dashboard</span>
        </a>

        <a
            href="{{ url('/doctor/profile') }}"
            class="{{ request()->is('doctor/profile') ? 'active' : '' }}"
        >
            <i class="fas fa-user-md"></i>
            <span>Profile</span>
        </a>

        <a
            href="{{ url('/doctor/news') }}"
            class="{{ request()->is('doctor/news*') ? 'active' : '' }}"
        >
            <i class="fas fa-newspaper"></i>
            <span>News</span>
        </a>

        <a
            href="{{ url('/doctor/availability') }}"
            class="{{ request()->is('doctor/availability*') ? 'active' : '' }}"
        >
            <i class="fas fa-calendar-alt"></i>
            <span>Availability</span>
        </a>

        <a
            href="{{ url('/doctor/appointments') }}"
            class="{{ request()->is('doctor/appointments*') ? 'active' : '' }}"
        >
            <i class="fas fa-calendar-check"></i>
            <span>Appointments</span>
        </a>

        <form
            action="{{ route('logout') }}"
            method="POST"
            class="logout-form"
        >
            @csrf

            <button
                type="submit"
                class="logout"
            >
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </button>

        </form>

    </div>

</div>

<div class="doctor-main">

    <div class="doctor-navbar">

        <div class="doctor-navbar-title">

            <i class="fas fa-home mr-2"></i>

            Welcome back, Doctor! 👋

        </div>

        <div class="notification-wrapper">

            <button
                type="button"
                class="notification-button"
                id="notificationButton"
            >

                <i class="fas fa-bell"></i>

                @if($notificationCount > 0)

                    <span class="notification-badge">
                        {{ $notificationCount > 9 ? '9+' : $notificationCount }}
                    </span>

                @endif

            </button>

            <div
                class="notification-dropdown"
                id="notificationDropdown"
            >

                <div class="notification-header">

                    <strong>
                        Notifications
                    </strong>

                    <button
                        type="button"
                        class="notification-settings"
                    >
                        <i class="fas fa-cog"></i>
                    </button>

                </div>

                <div class="notification-list">

                    @forelse($notifications as $notification)

                        @php

                            $patient =
                                $notification->accountUser;

                            $appointmentStatus =
                                strtolower(
                                    trim(
                                        (string)
                                        $notification->Status
                                    )
                                );

                            if (
                                in_array(
                                    $appointmentStatus,
                                    [
                                        'cancelled',
                                        'cancelled_by_doctor',
                                        'cancelled_by_patient'
                                    ],
                                    true
                                )
                            ) {

                                $notificationTitle =
                                    'Appointment cancelled';

                                $notificationMessage =
                                    ($patient->FullName ?? 'A patient')
                                    . ' cancelled an appointment.';

                                $notificationIcon =
                                    'fas fa-calendar-times';

                            } elseif (
                                $appointmentStatus === 'confirmed'
                            ) {

                                $notificationTitle =
                                    'Appointment confirmed';

                                $notificationMessage =
                                    ($patient->FullName ?? 'A patient')
                                    . '\'s appointment has been confirmed.';

                                $notificationIcon =
                                    'fas fa-calendar-check';

                            } elseif (
                                $appointmentStatus === 'completed'
                            ) {

                                $notificationTitle =
                                    'Appointment completed';

                                $notificationMessage =
                                    'Appointment with '
                                    . ($patient->FullName ?? 'a patient')
                                    . ' has been completed.';

                                $notificationIcon =
                                    'fas fa-check-circle';

                            } else {

                                $notificationTitle =
                                    'New appointment';

                                $notificationMessage =
                                    ($patient->FullName ?? 'A patient')
                                    . ' booked an appointment.';

                                $notificationIcon =
                                    'fas fa-calendar-plus';

                            }

                            $notificationTime =
                                $notification->UpdatedAt
                                ?? $notification->CreatedAt;

                        @endphp

                        <a
                            href="{{ route('doctor.appointments') }}"
                            class="notification-item"
                        >

                            <div class="notification-icon">

                                <i class="{{ $notificationIcon }}"></i>

                            </div>

                            <div class="notification-content">

                                <strong>
                                    {{ $notificationTitle }}
                                </strong>

                                <span>
                                    {{ $notificationMessage }}
                                </span>

                                <span class="notification-appointment">

                                    <i class="far fa-calendar-alt"></i>

                                    {{ \Carbon\Carbon::parse(
                                        $notification->AppointmentDate
                                    )->format('d/m/Y') }}

                                    <i class="far fa-clock ml-2"></i>

                                    {{ \Carbon\Carbon::parse(
                                        $notification->StartTime
                                    )->format('H:i') }}

                                </span>

                                @if($notificationTime)

                                    <small>
                                        {{ \Carbon\Carbon::parse(
                                            $notificationTime
                                        )->diffForHumans() }}
                                    </small>

                                @endif

                            </div>

                        </a>

                    @empty

                        <div class="notification-empty">

                            <i class="far fa-bell-slash"></i>

                            <span>
                                No notifications
                            </span>

                        </div>

                    @endforelse

                </div>

                <div class="notification-footer">

                    <a
                        href="{{ route('doctor.appointments') }}"
                    >
                        View all appointments
                    </a>

                </div>

            </div>

        </div>

    </div>

    <main class="doctor-content">

        @yield('content')

    </main>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const notificationButton =
        document.getElementById(
            'notificationButton'
        );

    const notificationDropdown =
        document.getElementById(
            'notificationDropdown'
        );

    if (
        !notificationButton ||
        !notificationDropdown
    ) {
        return;
    }

    notificationButton.addEventListener(
        'click',
        function (event) {

            event.preventDefault();

            event.stopPropagation();

            notificationDropdown.classList.toggle(
                'show'
            );

            const badge =
                document.querySelector(
                    '.notification-badge'
                );

            fetch(
                '{{ route('doctor.notifications.read') }}',
                {
                    method: 'POST',

                    headers: {
                        'X-CSRF-TOKEN':
                            document
                                .querySelector(
                                    'meta[name="csrf-token"]'
                                )
                                .getAttribute(
                                    'content'
                                ),

                        'Accept':
                            'application/json'
                    }
                }
            )
            .then(function (response) {

                if (!response.ok) {
                    throw new Error(
                        'Failed to mark notifications as read.'
                    );
                }

                return response.json();

            })
            .then(function (data) {

                if (
                    data.success &&
                    badge
                ) {

                    badge.remove();

                }

            })
            .catch(function (error) {

                console.error(
                    'Notification error:',
                    error
                );

            });

        }
    );

    notificationDropdown.addEventListener(
        'click',
        function (event) {

            event.stopPropagation();

        }
    );

    document.addEventListener(
        'click',
        function () {

            notificationDropdown.classList.remove(
                'show'
            );

        }
    );

    document.addEventListener(
        'keydown',
        function (event) {

            if (event.key === 'Escape') {

                notificationDropdown.classList.remove(
                    'show'
                );

            }

        }
    );

});
</script>

@stack('scripts')

</body>
</html>
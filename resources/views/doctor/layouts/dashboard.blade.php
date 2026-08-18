<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
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
            background: linear-gradient(180deg,
                    #203861 0%,
                    #162947 100%);
            color: white;
        }

        .doctor-brand {
            padding: 22px 20px 18px;
            border-bottom: 1px solid rgba(255, 255, 255, .12);
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
            background: rgba(0, 136, 204, .25);
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
            background: rgba(255, 64, 80, .1);
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

        @media (prefers-color-scheme: dark) {
            :root {
                --doctor-bg: #0f1724;
                --doctor-text: #e8edf5;
                --doctor-card: #172235;
                --doctor-border: #2a3950;
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

    $sidebarAvatar = null;

    if ($sidebarAvatarPath !== '') {
    $sidebarAvatarFile = ltrim(
    $sidebarAvatarPath,
    '/'
    );

    if (file_exists(
    public_path($sidebarAvatarFile)
    )) {
    $sidebarAvatar = asset(
    $sidebarAvatarFile
    );
    }
    }

    if (!$sidebarAvatar) {
    if ($sidebarGender === 'female') {
    $sidebarAvatar = asset(
    'images/avatars/default_doctor_female.png'
    );
    } else {
    $sidebarAvatar = asset(
    'images/avatars/default_doctor_male.png'
    );
    }
    }
    @endphp

    <div class="doctor-sidebar">

        <div class="doctor-brand">
            <h4>MediConnect</h4>
            <small>Doctor portal</small>
        </div>

        <div class="doctor-profile-box">

            <img
                src="{{ $sidebarAvatar }}"
                alt="Avatar"
                onerror="this.onerror=null;this.src='{{ asset('images/avatars/default_doctor_male.png') }}';">

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
                class="{{ request()->is('doctor/dashboard') ? 'active' : '' }}">
                <i class="fas fa-th-large"></i>
                <span>Dashboard</span>
            </a>

            <a
                href="{{ url('/doctor/profile') }}"
                class="{{ request()->is('doctor/profile') ? 'active' : '' }}">
                <i class="fas fa-user-md"></i>
                <span>Profile</span>
            </a>

            <a
                href="{{ url('/doctor/news') }}"
                class="{{ request()->is('doctor/news*') ? 'active' : '' }}">
                <i class="fas fa-newspaper"></i>
                <span>News</span>
            </a>

            <a
                href="{{ url('/doctor/availability') }}"
                class="{{ request()->is('doctor/availability*') ? 'active' : '' }}">
                <i class="fas fa-calendar-alt"></i>
                <span>Availability</span>
            </a>

            <a
                href="{{ url('/doctor/appointments') }}"
                class="{{ request()->is('doctor/appointments*') ? 'active' : '' }}">
                <i class="fas fa-calendar-check"></i>
                <span>Appointments</span>
            </a>

            <form
                action="{{ route('logout') }}"
                method="POST"
                class="logout-form">
                @csrf

                <button
                    type="submit"
                    class="logout">
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

            <i class="fas fa-bell"></i>

        </div>

        <main class="doctor-content">
            @yield('content')
        </main>

    </div>

    @stack('scripts')

</body>

</html>
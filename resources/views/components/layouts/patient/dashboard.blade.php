<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Patient Dashboard - MediConnect')</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        :root {
            --primary-blue: #223a66;
            --accent-blue: #0088cc;
            --bg-light: #f4f7f6;
        }

        body {
            background-color: var(--bg-light);
            font-family: 'Roboto', sans-serif;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 260px;
            min-height: 100vh;
            background: linear-gradient(180deg, #1e3258 0%, #15233e 100%);
            color: #fff;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
        }

        .sidebar .brand-logo {
            padding: 20px 15px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar .profile-box {
            padding: 20px 10px;
            text-align: center;
        }

        .sidebar .profile-box img {
            width: 75px;
            height: 75px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--accent-blue);
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 12px 25px;
            color: #b0c4de;
            text-decoration: none;
            transition: all 0.3s;
            width: 100%;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            color: #ffffff;
            background-color: var(--accent-blue);
            border-left: 4px solid #ffffff;
        }

        .sidebar-menu i {
            width: 25px;
        }

        /* Main Content Styling */
        .main-wrapper {
            margin-left: 260px;
        }

        .top-navbar {
            background-color: var(--primary-blue);
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .content-body {
            padding: 30px;
        }

        .stat-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
        }
    </style>
    @stack('styles')
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="brand-logo">
            <a href="{{ url('/') }}" class="text-white text-decoration-none">
                <h4 class="font-weight-bold mb-0">MediConnect</h4>
            </a>
        </div>

        <!-- Patient Avatar & Info -->
        <div class="profile-box">
            @php
            $userName = Auth::check() ? (Auth::user()->FullName ?? Auth::user()->name ?? 'Patient') : 'Patient';
            $defaultAvatar = 'https://ui-avatars.com/api/?name=' . urlencode($userName) . '&background=0088cc&color=fff';
            $avatar = (Auth::check() && !empty(Auth::user()->AvatarUrl)) ? Auth::user()->AvatarUrl : $defaultAvatar;
            @endphp

            <img src="{{ $avatar }}" alt="Avatar">
            <h6 class="mt-2 mb-0 text-white font-weight-bold">
                {{ Auth::check() ? (Auth::user()->FullName ?? Auth::user()->name) : 'Patient Name' }}
            </h6>
            <small class="text-muted" style="color: #a0aec0 !important;">Patient Account</small>
        </div>

        <!-- Menu Navigation -->
        <div class="sidebar-menu">
            <!-- Profile -->
            <a href="{{ route('patient.profile') }}" class="{{ request()->routeIs('patient.profile*') ? 'active' : '' }}">
                <i class="fas fa-user-circle"></i> Profile Settings
            </a>

            <!-- My Appointments -->
            <a href="{{ route('patient.appointments.index') }}" class="{{ request()->routeIs('patient.appointments*') ? 'active' : '' }}">
                <i class="fas fa-calendar-alt"></i> My Appointments
            </a>

            <!-- Book Appointment -->
            <a href="{{ route('patient.appointments.book') }}" class="{{ request()->routeIs('patient.appointments.book*') ? 'active' : '' }}">
                <i class="fas fa-plus-circle"></i> Book New Appointment
            </a>

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}" id="logout-form" class="mt-4">
                @csrf
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-danger">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </form>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="main-wrapper">
        <!-- Top Banner -->
        <div class="top-navbar">
            <h5 class="mb-0 font-weight-bold">
                <i class="fas fa-user mr-2"></i> Welcome back, {{ Auth::check() ? (Auth::user()->FullName ?? Auth::user()->name) : 'Patient' }}! 👋
            </h5>
            <div>
                <a href="{{ url('/') }}" class="btn btn-sm btn-outline-light mr-2">
                    <i class="fas fa-home"></i> Home Page
                </a>
                <i class="fas fa-bell fa-lg"></i>
            </div>
        </div>

        <!-- Dynamic Body Content -->
        <div class="content-body">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>
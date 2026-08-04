<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MediConnect Dashboard')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <style>
        :root {
            --primary-blue: #223a66;
            --accent-blue: #0088cc;
            --bg-light: #f4f7f6;
        }
        body { background-color: var(--bg-light); font-family: 'Roboto', sans-serif; }
        
        /* Sidebar Styling */
        .sidebar {
            width: 260px;
            min-height: 100vh;
            background: linear-gradient(180deg, #1e3258 0%, #15233e 100%);
            color: #fff;
            position: fixed;
            top: 0; left: 0; z-index: 100;
        }
        .sidebar .brand-logo {
            padding: 20px 15px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .sidebar .profile-box {
            padding: 20px 10px;
            text-align: center;
        }
        .sidebar .profile-box img {
            width: 75px; height: 75px;
            border-radius: 50%; object-fit: cover;
            border: 3px solid var(--accent-blue);
        }
        .sidebar-menu a {
            display: flex; align-items: center;
            padding: 12px 25px;
            color: #b0c4de; text-decoration: none;
            transition: all 0.3s;
        }
        .sidebar-menu a:hover, .sidebar-menu a.active {
            color: #ffffff;
            background-color: var(--accent-blue);
            border-left: 4px solid #ffffff;
        }
        .sidebar-menu i { width: 25px; }

        /* Main Content Styling */
        .main-wrapper { margin-left: 260px; }
        .top-navbar {
            background-color: var(--primary-blue);
            color: white;
            padding: 15px 30px;
            display: flex; justify-content: space-between; align-items: center;
        }
        .content-body { padding: 30px; }
        
        /* Dashboard Stat Cards */
        .stat-card {
            border: none; border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            transition: transform 0.2s;
        }
        .stat-card:hover { transform: translateY(-3px); }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="brand-logo">
            <h4 class="font-weight-bold text-white mb-0">MediConnect</h4>
        </div>
        
        <!-- User Avatar & Info -->
        <div class="profile-box">
            <img src="{{ asset('Novena/images/doctor-avatar.jpg') }}" alt="Avatar">
            <h6 class="mt-2 mb-0 text-white font-weight-bold">Dr. Alexander</h6>
            <small class="text-muted" style="color: #a0aec0 !important;">Cardiology</small>
        </div>

        <!-- Menu Navigation -->
        <div class="sidebar-menu">
            <a href="#" class="active"><i class="fas fa-th-large"></i> Dashboard</a>
            <a href="#"><i class="fas fa-user-md"></i> Doctor Profile</a>
            <a href="#"><i class="fas fa-calendar-alt"></i> Availability Scheduling</a>
            <a href="#"><i class="fas fa-calendar-check"></i> Appointments</a>
            
            <a href="{{ url('/logout') }}" class="text-danger mt-4"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>

    <!-- Main Right Content Area -->
    <div class="main-wrapper">
        <!-- Top Banner -->
        <div class="top-navbar">
            <h5 class="mb-0 font-weight-bold"><i class="fas fa-home mr-2"></i> Welcome back, Doctor! 👋</h5>
            <div><i class="fas fa-bell fa-lg"></i></div>
        </div>

        <!-- Dynamic Body Content -->
        <div class="content-body">
            @yield('content')
        </div>
    </div>

</body>
</html>
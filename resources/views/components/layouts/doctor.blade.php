<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'MediConnect - Doctor' }}</title>

    <link rel="stylesheet"
          href="{{ asset('Novena/plugins/bootstrap/bootstrap.min.css') }}">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        :root {
            --primary-blue: #223a66;
            --accent-blue: #0088cc;
            --bg-light: #f4f7f6;
        }

        body {
            background: var(--bg-light);
            font-family: Roboto, sans-serif;
        }

        /* Sidebar */
        .portal-sidebar {
            width: 260px;
            min-height: 100vh;
            position: fixed;
            inset: 0 auto 0 0;
            z-index: 100;
            color: #fff;
            background: linear-gradient(180deg, #1e3258, #15233e);
        }

        .portal-brand {
            padding: 20px 25px;
            border-bottom: 1px solid rgba(255, 255, 255, .12);
            color: #fff;
        }

        .portal-sidebar a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 25px;
            color: #b0c4de;
            text-decoration: none;
        }

        .portal-sidebar a:hover,
        .portal-sidebar a.active {
            color: #fff;
            background: var(--accent-blue);
        }

        /* Main */
        .portal-main {
            margin-left: 260px;
            min-height: 100vh;
        }

        /* Topbar */
        .portal-topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
            color: #fff;
            background: var(--primary-blue);
        }

        /* Content */
        .portal-content {
            padding: 30px;
        }

        /* Mobile */
        @media (max-width: 767px) {

            .portal-sidebar {
                position: static;
                width: 100%;
                min-height: 0;
            }

            .portal-main {
                margin-left: 0;
            }
        }
    </style>

    {{ $head ?? '' }}

</head>

<body>

    <!-- Sidebar -->
    <aside class="portal-sidebar">

        <!-- Logo -->
        <div class="portal-brand">
            <strong>MediConnect</strong>

            <small class="d-block text-muted">
                Doctor portal
            </small>
        </div>


        <!-- Menu -->
        <nav class="pt-3">

            <!-- Dashboard -->
            <a href="/doctor/dashboard"
               class="{{ request()->is('doctor/dashboard') ? 'active' : '' }}">

                <i class="fas fa-th-large"></i>

                Dashboard
            </a>


            <!-- Doctor Profile -->
            <a href="/doctor/profile"
               class="{{ request()->is('doctor/profile') ? 'active' : '' }}">

                <i class="fas fa-user-md"></i>

                Profile
            </a>


            <!-- Availability -->
            <a href="#">

                <i class="fas fa-calendar-alt"></i>

                Availability
            </a>


            <!-- Appointments -->
            <a href="#">

                <i class="fas fa-calendar-check"></i>

                Appointments
            </a>


            <!-- Logout -->
            <form method="POST"
                  action="{{ route('logout') }}"
                  class="mt-4">

                @csrf

                <button type="submit"
                        class="btn btn-link text-danger text-left pl-4">

                    <i class="fas fa-sign-out-alt mr-2"></i>

                    Log out

                </button>

            </form>

        </nav>

    </aside>


    <!-- Main content -->
    <div class="portal-main">

        <!-- Top bar -->
        <header class="portal-topbar">

            <span>
                Welcome, {{ auth()->user()->name ?? 'Doctor' }}
            </span>

            <i class="fas fa-bell"></i>

        </header>


        <!-- Page content -->
        <main class="portal-content">

            {{ $slot }}

        </main>

    </div>


</body>

</html>
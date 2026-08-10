<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'MediConnect - Admin' }}</title>
    <link rel="stylesheet" href="{{ asset('Novena/plugins/bootstrap/bootstrap.min.css') }}">
    <style>
        body {
            background: #f5f7fb
        }

        .admin-header {
            background: #223a66;
            color: #fff
        }

        .admin-nav a {
            color: #223a66;
            font-weight: 600
        }
    </style>{{ $head ?? '' }}
</head>

<body>
    <header class="admin-header py-3">
        <div class="container d-flex justify-content-between"><strong>MediConnect Admin</strong><span>{{ auth()->user()->name ?? 'Administrator' }}</span></div>
    </header>
    <div class="container-fluid">
        <div class="row">
            <aside class="col-md-2 bg-white min-vh-100 py-4 admin-nav"><a class="d-block mb-3" href="#">Dashboard</a><a class="d-block mb-3" href="#">Users</a><a class="d-block mb-3" href="#">Doctors</a><a class="d-block" href="#">Appointments</a></aside>
            <main class="col-md-10 py-4">{{ $slot }}</main>
        </div>
    </div>
</body>

</html>
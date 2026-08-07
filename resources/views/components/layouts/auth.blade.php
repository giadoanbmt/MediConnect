<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>{{ $title ?? 'MediConnect' }}</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('Novena/images/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('Novena/plugins/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Novena/plugins/icofont/icofont.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Novena/css/style.css') }}">
    <style>
        .auth-wrapper { min-height: 100vh; padding: 30px 0; background: url("{{ asset('Novena/images/bg/banner.jpg') }}") right center / cover no-repeat; display: flex; align-items: center; }
        .auth-card { padding: 35px 40px; border-radius: 12px; background: rgba(255,255,255,.95); box-shadow: 0 10px 30px rgba(0,0,0,.1); backdrop-filter: blur(5px); }
        .auth-card .form-control { height: 48px; padding-left: 15px; border: 1px solid #e5e5e5; border-radius: 5px; }
        .auth-card .form-control:focus { border-color: #0088cc; box-shadow: 0 0 0 .2rem rgba(34,58,102,.15); }
        .auth-card .text-primary, .auth-card a.text-primary { color: #0088cc !important; }
    </style>
</head>
<body>
    {{ $slot }}
    <script src="{{ asset('Novena/plugins/jquery/jquery.js') }}"></script>
    <script src="{{ asset('Novena/plugins/bootstrap/bootstrap.min.js') }}"></script>
</body>
</html>

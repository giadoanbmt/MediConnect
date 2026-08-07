<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="description" content="MediConnect - Kết nối bác sĩ và bệnh nhân">
    <title>{{ $title ?? 'MediConnect' }}</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('Novena/images/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('Novena/plugins/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Novena/plugins/icofont/icofont.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Novena/plugins/slick-carousel/slick/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('Novena/plugins/slick-carousel/slick/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('Novena/css/style.css') }}">
    <style>
        /* Thanh báo tải khi chuyển nội dung bằng điều hướng nội bộ. */
        html::before { content: ''; position: fixed; z-index: 9999; top: 0; left: 0; width: 0; height: 3px; background: #0088cc; opacity: 0; transition: width .2s ease, opacity .2s ease; }
        html.spa-loading::before { width: 75%; opacity: 1; }
        .top-hotline { white-space: nowrap; }
        .top-login-link { display: inline-flex; align-items: center; padding: 6px 15px; border: 1px solid #fff; border-radius: 999px; background: #fff; color: #223a66 !important; font-size: .82rem; font-weight: 700; line-height: 1.2; text-decoration: none !important; box-shadow: 0 1px 2px rgba(0, 0, 0, .12); transition: background-color .2s ease, border-color .2s ease, color .2s ease; }
        .top-login-link:hover, .top-login-link:focus { background: #eaf4ff; border-color: #eaf4ff; color: #0088cc !important; }
        @media (max-width: 991px) { .top-right-bar { justify-content: flex-start; } }
    </style>
    {{ $head ?? '' }}
</head>
<body id="top">
    <x-layouts.partials.header />
    <main>
        {{ $slot }}
    </main>
    <x-layouts.partials.footer />
    <x-layouts.partials.scripts />
    {{ $scripts ?? '' }}
</body>
</html>

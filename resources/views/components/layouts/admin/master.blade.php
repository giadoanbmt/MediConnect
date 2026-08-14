<!DOCTYPE html>
<html lang="vi">

<head>
    @include('components.layouts.admin.partials.header')
    @stack('styles')

    <!-- CSS tạo thanh progress bar chạy ở đầu trang khi chuyển trang -->
    <style>
        .htmx-progress-bar {
            height: 3px;
            width: 0%;
            background-color: #2563eb;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 9999;
            transition: width 0.2s ease-in-out;
        }

        .htmx-request .htmx-progress-bar {
            width: 70%;
        }
    </style>
</head>

<!-- Thêm hx-boost="true" vào body để tự động chặn reload tất cả thẻ <a> và <form> -->

<body class="bg-slate-50 text-slate-800 overflow-y-scroll antialiased min-h-screen flex" hx-boost="true">

    <!-- Thanh Progress bar hiển thị trạng thái đang tải -->
    <div class="htmx-progress-bar"></div>

    <!-- Sidebar Menu Left -->
    @include('components.layouts.admin.partials.sidebar')

    <!-- Right Main Wrapper -->
    <div class="flex-1 ml-64 flex flex-col min-h-screen">

        <!-- Header Navbar Top -->
        @include('components.layouts.admin.partials.navbar')

        <!-- Dynamic Page Content -->
        <main class="p-6 flex-1" id="main-content">
            @yield('content')
        </main>

        <!-- Footer -->
        @include('components.layouts.admin.partials.footer')
    </div>

    @include('components.layouts.admin.partials.scripts')
    @stack('scripts')
</body>

</html>
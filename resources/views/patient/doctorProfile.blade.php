<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Basic Page Needs -->
    <meta charset="utf-8">
    <title>{{ $doctor->FullName ?? $doctor->Name ?? 'Doctor Profile' }} - MediConnect</title>

    <!-- Mobile Specific Metas -->
    <meta http-equiv="X-UA-Compatible" content="Ie=edge">
    <meta name="description" content="Health Care Medical Html5 Template">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="author" content="Themefisher">
    <meta name="generator" content="Themefisher Novena HTML Template v1.0">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicon.png') }}" />

    <!-- Essential stylesheets -->
    <link rel="stylesheet" href="{{ asset('Novena/plugins/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Novena/plugins/icofont/icofont.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Novena/plugins/slick-carousel/slick/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('Novena/plugins/slick-carousel/slick/slick-theme.css') }}">

    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="{{ asset('Novena/css/style.css') }}">
</head>

<body id="top">

    @include('components.layouts.partials.header')

    <!-- Banner Tiêu đề -->
    <section class="page-title bg-1">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="block text-center">
                        <span class="text-white">Doctor Details</span>
                        <!-- Tên Bác sĩ từ DB -->
                        <h1 class="text-capitalize mb-5 text-lg">{{ $doctor->FullName ?? $doctor->Name ?? 'Doctor Profile' }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Thông tin chi tiết Bác sĩ -->
    <section class="section doctor-single">
        <div class="container">
            <div class="row">
                <!-- Cột Trái: Ảnh Avatar & Thông tin Liên hệ -->
                <div class="col-lg-4 col-md-6">
                    <div class="doctor-img-block">
                        <!-- Avatar từ DB (có fallback ảnh mặc định) -->
                        <img src="{{ !empty($doctor->Avatar) ? asset('storage/' . $doctor->Avatar) : asset('Novena/images/team/1.jpg') }}"
                            alt="{{ $doctor->FullName ?? $doctor->Name }}"
                            class="img-fluid w-100 rounded">

                        <div class="info-block mt-4">
                            <h4 class="mb-1">{{ $doctor->FullName ?? $doctor->Name }}</h4>

                            <!-- Chuyên ngành -->
                            <p class="text-primary font-weight-bold mb-3">
                                {{ $doctor->specialization->SpecializationName ?? $doctor->SpecializationName ?? 'Specialist' }}
                            </p>

                            <!-- Danh sách Thông tin SĐT, Email, Bằng cấp -->
                            <ul class="list-unstyled text-left border-top pt-3">
                                <li class="mb-2">
                                    <i class="icofont-ui-call mr-2 text-primary"></i>
                                    <strong>Phone:</strong> {{ $doctor->Phone ?? $doctor->PhoneNumber ?? 'Update soon' }}
                                </li>
                                <li class="mb-2">
                                    <i class="icofont-ui-email mr-2 text-primary"></i>
                                    <strong>Email:</strong> {{ $doctor->Email ?? 'Update soon' }}
                                </li>
                                <li class="mb-2">
                                    <i class="icofont-badge mr-2 text-primary"></i>
                                    <strong>Degree:</strong> {{ $doctor->Degree ?? $doctor->Qualification ?? 'Medical Doctor' }}
                                </li>
                            </ul>

                            <ul class="list-inline mt-4 doctor-social-links">
                                <li class="list-inline-item"><a href="#!"><i class="icofont-facebook"></i></a></li>
                                <li class="list-inline-item"><a href="#!"><i class="icofont-twitter"></i></a></li>
                                <li class="list-inline-item"><a href="#!"><i class="icofont-skype"></i></a></li>
                                <li class="list-inline-item"><a href="#!"><i class="icofont-linkedin"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Cột Phải: Đoạn Giới thiệu (Bio) & Nút Đặt lịch -->
                <div class="col-lg-8 col-md-6">
                    <div class="doctor-details mt-4 mt-lg-0">
                        <h2 class="text-md">Introducing to myself</h2>
                        <div class="divider my-4"></div>

                        <!-- Nội dung Bio / Giới thiệu lấy từ DB -->
                        <div class="doctor-bio text-secondary">
                            @if(!empty($doctor->Bio) || !empty($doctor->Description))
                            {!! nl2br(e($doctor->Bio ?? $doctor->Description)) !!}
                            @else
                            <p>Dr. {{ $doctor->FullName ?? $doctor->Name }} is a highly dedicated specialist in {{ $doctor->specialization->SpecializationName ?? 'healthcare' }} with extensive clinical experience and a deep commitment to providing high-quality patient care.</p>
                            @endif
                        </div>

                        <!-- Nút Make Appointment -->
                        <a href="{{ url('/appoinment?doctor_id=' . ($doctor->DoctorId ?? $doctor->id)) }}" class="btn btn-main-2 btn-round-full mt-4">
                            Make an Appoinment<i class="icofont-simple-right ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bằng cấp & Trình độ học vấn -->
    <section class="section doctor-qualification gray-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="section-title">
                        <h3>Educational Qualifications & Degree</h3>
                        <div class="divider my-4"></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="edu-block p-4 bg-white rounded shadow-sm border-left border-primary" style="border-left-width: 5px !important;">
                        <span class="h6 text-muted"><i class="icofont-graduation-cap mr-1 text-primary"></i> Qualification</span>
                        <h4 class="mb-2 mt-1 title-color">{{ $doctor->Degree ?? 'Medical Doctor (M.D.)' }}</h4>
                        <p class="mb-0">
                            {{ $doctor->Qualifications ?? $doctor->Education ?? 'Graduated from prestigious medical institutions with specialized training certificates and years of clinical practice in diagnosis and treatment.' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer section gray-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mr-auto col-sm-6">
                    <div class="widget mb-5 mb-lg-0">
                        <div class="logo mb-4">
                            <img src="{{ asset('images/logo.png') }}" alt="" class="img-fluid">
                        </div>
                        <p>Tempora dolorem voluptatum nam vero assumenda voluptate, facilis ad eos obcaecati tenetur veritatis eveniet distinctio possimus.</p>
                    </div>
                </div>
                <!-- Các Widget Footer khác giữ nguyên -->
            </div>

            <div class="footer-btm py-4 mt-5">
                <div class="row align-items-center justify-content-between">
                    <div class="col-lg-6">
                        <div class="copyright">
                            Copyright &copy; 2026, Designed &amp; Developed by MediConnect
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Essential Scripts -->
    <script src="{{ asset('Novena/plugins/jquery/jquery.js') }}"></script>
    <script src="{{ asset('Novena/plugins/bootstrap/bootstrap.min.css') }}"></script>
    <script src="{{ asset('Novena/plugins/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('Novena/plugins/slick-carousel/slick/slick.min.js') }}"></script>
    <script src="{{ asset('Novena/plugins/shuffle/shuffle.min.js') }}"></script>
    <script src="{{ asset('Novena/js/script.js') }}"></script>

</body>

</html>
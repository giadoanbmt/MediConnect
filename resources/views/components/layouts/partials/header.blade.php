<header>
    <div class="header-top-bar">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6">
                    <ul class="top-bar-info list-inline-item pl-0 mb-0">
                        <li class="list-inline-item"><a href="mailto:support@gmail.com"><i class="icofont-support-faq mr-2"></i>support@gmail.com</a></li>
                        <li class="list-inline-item"><i class="icofont-location-pin mr-2"></i>35/6 D5 Street, Thanh My Tay Ward, Ho Chi Minh City</li>
                    </ul>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="top-right-bar mt-2 mt-lg-0 d-flex justify-content-lg-end align-items-center">
                        <a href="tel:+84-123-456-789" class="top-hotline mr-3"><span>Call Now: </span><span class="h4">+84 123 456 789</span></a>

                        @guest
                        <a class="top-login-link login-btn" href="{{ route('login') }}">
                            <i class="icofont-sign-in mr-1"></i>
                            Login
                        </a>
                        @else
                        {{-- Bỏ z-index: 1050 ở đây để không che phủ các nút bên dưới --}}
                        <div class="dropdown user-top-dropdown">
                            <a class="top-login-link dropdown-toggle d-inline-flex align-items-center user-account-link"
                                href="#"
                                id="topUserMenu"
                                data-toggle="dropdown"
                                data-bs-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false">

                                <span class="user-icon">
                                    <i class="icofont-user-alt-7"></i>
                                </span>

                                <span class="user-name ml-1">
                                    {{ optional(auth()->user())->FullName ?? 'My Account' }}
                                </span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right shadow border-0 mt-1"
                                aria-labelledby="topUserMenu"
                                style="right: 0; left: auto; min-width: 190px; z-index: 1060;">

                                <a class="dropdown-item py-2" href="{{ route('patient.profile') }}">
                                    <i class="icofont-ui-user mr-2 text-primary"></i>Edit profile
                                </a>
                                <a class="dropdown-item py-2" href="{{ route('patient.appointments.index') }}">
                                    <i class="icofont-calendar mr-2 text-info"></i>My appointments
                                </a>

                                <div class="dropdown-divider my-1"></div>

                                {{-- Logout --}}
                                <form action="{{ route('logout') }}" method="POST" class="m-0 p-0">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger py-2 w-100 text-left border-0 bg-transparent d-flex align-items-center">
                                        <i class="icofont-logout mr-2"></i>Log out
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endguest

                    </div>
                </div>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navigation" id="navbar">
        <div class="container">
            <a class="navbar-brand" href="{{ route('public.home') }}">
                <img src="{{ asset('Novena/images/logo.png') }}" alt="MediConnect" class="img-fluid">
            </a>
            <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarmain" aria-controls="navbarmain" aria-expanded="false" aria-label="Open menu">
                <span class="icofont-navigation-menu"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarmain">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('public.home') ? 'active' : '' }}" href="{{ route('public.home') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('public.about') ? 'active' : '' }}" href="{{ route('public.about') }}">About</a></li>

                    @php
                    $navSpecializations = \App\Models\Specialization::all();
                    @endphp

                    {{-- 1. SPECIALIZATION DROPDOWN --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdown02" data-toggle="dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Specialization <i class="icofont-thin-down"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdown02">
                            <li>
                                <a class="dropdown-item font-weight-bold border-bottom" href="{{ route('public.specialization') }}">All Specializations</a>
                            </li>
                            @forelse($navSpecializations as $spec)
                            <li>
                                <a class="dropdown-item" href="{{ url('/specialization-single/' . ($spec->SpecializationId ?? $spec->id)) }}">
                                    {{ $spec->SpecializationName ?? $spec->name }}
                                </a>
                            </li>
                            @empty
                            <li><a class="dropdown-item text-muted" href="#">No specialization</a></li>
                            @endforelse
                        </ul>
                    </li>

                    {{-- 2. DOCTORS DROPDOWN --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="doctorMenu" data-toggle="dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Doctors <i class="icofont-thin-down"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="doctorMenu">
                            <a class="dropdown-item" href="{{ route('public.doctor') }}">Find a doctor</a>
                            @auth
                            <a class="dropdown-item" href="{{ route('patient.appointments.book') }}">
                                Book Appointment
                            </a>
                            @endauth
                        </div>
                    </li>

                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('public.blog-sidebar') ? 'active' : '' }}" href="{{ route('public.blog-sidebar') }}">News</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ auth()->check() ? route('patient.contact') : route('login') }}">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>
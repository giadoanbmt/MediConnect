<header>
    <div class="header-top-bar">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <ul class="top-bar-info list-inline-item pl-0 mb-0">
                        <li class="list-inline-item"><a href="mailto:support@gmail.com"><i class="icofont-support-faq mr-2"></i>support@novena.com</a></li>
                        <li class="list-inline-item"><i class="icofont-location-pin mr-2"></i>Address Ta-134/A, New York, USA</li>
                    </ul>
                </div>
                <div class="col-lg-6">
                    <div class="top-right-bar mt-2 mt-lg-0 d-flex justify-content-lg-end align-items-center">
                        <a href="tel:+23-345-67890" class="top-hotline mr-3"><span>Call Now: </span><span class="h4">823-4565-13456</span></a>

                        @guest
                        <a class="top-login-link login-btn" href="{{ route('login') }}">
                            <i class="icofont-sign-in mr-1"></i>
                            Login
                        </a>
                        @else
                        {{-- Thêm position: relative và z-index để menu nổi lên trên --}}
                        <div class="dropdown user-top-dropdown" style="position: relative; z-index: 1050;">
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

                                <span class="user-name">
                                    {{ optional(auth()->user())->FullName ?? 'My Account' }}
                                </span>

                            </a>

                            {{-- Căn lề phải (right: 0) để không bị đè ra khỏi màn hình --}}
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-end shadow border-0 mt-1"
                                aria-labelledby="topUserMenu"
                                style="right: 0; left: auto; min-width: 190px;">

                                <a class="dropdown-item py-2" href="{{ route('patient.profile') }}">
                                    <i class="icofont-ui-user mr-2 text-primary"></i>Edit profile
                                </a>
                                <a class="dropdown-item py-2" href="#">
                                    <i class="icofont-calendar mr-2 text-info"></i>My appointments <small class="text-muted">(coming soon)</small>
                                </a>

                                <div class="dropdown-divider my-1"></div>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item text-danger py-2" type="submit" style="cursor: pointer; background: transparent; border: none; width: 100%; text-align: left;">
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
            <a class="navbar-brand" href="{{ route('public.home') }}"><img src="{{ asset('Novena/images/logo.png') }}" alt="MediConnect" class="img-fluid"></a>
            <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarmain" aria-controls="navbarmain" aria-expanded="false" aria-label="Open menu"><span class="icofont-navigation-menu"></span></button>
            <div class="collapse navbar-collapse" id="navbarmain">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('public.home') ? 'active' : '' }}" href="{{ route('public.home') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('public.about') ? 'active' : '' }}" href="{{ route('public.about') }}">About</a></li>
                    @php
                    $navSpecializations = \App\Models\Specialization::all();
                    @endphp

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="{{ route('public.specialization') }}" id="dropdown02" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">Specialization <i class="icofont-thin-down"></i></a>
                        <ul class="dropdown-menu" aria-labelledby="dropdown02">
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
                    <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="{{ route('public.doctor') }}" id="doctorMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Doctors <i class="icofont-thin-down"></i></a>
                        <div class="dropdown-menu" aria-labelledby="doctorMenu">
                            <a class="dropdown-item" href="{{ route('public.doctor') }}">Find a doctor</a>
                            @auth <a class="dropdown-item" href="{{ route('patient.appointments.book') }}">Book an appointment</a> @endauth
                        </div>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('public.blog-sidebar') }}">News</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ auth()->check() ? route('patient.contact') : route('login') }}">Contact</a></li>
                </ul>
            </div>
            <form action="{{ url('/search') }}" method="GET" class="form-inline my-2 my-lg-0 ml-lg-3">
                <div class="input-group input-group-sm" style="max-width: 230px;">
                    <input type="text" name="keyword" class="form-control" placeholder="Search doctor, blog..." required style="border-radius: 20px 0 0 20px; border-right: none;">
                    <div class="input-group-append">
                        <button class="btn btn-main-2" type="submit" style="border-radius: 0 20px 20px 0; padding: 0 12px; height: 100%;">
                            <i class="icofont-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </nav>
</header>
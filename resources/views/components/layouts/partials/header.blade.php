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
                        <a class="top-login-link" href="{{ route('login') }}">Login</a>
                        @else
                        <div class="dropdown">
                            <a class="top-login-link dropdown-toggle" href="#" id="topUserMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ auth()->user()->name }}</a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="topUserMenu">
                                <a class="dropdown-item" href="{{ route('patient.appointment') }}"><i class="icofont-calendar mr-2"></i>Appointments</a>
                                <form method="POST" action="{{ route('logout') }}">@csrf <button class="dropdown-item text-danger" type="submit"><i class="icofont-logout mr-2"></i>Log out</button></form>
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
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('public.service') ? 'active' : '' }}" href="{{ route('public.service') }}">Services</a></li>
                    <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="{{ route('public.department') }}" id="departmentMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Departments <i class="icofont-thin-down"></i></a>
                        <div class="dropdown-menu" aria-labelledby="departmentMenu"><a class="dropdown-item" href="{{ route('public.department') }}">All departments</a><a class="dropdown-item" href="{{ route('public.department-single') }}">Department details</a></div>
                    </li>
                    <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="{{ route('public.doctor') }}" id="doctorMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Doctors <i class="icofont-thin-down"></i></a>
                        <div class="dropdown-menu" aria-labelledby="doctorMenu"><a class="dropdown-item" href="{{ route('public.doctor') }}">Find a doctor</a><a class="dropdown-item" href="{{ route('public.doctor-single') }}">Doctor profile</a>@auth <a class="dropdown-item" href="{{ route('patient.appointment') }}">Book an appointment</a> @endauth</div>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('public.blog-sidebar') }}">News</a></li>
                    @auth <li class="nav-item"><a class="nav-link" href="{{ route('patient.contact') }}">Contact</a></li> @endauth
                </ul>
            </div>
        </div>
    </nav>
</header>
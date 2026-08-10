<header>
    <div class="header-top-bar">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <ul class="top-bar-info list-inline-item pl-0 mb-0">
                        <li class="list-inline-item"><a href="mailto:support@gmail.com"><i class="icofont-support-faq mr-2"></i>support@novena.com</a></li>
                        <li class="list-inline-item"><i class="icofont-location-pin mr-2"></i>Address Ta-134/A, New York, USA </li>
                    </ul>
                </div>
                <div class="col-lg-6">
                    <div class="text-lg-right top-right-bar mt-2 mt-lg-0">
                        <a href="tel:+23-345-67890">
                            <span>Call Now : </span>
                            <span class="h4">823-4565-13456</span>
                        </a>
                        @if(session('customer_id')) 
                               <div class="dropdown">
                                    <a class="btn btn-outline-primary btn-round-full dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding: 8px 22px; border-radius: 25px;">
                                          <i class="icofont-user-alt-7 mr-1"></i> {{ session('Name') ?? 'My account' }}
                                    </a>
                                <div class="dropdown-menu dropdown-menu-right shadow-sm border-0 mt-2">
                                    <a class="dropdown-item" href="{{ url('/patient/profile') }}">
                                       <i class="icofont-ui-user mr-2 text-primary"></i> Profile
                                    </a>
                                    <a class="dropdown-item" href="{{ url('/patient/appointments') }}">
                                        <i class="icofont-calendar mr-2 text-info"></i> Appointments
                                    </a>
                                     <div class="dropdown-divider"></div>
                                       <a class="dropdown-item text-danger" href="{{ url('/patient/logout') }}">
                                           <i class="icofont-logout mr-2"></i> Logout
                                        </a>
                                 </div>
                                </div>
                            @else
                                <a class="btn btn-main-2 btn-round-full" href="{{ route('login') }}" style="background-color: var(--primary-blue); color: #fff; padding: 8px 22px; border-radius: 25px;">
                                    <i class="icofont-sign-in mr-1"></i> Login
                                </a>
                             @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg navigation" id="navbar">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="images/logo.png" alt="" class="img-fluid">
            </a>

            <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarmain"
                aria-controls="navbarmain" aria-expanded="false" aria-label="Toggle navigation">
                <span class="icofont-navigation-menu"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarmain">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active"><a class="nav-link" href="{{ url('/') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/about') }}">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/service') }}">Services</a></li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="{{ url('/specialization') }}" id="dropdown02" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">Specialization <i class="icofont-thin-down"></i></a>
                        <ul class="dropdown-menu" aria-labelledby="dropdown02">
                            <li><a class="dropdown-item" href="{{ route('specializations.Pediatrics') }}">Pediatrics</a></li>
                            <li><a class="dropdown-item" href="{{ route('specializations.Cardiology') }}">Cardiology</a></li>
                            <li><a class="dropdown-item" href="{{ route('specializations.Orthopedics') }}">Orthopedics</a></li>
                            <li><a class="dropdown-item" href="{{ route('specializations.Dermatology') }}">Dermatology</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="{{ url('/doctor') }}" id="dropdown03" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">Doctors <i class="icofont-thin-down"></i></a>
                        <ul class="dropdown-menu" aria-labelledby="dropdown03">
                            <li><a class="dropdown-item" href="{{ url('/doctor') }}">Doctors</a></li>
                            <li><a class="dropdown-item" href="{{ url('/doctor-single') }}">Doctor Single</a></li>
                            <li><a class="dropdown-item" href="{{ url('/appoinment') }}">Appoinment</a></li>

                            <li class="dropdown dropdown-submenu dropleft">
                                <a class="dropdown-item dropdown-toggle" href="#!" id="dropdown0501" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Sub Menu</a>
            
                                <ul class="dropdown-menu" aria-labelledby="dropdown0501">
                                    <li><a class="dropdown-item" href="{{ url('/') }}">Submenu 01</a></li>
                                    <li><a class="dropdown-item" href="{{ url('/') }}">Submenu 02</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="{{ url('/blog-sidebar') }}" id="dropdown05" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">Blog <i class="icofont-thin-down"></i></a>
                        <ul class="dropdown-menu" aria-labelledby="dropdown05">
                            <li><a class="dropdown-item" href="{{ url('/blog-sidebar') }}">Blog with Sidebar</a></li>
                            <li><a class="dropdown-item" href="{{ url('/blog-single') }}">Blog Single</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/contact') }}">Contact</a></li>
                </ul>
            </div>
            <form action="{{ url('/search') }}" method="GET" class="form-inline my-2 my-lg-0 ml-lg-3"> <!--làm  xong controller search thì ghi vô action ở đây -->
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
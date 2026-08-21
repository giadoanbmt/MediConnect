@extends('components.layouts.partials.frontend')

@section('title', 'Home - MediConnect')

@section('content')

<section class="banner">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-12 col-xl-7">
                <div class="block">
                    <div class="divider mb-3"></div>

                    <span class="text-uppercase text-sm letter-spacing">
                        MediConnect
                    </span>

                    <h1 class="mb-3 mt-3">
                        Better Health Starts with the Right Care
                    </h1>

                    <p class="mb-4 pr-5">
                        Find trusted doctors, explore health information
                        and book an appointment with ease.
                    </p>

                    @auth
                    <a href="{{ route('patient.appointments.book') }}"
                        class="btn btn-main-2 btn-icon btn-round-full">
                        Book an Appointment
                        <i class="icofont-simple-right ml-2"></i>
                    </a>
                    @else
                    <a href="{{ route('login') }}"
                        class="btn btn-main-2 btn-icon btn-round-full">
                        Book an Appointment
                        <i class="icofont-simple-right ml-2"></i>
                    </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</section>

<section class="features">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="feature-block d-lg-flex">

                    <div class="feature-item mb-5 mb-lg-0">
                        <div class="feature-icon mb-4">
                            <i class="icofont-surgeon-alt"></i>
                        </div>

                        <span>Easy Booking</span>

                        <h4 class="mb-3">
                            Online Appointment
                        </h4>

                        <p class="mb-4">
                            Find a doctor and choose a suitable appointment
                            time quickly and easily.
                        </p>
                    </div>

                    <div class="feature-item mb-5 mb-lg-0">
                        <div class="feature-icon mb-4">
                            <i class="icofont-ui-clock"></i>
                        </div>

                        <span>Timing Schedule</span>

                        <h4 class="mb-3">
                            Working Hours
                        </h4>

                        <ul class="w-hours list-unstyled">
                            <li class="d-flex justify-content-between">
                                Morning
                                <span>08:00 - 12:00</span>
                            </li>

                            <li class="d-flex justify-content-between">
                                Afternoon
                                <span>13:00 - 17:00</span>
                            </li>
                        </ul>
                    </div>

                    <div class="feature-item mb-5 mb-lg-0">
                        <div class="feature-icon mb-4">
                            <i class="icofont-heart-beat"></i>
                        </div>

                        <span>Health Information</span>

                        <h4 class="mb-3">
                            Health Care
                        </h4>

                        <p class="mb-4">
                            Learn about common diseases, prevention,
                            treatments and useful health information.
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<section class="section service" id="health-information">
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-lg-7 text-center">
                <div class="section-title">

                    <h2>Common Diseases</h2>

                    <div class="divider mx-auto my-4"></div>

                    <p>
                        Learn about common diseases, symptoms,
                        prevention and health care.
                    </p>

                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-lg-4 col-md-6">
                <div class="service-item mb-4">
                    <div class="icon d-flex align-items-center">
                        <i class="icofont-heart-beat text-lg"></i>

                        <h4 class="mt-3 mb-3">
                            Heart Disease
                        </h4>
                    </div>

                    <div class="content">
                        <p class="mb-4">
                            Learn about common heart conditions,
                            symptoms and risk factors.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="service-item mb-4">
                    <div class="icon d-flex align-items-center">
                        <i class="icofont-lungs text-lg"></i>

                        <h4 class="mt-3 mb-3">
                            Respiratory Diseases
                        </h4>
                    </div>

                    <div class="content">
                        <p class="mb-4">
                            Learn about common respiratory conditions
                            and ways to protect respiratory health.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="service-item mb-4">
                    <div class="icon d-flex align-items-center">
                        <i class="icofont-brain-alt text-lg"></i>

                        <h4 class="mt-3 mb-3">
                            Neurological Health
                        </h4>
                    </div>

                    <div class="content">
                        <p class="mb-4">
                            Basic information about neurological health,
                            sleep and common warning signs.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="service-item mb-4">
                    <div class="icon d-flex align-items-center">
                        <i class="icofont-tooth text-lg"></i>

                        <h4 class="mt-3 mb-3">
                            Dental Health
                        </h4>
                    </div>

                    <div class="content">
                        <p class="mb-4">
                            Learn about healthy habits and common
                            dental health problems.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="service-item mb-4">
                    <div class="icon d-flex align-items-center">
                        <i class="icofont-dna-alt-1 text-lg"></i>

                        <h4 class="mt-3 mb-3">
                            Diabetes
                        </h4>
                    </div>

                    <div class="content">
                        <p class="mb-4">
                            Learn about blood sugar, risk factors
                            and health monitoring.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="service-item mb-4">
                    <div class="icon d-flex align-items-center">
                        <i class="icofont-medical-sign-alt text-lg"></i>

                        <h4 class="mt-3 mb-3">
                            Health Checkups
                        </h4>
                    </div>

                    <div class="content">
                        <p class="mb-4">
                            Learn why regular health checkups are
                            important for early detection.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<section class="section about gray-bg">
    <div class="container">
        <div class="row align-items-center">

            <div class="col-lg-4 col-sm-6">
                <div class="about-img">

                    <img src="{{ asset('Novena/images/about/img-1.jpg') }}"
                        alt="Health care"
                        class="img-fluid">

                    <img src="{{ asset('Novena/images/about/img-2.jpg') }}"
                        alt="Health care"
                        class="img-fluid mt-4">

                </div>
            </div>

            <div class="col-lg-4 col-sm-6">
                <div class="about-img mt-4 mt-lg-0">

                    <img src="{{ asset('Novena/images/about/img-3.jpg') }}"
                        alt="Health care"
                        class="img-fluid">

                </div>
            </div>

            <div class="col-lg-4">
                <div class="about-content pl-4 mt-4 mt-lg-0">

                    <span class="subtitle">
                        Prevention & Health Care
                    </span>

                    <h2 class="title-color mt-2">
                        Prevention and Healthy Living
                    </h2>

                    <div class="divider my-4"></div>

                    <p>
                        Maintaining a healthy lifestyle and regular
                        health checkups can help prevent diseases
                        and support better health.
                    </p>

                    <ul class="list-unstyled mt-4">

                        <li class="mb-3">
                            <i class="icofont-check-circled text-color-2 mr-2"></i>
                            Maintain a balanced diet
                        </li>

                        <li class="mb-3">
                            <i class="icofont-check-circled text-color-2 mr-2"></i>
                            Exercise regularly
                        </li>

                        <li class="mb-3">
                            <i class="icofont-check-circled text-color-2 mr-2"></i>
                            Get enough sleep and rest
                        </li>

                        <li class="mb-3">
                            <i class="icofont-check-circled text-color-2 mr-2"></i>
                            Have regular health checkups
                        </li>

                    </ul>

                </div>
            </div>

        </div>
    </div>
</section>

<section class="section service">
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-lg-7 text-center">

                <div class="section-title">

                    <h2>Latest Medical News</h2>

                    <div class="divider mx-auto my-4"></div>

                    <p>
                        Stay updated with the latest medical,
                        health care and scientific information.
                    </p>

                </div>

            </div>
        </div>

        <div class="row">

            <div class="col-lg-4 col-md-6">
                <div class="service-item mb-4">

                    <div class="icon d-flex align-items-center">
                        <i class="icofont-newspaper text-lg"></i>

                        <h4 class="mt-3 mb-3">
                            Medical News
                        </h4>
                    </div>

                    <div class="content">
                        <p class="mb-4">
                            Discover important medical news
                            and health care information.
                        </p>
                    </div>

                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="service-item mb-4">

                    <div class="icon d-flex align-items-center">
                        <i class="icofont-medical-sign text-lg"></i>

                        <h4 class="mt-3 mb-3">
                            Disease Prevention
                        </h4>
                    </div>

                    <div class="content">
                        <p class="mb-4">
                            Learn about disease prevention
                            and healthy living.
                        </p>
                    </div>

                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="service-item mb-4">

                    <div class="icon d-flex align-items-center">
                        <i class="icofont-microscope text-lg"></i>

                        <h4 class="mt-3 mb-3">
                            Medical Research
                        </h4>
                    </div>

                    <div class="content">
                        <p class="mb-4">
                            Explore new research and developments
                            in medical science.
                        </p>
                    </div>

                </div>
            </div>

        </div>

        <div class="text-center mt-4">
            <a href="{{ route('public.blog-sidebar') }}"
                class="btn btn-main btn-round-full">
                View All News
                <i class="icofont-simple-right ml-2"></i>
            </a>
        </div>

    </div>
</section>

@endsection
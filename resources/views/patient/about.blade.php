@extends('components.layouts.partials.frontend')
@section('title', 'About Us - MediConnect')

@section('content')

<!-- Page Title Section -->
<section class="page-title bg-1">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="block text-center">
                    <span class="text-white">Who We Are</span>
                    <h1 class="text-capitalize mb-4 text-lg">About MediConnect</h1>
                    <p class="text-white-50 max-w-2xl mx-auto">Connecting patients with quality healthcare through modern technology and efficient appointment booking.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Story & Overview (Paragraph Format) -->
<section class="section about-page">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-4 mb-4 mb-lg-0">
                <h2 class="title-color">Modern Digital Healthcare for Everyone</h2>
                <div class="divider my-3"></div>
            </div>
            <div class="col-lg-8">
                <p class="lead font-weight-normal text-dark mb-3">
                    MediConnect was established with a clear goal: to bridge the gap between patients and medical facilities through modern web technology.
                </p>
                <p class="text-muted mb-3">
                    In traditional healthcare, booking appointments often involves long phone queues, uncertain schedules, and manual paperwork. MediConnect changes this experience by providing an intuitive, centralized digital system. Patients can easily explore specialized medical departments, view available clinic rooms, and schedule appointments in just a few clicks.
                </p>
                <p class="text-muted">
                    Behind the scenes, our platform helps clinics and medical practitioners manage their schedules seamlessly. By digitizing daily workflows, we eliminate scheduling conflicts, reduce patient wait times, and allow doctors to focus on delivering high-quality care.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Vision & Mission Section -->
<section class="section bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="p-4 bg-white rounded shadow-sm border-left border-primary h-100" style="border-left-width: 4px !important;">
                    <div class="d-flex items-center mb-3">
                        <i class="icofont-eye text-primary text-xl mr-3" style="font-size: 2rem;"></i>
                        <h3 class="mb-0 h4 font-weight-bold text-dark">Our Vision</h3>
                    </div>
                    <p class="text-muted mb-0">
                        To become a trusted digital healthcare portal, ensuring that every individual can access reliable medical consultation and hospital services with speed, transparency, and ease.
                    </p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="p-4 bg-white rounded shadow-sm border-left border-primary h-100" style="border-left-width: 4px !important;">
                    <div class="d-flex items-center mb-3">
                        <i class="icofont-rocket-alt-2 text-primary text-xl mr-3" style="font-size: 2rem;"></i>
                        <h3 class="mb-0 h4 font-weight-bold text-dark">Our Mission</h3>
                    </div>
                    <p class="text-muted mb-0">
                        To simplify healthcare management through continuous technology innovation, offering patients a convenient booking process and clinics a robust management ecosystem.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose MediConnect (Focusing on Modern System & Technology) -->
<section class="section fetaure-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="section-title">
                    <h2 class="mb-3">Powered by Modern Technology</h2>
                    <div class="divider mx-auto my-3"></div>
                    <p class="text-muted">Discover how our advanced digital system improves your healthcare experience.</p>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="about-block-item p-4 bg-white rounded shadow-sm text-center h-100 border">
                    <i class="icofont-laptop text-primary mb-3 d-block" style="font-size: 2.5rem;"></i>
                    <h5 class="mt-2 font-weight-bold">Smart Online Booking</h5>
                    <p class="text-muted text-sm">Schedule appointments instantly without waiting on phone lines or standing in queues.</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="about-block-item p-4 bg-white rounded shadow-sm text-center h-100 border">
                    <i class="icofont-wall-clock text-primary mb-3 d-block" style="font-size: 2.5rem;"></i>
                    <h5 class="mt-2 font-weight-bold">Real-Time Schedules</h5>
                    <p class="text-muted text-sm">View up-to-date doctor availability, room locations, and time slots instantly.</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="about-block-item p-4 bg-white rounded shadow-sm text-center h-100 border">
                    <i class="icofont-shield-alt text-primary mb-3 d-block" style="font-size: 2.5rem;"></i>
                    <h5 class="mt-2 font-weight-bold">Secure Data Management</h5>
                    <p class="text-muted text-sm">Your personal information and medical appointment records are safely protected.</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="about-block-item p-4 bg-white rounded shadow-sm text-center h-100 border">
                    <i class="icofont-headphone-alt-2 text-primary mb-3 d-block" style="font-size: 2.5rem;"></i>
                    <h5 class="mt-2 font-weight-bold">24/7 Accessibility</h5>
                    <p class="text-muted text-sm">Access your booking dashboard and inquiries anytime, anywhere, from any device.</p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
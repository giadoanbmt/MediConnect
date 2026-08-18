@extends('components.layouts.partials.frontend')
@section('title', 'Home - MediConnect')

@section('content')

<section class="page-title bg-1">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="block text-center">
                    <span class="text-white">All Specialization</span>
                    <h1 class="text-capitalize mb-5 text-lg">Medical Specialties</h1>

                    <!-- <ul class="list-inline breadcumb-nav">
            <li class="list-inline-item"><a href="{{ url('/') }}" class="text-white">Home</a></li>
            <li class="list-inline-item"><span class="text-white">/</span></li>
            <li class="list-inline-item"><a href="#" class="text-white-50">All Specialization</a></li>
          </ul> -->
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section service-2">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 text-center">
                <div class="section-title">
                    <h2>Comprehensive Medical Specialties</h2>
                    <div class="divider mx-auto my-4"></div>
                    <p>We offer specialized medical services across multiple disciplines to ensure accurate diagnosis, effective treatment, and compassionate care for every patient.</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="Specialization-block mb-5 border rounded shadow-sm overflow-hidde">
                    <img src="{{ asset('Novena/images/service/Orthopedics_service.jpg') }}" alt="" class="img-fluid w-100 border-bottom">
                    <div class="content p-4">
                        <h4 class="mt-4 mb-2 title-color">Orthopedics</h4>
                        <p class="mb-4">Diagnosis and Treatment of Bone and Joint Disorders.</p>
                        <a href="{{route('specializations.Orthopedics')}}" class="read-more">Learn More <i class="icofont-simple-right ml-2"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="Specialization-block mb-5 border rounded shadow-sm overflow-hidde">
                    <img src="{{ asset('Novena/images/service/Cardiology_service.jpg') }}" alt="" class="img-fluid w-100  border-bottom">
                    <div class="content p-4">
                        <h4 class="mt-4 mb-2  title-color">Cardiology</h4>
                        <p class="mb-4">Comprehensive Diagnosis and Treatment for Heart and Cardiovascular Diseases.</p>
                        <a href="{{ route('specializations.Cardiology') }}" class="read-more">Learn More <i class="icofont-simple-right ml-2"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 ">
                <div class="Specialization-block  mb-5 border rounded shadow-sm overflow-hidde">
                    <img src="{{ asset('Novena/images/service/Pediatrics_service.jpg') }}" alt="" class="img-fluid w-100  border-bottom">
                    <div class="content p-4">
                        <h4 class="mt-4 mb-2 title-color">Pediatrics</h4>
                        <p class="mb-4">Comprehensive Healthcare Services for Children.</p>
                        <a href="{{ route('specializations.Pediatrics') }}" class="read-more">Learn More <i class="icofont-simple-right ml-2"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="Specialization-block mb-5 border rounded shadow-sm overflow-hidde">
                    <img src="{{ asset('Novena/images/service/Dermatology_service.jpg') }}" alt="" class="img-fluid w-100  border-bottom">
                    <div class="content p-4">
                        <h4 class="mt-4 mb-2 title-color">Dermatology</h4>
                        <p class="mb-4">Comprehensive Diagnosis and Treatment of Skin Conditions</p>
                        <a href="{{ route('specializations.Dermatology') }}" class="read-more">Learn More <i class="icofont-simple-right ml-2"></i></a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection
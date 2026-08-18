@extends('components.layouts.partials.frontend')
@section('title', ($specialization->SpecializationName ?? 'Specialization Details') . ' - MediConnect')

@section('content')

<section class="page-title bg-1">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="block text-center">
                    <span class="text-white">Specialization Details</span>
                    <h1 class="text-capitalize mb-5 text-lg">{{ $specialization->SpecializationName ?? $specialization->name }}</h1>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section department-single">
    <div class="container">
        <div class="row">
            <!-- CỘT NỘI DUNG CHÍNH -->
            <div class="col-lg-8">
                <div class="department-content mt-5">
                    <!-- HÌNH ẢNH CHUYÊN KHOA -->
                    <div class="mb-4 overflow-hidden rounded">
                        <img src="{{ !empty($specialization->ImageUrl) && file_exists(public_path($specialization->ImageUrl)) ? asset($specialization->ImageUrl) : asset('images/default-specialization.jpg') }}"
                            alt="{{ $specialization->SpecializationName ?? $specialization->name }}"
                            class="img-fluid w-100"
                            style="max-height: 450px; object-fit: cover;">
                    </div>

                    <h3 class="text-md mb-3 title-color">{{ $specialization->SpecializationName ?? $specialization->name }}</h3>
                    <div class="divider my-4"></div>

                    <!-- DESCRIPTION -->
                    @if(!empty($specialization->Description))
                    <p class="lead font-weight-bold text-dark mb-4">
                        {{ $specialization->Description }}
                    </p>
                    @endif

                    <!--  CONTENT  -->
                    <div class="department-description">
                        <p class="text-muted" style="line-height: 1.8;">
                            {!! nl2br(e($specialization->Content)) !!}
                        </p>
                    </div>
                </div>
            </div>

            <!-- SIDEBAR DANH SÁCH CHUYÊN KHOA KHÁC -->
            <div class="col-lg-4">
                <div class="sidebar-widget schedule-widget mt-5 mt-lg-0 p-4 bg-light rounded shadow-sm">
                    <h5 class="mb-4 title-color">Other Specialties</h5>
                    <ul class="list-unstyled department-service mb-0">
                        @if(isset($otherSpecializations) && count($otherSpecializations) > 0)
                        @foreach($otherSpecializations as $other)
                        <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <a href="{{ url('/specialization/' . ($other->SpecializationId ?? $other->id)) }}" class="text-secondary font-weight-medium">
                                {{ $other->SpecializationName ?? $other->name }}
                            </a>
                            <i class="icofont-simple-right text-primary"></i>
                        </li>
                        @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
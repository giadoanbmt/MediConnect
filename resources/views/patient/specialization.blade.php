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
            @forelse($specializations as $item)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="Specialization-block border rounded shadow-sm overflow-hidden h-100 d-flex flex-column justify-content-between">
                    <div>
                        <!-- 1. HÌNH ẢNH CÓ LINK & CỐ ĐỊNH KÍCH THƯỚC -->
                        <a href="{{ url('/specialization/' . ($item->SpecializationId ?? $item->id)) }}">
                            <img src="{{ !empty($item->ImageUrl) && file_exists(public_path($item->ImageUrl)) ? asset($item->ImageUrl) : asset('images/default-specialization.jpg') }}"
                                alt="{{ $item->SpecializationName ?? $item->name }}"
                                class="img-fluid w-100 border-bottom"
                                style="height: 220px; object-fit: cover; transition: transform 0.3s ease;">
                        </a>

                        <div class="content p-4">
                            <!-- 2. TIÊU ĐỀ CÓ LINK -->
                            <h4 class="mt-2 mb-2 title-color">
                                <a href="{{ url('/specialization-single/' . ($item->SpecializationId ?? $item->id)) }}" class="text-dark">
                                    {{ $item->SpecializationName ?? $item->name }}
                                </a>
                            </h4>

                            <!-- 3. MÔ TẢ TÓM TẮT -->
                            <p class="mb-4 text-muted">
                                {{ Str::limit(strip_tags($item->Content), 110) }}
                            </p>
                        </div>
                    </div>

                    <!-- 4. NÚT LEARN MORE CÓ LINK -->
                    <div class="px-4 pb-4">
                        <a href="{{ url('/specialization-single/' . ($item->SpecializationId ?? $item->id)) }}" class="read-more">
                            Learn More <i class="icofont-simple-right ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted fs-5">No specialized data is available yet.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

@endsection
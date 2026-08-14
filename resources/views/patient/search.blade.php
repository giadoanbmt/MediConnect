@extends('components.layouts.partials.frontend')

@section('title', 'Search results: ' . $keyword)

@section('content')
<div class="container py-5">
    <h2 class="font-weight-bold mb-4">
        Search result: <span class="text-primary">"{{ $keyword }}"</span>
    </h2>

    <!-- ==================== 1. CHUYÊN KHOA (SPECIALIZATIONS) ==================== -->
    <div class="mb-5">
        <h4 class="font-weight-bold mb-3 d-flex align-items-center">
            <i class="icofont-stethoscope text-primary mr-2" style="font-size: 1.5rem;"></i>
            Specialization ({{ $specializations->count() }})
        </h4>
        <hr class="mt-1 mb-4">

        @if($specializations->count() > 0)
            <div class="row">
                @foreach($specializations as $spec)
                    <div class="col-md-4 col-sm-6 mb-3">
                        {{-- Đường dẫn đến trang chi tiết Chuyên khoa --}}
                        <a href="{{ route('specialization.detail', $spec->SpecializationId) }}" class="text-decoration-none">
                            <div class="card border-0 shadow-sm h-100 p-3 card-hover" style="border-radius: 8px; border-left: 4px solid var(--primary-blue, #223a66) !important; transition: transform 0.2s;">
                                <div class="d-flex align-items-center">
                                    <div class="icon-box bg-light rounded-circle p-3 text-primary mr-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <i class="icofont-check-circled" style="font-size: 1.5rem;"></i>
                                    </div>
                                    <div>
                                        <h5 class="font-weight-bold mb-1 text-dark">
                                            {{ $spec->SpecializationName ?? $spec->name }}
                                        </h5>
                                        @if(!empty($spec->Description))
                                            <p class="text-muted small mb-0">
                                                {{ Str::limit(strip_tags($spec->Description), 60) }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-muted italic">No result</p>
        @endif
    </div>

    <!-- ==================== 2. BÁC SĨ (DOCTORS) ==================== -->
    <div class="mb-5">
        <h4 class="font-weight-bold mb-3 d-flex align-items-center">
            <i class="icofont-doctor-alt text-primary mr-2" style="font-size: 1.5rem;"></i>
            Doctor ({{ $doctors->count() }})
        </h4>
        <hr class="mt-1 mb-4">

        @if($doctors->count() > 0)
            <div class="row">
                @foreach($doctors as $doc)
                    <div class="col-md-4 col-sm-6 mb-4">
                        {{-- Đường dẫn đến trang chi tiết / Hồ sơ Bác sĩ --}}
                        <a href="{{ route('doctor.detail', $doc->DoctorId) }}" class="text-decoration-none">
                            <div class="card border-0 shadow-sm h-100 p-3 card-hover" style="border-radius: 10px; transition: transform 0.2s;">
                                <div class="d-flex align-items-center mb-3">
                                    <img src="{{ asset($doc->Image ?? $doc->image ?? 'images/default-doctor.png') }}" 
                                         alt="{{ $doc->FullName }}" 
                                         class="rounded-circle mr-3" 
                                         style="width: 65px; height: 65px; object-fit: cover; border: 2px solid #eef2f5;">
                                    <div>
                                        <h6 class="font-weight-bold mb-1 text-dark">{{ $doc->FullName }}</h6>
                                        <span class="badge badge-soft-primary text-primary px-2 py-1" style="background-color: #e8f1ff; font-size: 0.8rem;">
                                            {{ $doc->specialization->SpecializationName ?? $doc->specialization->name ?? 'Specialist' }}
                                        </span>
                                    </div>
                                </div>
                                @if(!empty($doc->Qualifications))
                                    <p class="text-muted small mb-0">
                                        <i class="icofont-badge mr-1"></i> {{ $doc->Qualifications }}
                                    </p>
                                @endif
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-muted italic">No result</p>
        @endif
    </div>

    <!-- ==================== 3. BÀI VIẾT (NEWS / BLOGS) ==================== -->
    <div class="mb-5">
        <h4 class="font-weight-bold mb-3 d-flex align-items-center">
            <i class="icofont-news text-primary mr-2" style="font-size: 1.5rem;"></i>
            News ({{ $blogs->count() }})
        </h4>
        <hr class="mt-1 mb-4">

        @if($blogs->count() > 0)
            <div class="row">
                @foreach($blogs as $blog)
                    <div class="col-md-6 mb-4">
                        {{-- Đường dẫn đến trang đọc chi tiết Bài viết --}}
                        <a href="{{ route('blog.detail', $blog->ContentId) }}" class="text-decoration-none">
                            <div class="card border-0 shadow-sm h-100 overflow-hidden card-hover" style="border-radius: 10px; transition: transform 0.2s;">
                                <div class="row no-gutters h-100">
                                    @if(!empty($blog->Image))
                                        <div class="col-md-4">
                                            <img src="{{ asset($blog->Image) }}" class="card-img h-100" style="object-fit: cover; min-height: 120px;" alt="{{ $blog->Title }}">
                                        </div>
                                    @endif
                                    <div class="{{ !empty($blog->Image) ? 'col-md-8' : 'col-12' }}">
                                        <div class="card-body d-flex flex-column justify-content-between p-3">
                                            <div>
                                                @if(!empty($blog->Category))
                                                    <small class="text-primary font-weight-bold text-uppercase d-block mb-1">{{ $blog->Category }}</small>
                                                @endif
                                                <h6 class="font-weight-bold text-dark mb-2">
                                                    {{ $blog->Title }}
                                                </h6>
                                                <p class="text-muted small mb-2">
                                                    {{ Str::limit(strip_tags($blog->Content ?? $blog->Body), 90) }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-muted italic">No result</p>
        @endif
    </div>
</div>

<style>
    /* Hiệu ứng hover khi di chuột vào ô kết quả */
    .card-hover:hover {
        transform: translateY(-3px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
    }
</style>
@endsection
@extends('components.layouts.partials.frontend')
@section('title', 'Home - MediConnect')

@section('content')

<style>
    .spec-container {
        display: flex;
        flex-wrap: nowrap;
        align-items: center;
        width: 100%;
        min-width: 0;
        gap: 8px;
        overflow-x: auto;
        overflow-y: hidden;
        scroll-behavior: smooth;
        scrollbar-width: none;
        -ms-overflow-style: none;
    }

    .spec-container::-webkit-scrollbar {
        display: none;
    }

    .spec-container .filter-spec-btn {
        flex: 0 0 auto;
        white-space: nowrap;
        margin: 0 !important;
        border: none !important;
        background: transparent !important;
        color: #007bff !important;
        font-weight: 600;
        padding: 10px 24px;
        border-radius: 30px !important;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .spec-container .filter-spec-btn input[type="radio"] {
        display: none;
    }

    .spec-container .filter-spec-btn.active,
    .spec-container .filter-spec-btn:hover {
        background: #e91e4d !important;
        color: #fff !important;
        border-color: #e91e4d !important;
    }

    .spec-arrow {
        flex: 0 0 36px;
        width: 36px;
        height: 36px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #dee2e6;
        border-radius: 50%;
        background: #fff;
        color: #333;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .spec-arrow:hover {
        background: #E91E4D;
        border-color: #007bff;
        color: #fff;
    }

    .spec-arrow:disabled {
        opacity: 0.35;
        cursor: not-allowed;
        background: #fff;
        border-color: #dee2e6;
        color: #6c757d;
    }
</style>

<section class="page-title bg-1">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="block text-center">
                    <span class="text-white">All Doctors</span>
                    <h1 class="text-capitalize mb-5 text-lg">Specalized doctors</h1>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section doctors">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <div class="section-title">
                    <h2>Doctors</h2>
                    <div class="divider mx-auto my-4"></div>
                    <p>We provide a wide range of creative services adipisicing elit. Autem maxime rem modi eaque, voluptate. Beatae officiis neque </p>
                </div>
            </div>
        </div>

        <!-- ================= BỘ LỌC 2 BÊN ================= -->
        <div class="row mb-2">
            <div class="col-12">
                <h6 class="text-uppercase text-muted font-weight-bold">
                    <i class="icofont-doctor-alt mr-1 text-primary"></i>
                    Specializations
                </h6>
            </div>
        </div>

        <div class="row align-items-start mb-5">
            <!-- BÊN TRÁI: Các nút Chuyên khoa -->
            <div class="col-lg-9 col-md-8 mb-3 mb-lg-0">
                <div class="d-flex align-items-center w-100">
                    <button type="button" id="specPrev" class="spec-arrow mr-2" onclick="scrollSpecs(-250)">
                        <i class="icofont-simple-left"></i>
                    </button>

                    <div id="specContainer" class="spec-container">
                        <label class="btn filter-spec-btn active" data-spec-id="">
                            <input type="radio" name="shuffle-filter-spec" checked> All
                        </label>

                        @foreach($specializations as $spec)
                        <label class="btn filter-spec-btn" data-spec-id="{{ $spec->SpecializationId }}">
                            <input type="radio" name="shuffle-filter-spec">
                            {{ $spec->SpecializationName }}
                        </label>
                        @endforeach
                    </div>

                    <button type="button" id="specNext" class="spec-arrow ml-2" onclick="scrollSpecs(250)">
                        <i class="icofont-simple-right"></i>
                    </button>
                </div>
            </div>

            <!-- BÊN PHẢI: Search + Dropdown City -->
            <div class="col-lg-3 col-md-4">
                <form id="search-form" onsubmit="return false;" class="mb-2">
                    <div class="input-group input-group-sm">
                        <input type="text"
                            name="keyword"
                            id="search-keyword"
                            class="form-control"
                            placeholder="Search doctor name..."
                            value="{{ request('keyword') }}"
                            style="border-radius: 20px 0 0 20px; border-right: none;">

                        <div class="input-group-append">
                            <button class="btn btn-main-2" type="submit" style="border-radius: 0 20px 20px 0; padding: 0 14px;">
                                <i class="icofont-search"></i>
                            </button>
                        </div>
                    </div>
                </form>

                <div class="form-group mb-0">
                    <select name="city_id" id="city_id" class="form-control form-control-sm custom-select" style="border-radius: 20px; height: 31px;">
                        <option value="">All Cities</option>
                        @foreach($cities as $city)
                        <option value="{{ $city->CityId }}" {{ request('city_id') == $city->CityId ? 'selected' : '' }}>
                            {{ $city->CityName }} - {{ $city->DistrictName }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- ================= DANH SÁCH BÁC SĨ ================= -->
        <div class="row shuffle-wrapper portfolio-gallery" id="doctor-list-container">
            @include('patient.doctors-list')
        </div>

    </div>
</section>

<!-- JavaScript Xử Lý AJAX Search & Cuộn Nút -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const gridContainer = document.getElementById('doctor-list-container');
        let searchTimer = null;

        // Hàm gọi AJAX lấy danh sách Bác sĩ từ Server
        function fetchDoctors() {
            const keyword = document.getElementById('search-keyword').value.trim();
            const cityId = document.getElementById('city_id').value;
            const activeSpecBtn = document.querySelector('.filter-spec-btn.active');
            const specId = activeSpecBtn ? activeSpecBtn.getAttribute('data-spec-id') : '';

            const params = new URLSearchParams({
                keyword: keyword,
                city_id: cityId,
                specialization_id: specId
            });

            // Hiển thị hiệu ứng mờ nhẹ khi đang tải dữ liệu
            if (gridContainer) gridContainer.style.opacity = '0.5';

            fetch(`${window.location.pathname}?${params.toString()}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    if (gridContainer) {
                        gridContainer.innerHTML = html;
                        gridContainer.style.opacity = '1'; // Hiện lại danh sách sau khi load xong
                    }
                })
                .catch(error => {
                    console.error('Error fetching doctors:', error);
                    if (gridContainer) gridContainer.style.opacity = '1';
                });
        }

        // 1. Lọc theo Chuyên khoa (Nút bấm)
        document.querySelectorAll('.filter-spec-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.filter-spec-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                fetchDoctors();
            });
        });

        // 2. Lọc theo Thành phố (Dropdown)
        const citySelect = document.getElementById('city_id');
        if (citySelect) {
            citySelect.addEventListener('change', fetchDoctors);
        }

        // 3. Tìm kiếm theo Từ khóa (Gõ phím tìm ngay sau 300ms)
        const searchInput = document.getElementById('search-keyword');
        if (searchInput) {
            searchInput.addEventListener('keyup', function() {
                clearTimeout(searchTimer);
                searchTimer = setTimeout(fetchDoctors, 300);
            });
        }

        // Submit form (Khi ấn Enter hoặc nút kính lúp)
        const searchForm = document.getElementById('search-form');
        if (searchForm) {
            searchForm.addEventListener('submit', function(e) {
                e.preventDefault();
                clearTimeout(searchTimer);
                fetchDoctors();
            });
        }
    });

    // Cuộn Nút Chuyên Khoa
    document.addEventListener('DOMContentLoaded', function() {
        const specContainer = document.getElementById('specContainer');
        const specPrev = document.getElementById('specPrev');
        const specNext = document.getElementById('specNext');

        if (!specContainer || !specPrev || !specNext) return;

        window.scrollSpecs = function(distance) {
            specContainer.scrollBy({
                left: distance,
                behavior: 'smooth'
            });
        };

        function updateSpecArrows() {
            const maxScroll = specContainer.scrollWidth - specContainer.clientWidth;
            specPrev.disabled = specContainer.scrollLeft <= 1;
            specNext.disabled = specContainer.scrollLeft >= maxScroll - 1;
        }

        specContainer.addEventListener('scroll', updateSpecArrows);
        updateSpecArrows();
        window.addEventListener('resize', updateSpecArrows);
    });
</script>

@endsection
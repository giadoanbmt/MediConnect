<!DOCTYPE html>

<html lang="en">
<head>

  <!-- Basic Page Needs
  ================================================== -->
  <meta charset="utf-8">
  <title>MediConnect &amp; Medical template</title>

  <!-- Mobile Specific Metas
  ================================================== -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Health Care Medical Html5 Template">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
  <meta name="author" content="Themefisher">
  <meta name="generator" content="Themefisher Novena HTML Template v1.0">

  <!-- Favicon -->
  <link rel="shortcut icon" type="image/x-icon" href="/images/favicon.png" />

  <!-- 
  Essential stylesheets
  =====================================-->
  <link rel="stylesheet" href="{{ asset('Novena/plugins/bootstrap/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('Novena/plugins/icofont/icofont.min.css') }}">
  <link rel="stylesheet" href="{{ asset('Novena/plugins/slick-carousel/slick/slick.css') }}">
  <link rel="stylesheet" href="{{ asset('Novena/plugins/slick-carousel/slick/slick-theme.css') }}">

  <!-- Main Stylesheet -->
  <link rel="stylesheet" href="{{ asset('Novena/css/style.css') }}">

</head>

<body id="top">

@include('components.layouts.partials.header')

<section class="page-title bg-1">
  <div class="overlay"></div>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="block text-center">
          <span class="text-white">All Doctors</span>
          <h1 class="text-capitalize mb-5 text-lg">Specalized doctors</h1>

          <!-- <ul class="list-inline breadcumb-nav">
            <li class="list-inline-item"><a href="{{ url('/') }}" class="text-white">Home</a></li>
            <li class="list-inline-item"><span class="text-white">/</span></li>
            <li class="list-inline-item"><a href="#" class="text-white-50">All Doctors</a></li>
          </ul> -->
        </div>
      </div>
    </div>
  </div>
</section>


<!-- portfolio -->
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
        <div class="row align-items-end mb-5">
            
            <!-- 1. BÊN TRÁI: Chọn Chuyên khoa (Dạng Nút) -->
            <div class="col-lg-9 col-md-8 mb-4 mb-lg-0">
                <h6 class="text-uppercase text-muted mb-2 font-weight-bold">
                    <i class="mr-1 text-primary"></i> Specializations
                </h6>
                <div class="btn-group btn-group-toggle w-auto flex-wrap" style="width: fit-content;" data-toggle="buttons">
                    <label class="btn btn-sm btn-outline-primary active filter-spec-btn" data-filter="all">
                        <input type="radio" name="shuffle-filter-spec" checked /> All
                    </label>
                    @foreach($specializations as $spec)
                    <label class="btn btn-sm btn-outline-primary filter-spec-btn" data-filter="spec-{{ $spec->SpecializationId }}">
                        <input type="radio" name="shuffle-filter-spec" /> {{ $spec->SpecializationName }}
                    </label>
                    @endforeach
                </div>
            </div>

            <!-- 2. BÊN PHẢI: Chọn Thành phố (Dạng Dropdown) -->
            <div class="col-lg-3 col-md-4 bg-light p-3 rounded border">
                <h6 class="text-uppercase text-muted mb-2 font-weight-bold">
                    <i class="icofont-location-pin mr-1 text-danger"></i> City
                </h6>
                <select id="city-select" class="form-control custom-select">
                    <option value="all">--- City ---</option>
                    @foreach($cities as $city)
                        <option value="city-{{ $city->CityId }}">{{ $city->CityName }}</option>
                    @endforeach
                </select>
            </div>

        </div>

    <!-- ================= DANH SÁCH BÁC SĨ ================= -->
        <div class="row shuffle-wrapper portfolio-gallery">
            @foreach($doctors as $doctor)
            <div class="col-lg-3 col-sm-6 col-md-6 mb-4 shuffle-item" 
                 data-groups='["spec-{{ $doctor->SpecializationId }}", "city-{{ $doctor->CityId }}"]'>
                
                <div class="position-relative doctor-inner-box">
                    <div class="doctor-profile">
                        <div class="doctor-img">
                            <a href="{{ route('public.doctorProfile', ['id' => $doctor->DoctorId]) }}">
                                @php
                                    $avatar = ($doctor->AvatarUrl && file_exists(public_path($doctor->AvatarUrl))) 
                                              ? asset($doctor->AvatarUrl) 
                                              : asset('Novena/images/team/1.jpg');
                                @endphp
                                <img src="{{ $avatar }}" alt="{{ $doctor->FullName }}" class="img-fluid w-100" style="height: 250px; object-fit: cover;">
                            </a>
                        </div>
                    </div>

                    <div class="content mt-3 text-center">
                        <h4 class="mb-0">
                            <a href="{{ route('public.doctorProfile', $doctor->DoctorId) }}">{{ $doctor->FullName }}</a>
                        </h4>
                        <p class="mb-0 text-primary font-weight-bold">
                            {{ $doctor->specialization->SpecializationName ?? 'Update soon' }}
                        </p>
                        <p class="mb-0 text-muted small">
                            <i class="icofont-location-pin"></i> {{ $doctor->city->CityName ?? 'Update soon' }}
                        </p>
                    </div>
                </div>

            </div>
            @endforeach
        </div>

    </div>
</section>

<!-- JavaScript Xử Lý Lọc Kết Hợp (Dropdown + Buttons) -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    var gridContainer = document.querySelector('.shuffle-wrapper');
    
    if (gridContainer && window.Shuffle) {
        var myShuffle = new Shuffle(gridContainer, {
            itemSelector: '.shuffle-item',
            sizer: null
        });

        var currentSpec = 'all';
        var currentCity = 'all';

        // Hàm áp dụng lọc đồng thời cả 2 điều kiện
        function applyMultiFilter() {
            myShuffle.filter(function (element) {
                var groups = JSON.parse(element.getAttribute('data-groups') || '[]');
                var matchSpec = (currentSpec === 'all') || groups.includes(currentSpec);
                var matchCity = (currentCity === 'all') || groups.includes(currentCity);
                return matchSpec && matchCity;
            });
        }

        // Bắt sự kiện khi CLICK nút Chuyên khoa
        document.querySelectorAll('.filter-spec-btn').forEach(function (btn) {
            btn.addEventListener('click', function () {
                document.querySelectorAll('.filter-spec-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                currentSpec = this.getAttribute('data-filter');
                applyMultiFilter();
            });
        });

        // Bắt sự kiện khi THAY ĐỔI lựa chọn ở Dropdown Thành phố
        var citySelect = document.getElementById('city-select');
        if (citySelect) {
            citySelect.addEventListener('change', function () {
                currentCity = this.value;
                applyMultiFilter();
            });
        }
    }
});
</script>


<!-- footer Start -->
<footer class="footer section gray-bg">
	<div class="container">
		<div class="row">
			<div class="col-lg-4 mr-auto col-sm-6">
				<div class="widget mb-5 mb-lg-0">
					<div class="logo mb-4">
						<img src="images/logo.png" alt="" class="img-fluid">
					</div>
					<p>Tempora dolorem voluptatum nam vero assumenda voluptate, facilis ad eos obcaecati tenetur veritatis eveniet distinctio possimus.</p>

					<ul class="list-inline footer-socials mt-4">
						<li class="list-inline-item">
							<a href="https://www.facebook.com/themefisher"><i class="icofont-facebook"></i></a>
						</li>
						<li class="list-inline-item">
							<a href="https://twitter.com/themefisher"><i class="icofont-twitter"></i></a>
						</li>
						<li class="list-inline-item">
							<a href="https://www.pinterest.com/themefisher/"><i class="icofont-linkedin"></i></a>
						</li>
					</ul>
				</div>
			</div>

			<div class="col-lg-2 col-md-6 col-sm-6">
				<div class="widget mb-5 mb-lg-0">
					<h4 class="text-capitalize mb-3">Specialization</h4>
					<div class="divider mb-4"></div>

					<ul class="list-unstyled footer-menu lh-35">
						<li><a href="#!">Surgery </a></li>
						<li><a href="#!">Wome's Health</a></li>
						<li><a href="#!">Radiology</a></li>
						<li><a href="#!">Cardioc</a></li>
						<li><a href="#!">Medicine</a></li>
					</ul>
				</div>
			</div>

			<div class="col-lg-2 col-md-6 col-sm-6">
				<div class="widget mb-5 mb-lg-0">
					<h4 class="text-capitalize mb-3">Support</h4>
					<div class="divider mb-4"></div>

					<ul class="list-unstyled footer-menu lh-35">
						<li><a href="#!">Terms & Conditions</a></li>
						<li><a href="#!">Privacy Policy</a></li>
						<li><a href="#!">Company Support </a></li>
						<li><a href="#!">FAQuestions</a></li>
						<li><a href="#!">Company Licence</a></li>
					</ul>
				</div>
			</div>

			<div class="col-lg-3 col-md-6 col-sm-6">
				<div class="widget widget-contact mb-5 mb-lg-0">
					<h4 class="text-capitalize mb-3">Get in Touch</h4>
					<div class="divider mb-4"></div>

					<div class="footer-contact-block mb-4">
						<div class="icon d-flex align-items-center">
							<i class="icofont-email mr-3"></i>
							<span class="h6 mb-0">Support Available for 24/7</span>
						</div>
						<h4 class="mt-2"><a href="mailto:support@email.com">Support@email.com</a></h4>
					</div>

					<div class="footer-contact-block">
						<div class="icon d-flex align-items-center">
							<i class="icofont-support mr-3"></i>
							<span class="h6 mb-0">Mon to Fri : 08:30 - 18:00</span>
						</div>
						<h4 class="mt-2"><a href="tel:+23-345-67890">+23-456-6588</a></h4>
					</div>
				</div>
			</div>
		</div>

		<div class="footer-btm py-4 mt-5">
			<div class="row align-items-center justify-content-between">
				<div class="col-lg-6">
					<div class="copyright">
						Copyright &copy; 2021, Designed &amp; Developed by <a href="https://themefisher.com/">Themefisher</a>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="subscribe-form text-lg-right mt-5 mt-lg-0">
						<form action="#" class="subscribe">
							<input type="text" class="form-control" placeholder="Your Email address" required>
							<button type="submit" class="btn btn-main-2 btn-round-full">Subscribe</button>
						</form>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-4">
					<a class="backtop scroll-top-to" href="#top">
						<i class="icofont-long-arrow-up"></i>
					</a>
				</div>
			</div>
		</div>
	</div>
</footer>
   

    <!-- 
    Essential Scripts
    =====================================-->
    <script src="{{ asset('Novena/plugins/jquery/jquery.js') }}"></script>
	<script src="{{ asset('Novena/plugins/bootstrap/bootstrap.min.js') }}"></script>
	<script src="{{ asset('Novena/plugins/slick-carousel/slick/slick.min.js') }}"></script>
	<script src="{{ asset('Novena/plugins/shuffle/shuffle.min.js') }}"></script>

	<script src="{{ asset('Novena/js/script.js') }}"></script>

  </body>
  </html>
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
                        <a href="{{route('specializations.Orthopedics')}}" class="read-more">Learn More  <i class="icofont-simple-right ml-2"></i></a>
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
    <script src="plugins/jquery/jquery.js"></script>
    <script src="plugins/bootstrap/bootstrap.min.js"></script>
    <script src="plugins/slick-carousel/slick/slick.min.js"></script>
    <script src="plugins/shuffle/shuffle.min.js"></script>

 
    
    <script src="js/script.js"></script>

  </body>
  </html>
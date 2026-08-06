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

@include('layouts.header')

<section class="page-title bg-1">
  <div class="overlay"></div>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="block text-center">
          <span class="text-white">Specialization Details</span>
          <h1 class="text-capitalize mb-5 text-lg">Single Specialization</h1>

           <ul class="list-inline breadcumb-nav">
            <li class="list-inline-item"><a href="{{ url('/') }}" class="text-white">Home</a></li>
            <li class="list-inline-item"><span class="text-white">/</span></li>
            <li class="list-inline-item"><a href="#" class="text-white-50">Specialization Details</a></li>
          </ul> 
        </div>
      </div>
    </div>
  </div>
</section>


<section class="section Specialization-single">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="Specialization-img">
                    <img src="images/service/bg-1.jpg" alt="" class="img-fluid">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="Specialization-content mt-5">
                    <h3 class="text-md">Cardiology</h3>
                    <div class="divider my-4"></div>
                    <p class="lead"></p>
                    <p></p>


                    <h3 class="mt-5 mb-4">Services features</h3>
                    <div class="divider my-4"></div>
                    <ul class="list-unstyled Specialization-service">
                        <li><i class="icofont-check mr-2"></i>International Drug Database</li>
                        <li><i class="icofont-check mr-2"></i>Stretchers and Stretcher Accessories</li>
                        <li><i class="icofont-check mr-2"></i>Cushions and Mattresses</li>
                        <li><i class="icofont-check mr-2"></i>Cholesterol and lipid tests</li>
                        <li><i class="icofont-check mr-2"></i>Critical Care Medicine Specialists</li>
                        <li><i class="icofont-check mr-2"></i>Emergency Assistance</li>
                    </ul>

                    @if(session('customer_id'))
    <!-- Đã đăng nhập -> Đặt lịch -->
    <a href="{{ url('/appointment') }}" class="btn btn-main-2 btn-round-full">
        Make an appointment<i class="icofont-simple-right ml-2"></i>
    </a>
@else
    <!-- Chưa đăng nhập -> Chuyển sang trang Login -->
    <a href="{{ url('/login') }}" class="btn btn-main-2 btn-round-full">
        Make an appointment<i class="icofont-simple-right ml-2"></i>
    </a>
@endif
                </div>
            </div>

            <div class="col-lg-4">
                <div class="sidebar-widget schedule-widget mt-5">
                    <h5 class="mb-4">Time Schedule</h5>

                    <ul class="list-unstyled">
                      <li class="d-flex justify-content-between align-items-center">
                        <span>Monday - Friday</span>
                        <span>9:00 - 17:00</span>
                      </li>
                      <li class="d-flex justify-content-between align-items-center">
                        <span>Saturday</span>
                        <span>9:00 - 16:00</span>
                      </li>
                      <li class="d-flex justify-content-between align-items-center">
                        <span>Sunday</span>
                        <span>Closed</span>
                      </li>
                    </ul>

                    <div class="sidebar-contatct-info mt-4">
                        <p class="mb-0">Need Urgent Help?</p>
                        <h3>+23-4565-65768</h3>
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
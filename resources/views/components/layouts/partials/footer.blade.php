<footer class="footer section gray-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mr-auto col-sm-6">
                <div class="widget mb-5 mb-lg-0">
                    <div class="logo mb-4"><img src="{{ asset('Novena/images/logo.png') }}" alt="MediConnect" class="img-fluid"></div>
                    <p>MediConnect helps patients find, connect with, and book appointments with the right doctors.</p>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 col-sm-6">
                <div class="widget mb-5 mb-lg-0">
                    <h4 class="text-capitalize mb-3">Explore</h4>
                    <div class="divider mb-4"></div>
                    <ul class="list-unstyled footer-menu lh-35">
                        <li><a href="{{ route('public.department') }}">Departments</a></li>
                        <li><a href="{{ route('public.doctor') }}">Doctors</a></li>
                        <li><a href="{{ route('public.service') }}">Services</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="widget widget-contact mb-5 mb-lg-0">
                    <h4 class="text-capitalize mb-3">Contact</h4>
                    <div class="divider mb-4"></div>
                    <div class="footer-contact-block mb-4">
                        <div class="icon d-flex align-items-center"><i class="icofont-email mr-3"></i><span class="h6 mb-0">Support available 24/7</span></div>
                        <h4 class="mt-2"><a href="mailto:support@mediconnect.test">support@mediconnect.test</a></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-btm py-4 mt-5">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-6">
                    <div class="copyright">&copy; {{ date('Y') }} MediConnect.</div>
                </div>
                <div class="col-lg-4"><a class="backtop scroll-top-to float-lg-right" href="#top"><i class="icofont-long-arrow-up"></i></a></div>
            </div>
        </div>
    </div>
</footer>
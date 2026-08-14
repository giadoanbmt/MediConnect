<x-layouts.auth title="Register">
    <div class="auth-wrapper">
        <div class="container">
            <div class="row">
                <!-- Form đăng ký nằm ở cột bên trái -->
                <div class="col-lg-5 col-md-7 col-sm-10">
                    <div class="auth-card">
                        <div class="text-center mb-3">
                            <a href="{{ url('/') }}">
                                <img src="{{ asset('Novena/images/logo.png') }}" alt="Novena Logo" class="img-fluid mb-2" style="max-height: 40px;">
                            </a>
                            <h3 class="font-weight-bold mb-4" style="color: #0088cc;">Register</h3>
                            <p class="text-muted small">Create an account to access healthcare services.</p>
                        </div>

                        <form action="{{ url('/register') }}" method="POST">
                            @csrf

                            <div class="form-group mb-2">
                                <label for="name" class="text-black font-weight-bold small">Your full name</label>
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>

                            <div class="form-group mb-2">
                                <label for="gender" class="text-black font-weight-bold small">Gender</label>
                                <input type="text" name="gender" id="gender" class="form-control">
                            </div>

                            <div class="form-group mb-2">
                                <label for="username" class="text-black font-weight-bold small">Username</label>
                                <input type="text" name="username" id="username" class="form-control" required>
                            </div>

                            <div class="form-group mb-2">
                                <label for="password" class="text-black font-weight-bold small">Password</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="password_confirmation" class="text-black font-weight-bold small">Confirm password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                            </div>

                            <div class="form-group mb-2">
                                <label for="address" class="text-black font-weight-bold small">Address</label>
                                <input type="text" name="address" id="address" class="form-control" required>
                            </div>

                            <div class="form-group mb-2">
                                <label for="email" class="text-black font-weight-bold small">Email</label>
                                <input type="email" name="email" id="email" class="form-control" required>
                            </div>



                            <!-- dấu tích tôi đồng ý vs điều khoản dịch vụ, vs từ Term of service khi nhấn vô sẽ điều hướng đến 
                            page điều khoản dịch vụ -->

                            <!-- <div class="form-group mb-3">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="terms" required>
                                <label class="custom-control-label small text-muted" for="terms">
                                    I agree to the <a href="#" class="text-primary">Terms of Service.</a>
                                </label>
                            </div>
                        </div> -->

                            <button type="submit" class="btn btn-main btn-block btn-round-full"
                                style="background-color: #0088cc; border-color: #006699;">
                                Register <i class="icofont-simple-right ml-2"></i>
                            </button>
                        </form>

                        <div class="text-center mt-3 pt-2 border-top">
                            <p class="text-muted mb-0 small">Already have an account?
                                <a href="{{ url('/login') }}" class="text-primary font-weight-bold">Back to login</a>
                            </p>
                            <a href="{{ url('/') }}" class="d-inline-block mt-2 text-muted small">
                                <i class="icofont-thin-left mr-1"></i> Back to Homepage
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.auth>
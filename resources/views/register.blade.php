<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Register</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('Novena/images/favicon.png') }}" />

    <!-- Essential stylesheets -->
    <link rel="stylesheet" href="{{ asset('Novena/plugins/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Novena/plugins/icofont/icofont.min.css') }}">

    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="{{ asset('Novena/css/style.css') }}">

    <style>
        .auth-wrapper {
            min-height: 100vh;
            background-image: url("{{ asset('Novena/images/bg/banner.jpg') }}");
            background-size: cover;
            background-position: right center;
            background-repeat: no-repeat;
            display: flex;
            align-items: center;
            padding: 30px 0;
        }
        .auth-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 35px 40px;
            backdrop-filter: blur(5px);
        }
        .form-control {
            height: 46px;
            border-radius: 5px;
            border: 1px solid #e5e5e5;
            padding-left: 15px;
        }
        .form-control:focus {
            border-color: #222fb9;
            box-shadow: none;
        }
    </style>
</head>

<body>

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
                            <label for="username" class="text-black font-weight-bold small">Username</label>
                            <input type="text" name="username" id="username" class="form-control"  required>
                        </div>

                        <div class="form-group mb-2">
                            <label for="password" class="text-black font-weight-bold small">Password</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>

                        <div class="form-group mb-2">
                            <label for="email" class="text-black font-weight-bold small">Email</label>
                            <input type="email" name="email" id="email" class="form-control"  required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="password_confirmation" class="text-black font-weight-bold small">Confirm password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
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

<script src="{{ asset('Novena/plugins/jquery/jquery.js') }}"></script>
<script src="{{ asset('Novena/plugins/bootstrap/bootstrap.min.js') }}"></script>

</body>
</html>
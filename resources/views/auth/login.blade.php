<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Login</title>
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
        }
        .auth-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 40px;
            backdrop-filter: blur(5px);
        }
        .form-control {
            height: 50px;
            border-radius: 5px;
            border: 1px solid #e5e5e5;
            padding-left: 15px;
        }
        .form-control:focus {
            border-color: #0088cc;
            box-shadow: 0 0 0 0.2rem rgba(34, 58, 102, 0.15) !important;;
        }
        .text-primary, a.text-primary {
            color: #0088cc !important;
        }
    </style>
</head>

<body>

<div class="auth-wrapper">
    <div class="container">
        <div class="row">
            <!-- Form căn bên trái tận dụng khoảng trắng của ảnh banner -->
            <div class="col-lg-5 col-md-7 col-sm-10">
                <div class="auth-card">
                    <div class="text-center mb-4">
                        <a href="{{ url('/') }}">
                            <img src="{{ asset('Novena/images/logo.png') }}" alt="Novena Logo" class="img-fluid mb-3" style="max-height: 180px;">
                        </a>
                        <h2 class="font-weight-bold mb-4" style="color: #0088cc;">Login</h2>
                    </div>

                    <form action="{{ url('/login') }}" method="POST">
                        @csrf
                        
                       <div class="form-group mb-3">
        <label for="username" class="text-black font-weight-bold small">Username</label>
        <div class="input-group">
            <input type="text" name="username" id="username" class="form-control" required autofocus>
        </div>
        @error('username')
            <small class="text-danger d-block mt-1">{{ $message }}</small>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="password" class="text-black font-weight-bold small">Password</label>
        <input type="password" name="password" id="password" class="form-control" required>
        @error('password')
            <small class="text-danger d-block mt-1">{{ $message }}</small>
        @enderror
        <div class="text-right">
            <a href="#" class="text-small text-right text-muted small">Forgot password?</a>
        </div>
    </div>

                        <div class="form-group d-flex justify-content-between align-items-center mb-4">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="remember" name="remember">
                                <label class="custom-control-label small text-muted" for="remember">Remember me</label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-main btn-block btn-round-full" 
                             style="background-color: #0088cc; border-color: #006699;">
                            Login <i class="icofont-simple-right ml-2"></i>
                        </button>
                    </form>

                    <div class="text-center mt-4 pt-3 border-top">
                        <p class="text-muted mb-0 small">Don't have an account? 
                            <br>
                            <a href="{{ url('/register') }}" class="text-primary font-weight-bold">SIGN UP NOW!</a>
                        </p>
                        <a href="{{ url('/') }}" class="d-inline-block mt-3 text-muted small">
                            <i class="icofont-thin-left mr-1"></i> Home page
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
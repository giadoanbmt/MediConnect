<x-layouts.auth title="Login">
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
</x-layouts.auth>

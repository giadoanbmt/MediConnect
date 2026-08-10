<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Khởi tạo Quản trị viên - MediConnect</title>
    <link rel="stylesheet" href="{{ asset('Novena/plugins/bootstrap/bootstrap.min.css') }}">
    <style>
        body {
            background: #223a66;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .setup-card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>

<body>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="setup-card p-4 p-md-5">
                    <div class="text-center mb-4">
                        <h3 class="font-weight-bold text-primary">MediConnect Setup</h3>
                        <p class="text-muted small">Khởi tạo tài khoản Admin đầu tiên cho hệ thống</p>
                    </div>

                    @if ($errors->any())
                    <div class="alert alert-danger py-2">
                        <ul class="mb-0 small pl-3">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('admin.setup.post') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label font-weight-bold text-secondary">Tên đăng nhập (Username)</label>
                            <input type="text" name="username" class="form-control" value="{{ old('username') }}" required placeholder="admin">
                        </div>

                        <div class="mb-3">
                            <label class="form-label font-weight-bold text-secondary">Địa chỉ Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required placeholder="admin@mediconnect.com">
                        </div>

                        <div class="mb-3">
                            <label class="form-label font-weight-bold text-secondary">Mật khẩu</label>
                            <input type="password" name="password" class="form-control" required placeholder="••••••••">
                        </div>

                        <div class="mb-4">
                            <label class="form-label font-weight-bold text-secondary">Xác nhận mật khẩu</label>
                            <input type="password" name="password_confirmation" class="form-control" required placeholder="••••••••">
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 font-weight-bold">
                            Tạo tài khoản Admin
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
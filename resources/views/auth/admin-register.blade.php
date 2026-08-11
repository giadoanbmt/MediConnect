<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Admin Account - MediConnect</title>
    <link rel="stylesheet" href="{{ asset('Novena/plugins/bootstrap/bootstrap.min.css') }}">
    <style>
        body {
            background: #223a66;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 0;
        }

        .setup-card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            max-width: 680px;
            /* Tăng độ rộng của form */
            width: 100%;
        }
    </style>
</head>

<body>

    <div class="container d-flex justify-content-center">
        <div class="setup-card p-4 p-md-5">
            <div class="text-center mb-4">
                <h3 class="font-weight-bold text-primary">MediConnect Setup</h3>
                <p class="text-muted small">Create the first Admin account for the system</p>
            </div>

            @if ($errors->any())
            <div class="alert alert-danger py-2 mb-4">
                <ul class="mb-0 small pl-3">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('admin.setup.post') }}" method="POST">
                @csrf

                <!-- 1. Full Name -->
                <div class="mb-3">
                    <label class="form-label font-weight-bold text-secondary">Full Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required placeholder="Enter full name...">
                </div>

                <!-- 2. Username -->
                <div class="mb-3">
                    <label class="form-label font-weight-bold text-secondary">Username <span class="text-danger">*</span></label>
                    <input type="text" name="username" class="form-control" value="{{ old('username') }}" required placeholder="Enter username...">
                </div>

                <!-- 3. Email Address -->
                <div class="mb-3">
                    <label class="form-label font-weight-bold text-secondary">Email Address <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required placeholder="Enter email address...">
                </div>

                <!-- 4. Gender -->
                <div class="mb-3">
                    <label class="form-label font-weight-bold text-secondary">Gender</label>
                    <select name="gender" class="form-control">
                        <option value="">-- Select --</option>
                        <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>

                <!-- 5. Address -->
                <div class="mb-3">
                    <label class="form-label font-weight-bold text-secondary">Address</label>
                    <input type="text" name="address" class="form-control" value="{{ old('address') }}" placeholder="Enter address...">
                </div>

                <!-- 6. Password -->
                <div class="mb-3">
                    <label class="form-label font-weight-bold text-secondary">Password <span class="text-danger">*</span></label>
                    <input type="password" name="password" class="form-control" required placeholder="Enter password...">
                </div>

                <!-- 7. Confirm Password -->
                <div class="mb-4">
                    <label class="form-label font-weight-bold text-secondary">Confirm Password <span class="text-danger">*</span></label>
                    <input type="password" name="password_confirmation" class="form-control" required placeholder="Confirm password...">
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2.5 font-weight-bold">
                    Create Admin Account
                </button>
            </form>
        </div>
    </div>

</body>

</html>
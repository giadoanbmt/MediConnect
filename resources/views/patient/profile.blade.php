@extends('components.layouts.partials.frontend')
@section('title', 'My Profile - MediConnect')

@section('content')

<!-- Banner Tiêu đề -->
<section class="page-title bg-1">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="block text-center">
                    <span class="text-white">Account Settings</span>
                    <h1 class="text-capitalize mb-4 text-lg">My Profile</h1>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Form Chỉnh sửa Profile -->
<section class="section doctor-single">
    <div class="container">
        <div class="row">
            <!-- Sidebar Ảnh đại diện -->
            <div class="col-lg-4 col-md-5 mb-4">
                <div class="doctor-img text-center p-4 bg-white rounded shadow-sm border">
                    <div class="position-relative d-inline-block mb-3">
                        @if($user->AvatarUrl && file_exists(public_path($user->AvatarUrl)))
                        <img src="{{ asset($user->AvatarUrl) }}" alt="{{ $user->FullName }}" class="img-fluid rounded-circle border" style="width: 150px; height: 150px; object-fit: cover;">
                        @else
                        <img src="{{ asset('images/avatars/default-avatar.webp') }}" alt="Default Avatar" class="img-fluid rounded-circle border" style="width: 150px; height: 150px; object-fit: cover;">
                        @endif
                    </div>
                    <h4 class="mt-2 font-weight-bold">{{ $user->FullName }}</h4>
                    <p class="text-muted mb-1">&#64;{{ $user->Username }}</p>
                    <span class="badge badge-primary px-3 py-2">Patient</span>
                </div>
            </div>

            <!-- Form cập nhật thông tin -->
            <div class="col-lg-8 col-md-7">
                <div class="p-4 bg-white rounded shadow-sm border">

                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0 pl-3">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('patient.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <h4 class="mb-3 text-primary">Personal Information</h4>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold">Username</label>
                                <input type="text" class="form-control" value="{{ $user->Username }}" disabled readonly>
                                <small class="form-text text-muted">Username cannot be changed.</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="FullName" class="form-control" value="{{ old('FullName', $user->FullName) }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold">Email Address <span class="text-danger">*</span></label>
                                <input type="email" name="Email" class="form-control" value="{{ old('Email', $user->Email) }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold">Gender</label>
                                <select name="Gender" class="form-control">
                                    <option value="">-- Select Gender --</option>
                                    <option value="Male" {{ old('Gender', $user->Gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('Gender', $user->Gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="font-weight-bold">Address</label>
                                <input type="text" name="Address" class="form-control" value="{{ old('Address', $user->Address) }}" placeholder="Enter your full address">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="font-weight-bold">Avatar Picture</label>
                                <input type="file" name="Avatar" class="form-control-file border p-1 rounded">
                                <small class="form-text text-muted">Allowed formats: JPG, PNG, WEBP</small>
                            </div>
                        </div>

                        <hr class="my-4">

                        <h4 class="mb-3 text-primary">Change Password (Optional)</h4>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold">New Password</label>
                                <input type="password" name="Password" class="form-control" placeholder="Leave blank to keep current password">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold">Confirm New Password</label>
                                <input type="password" name="Password_confirmation" class="form-control" placeholder="Re-enter new password">
                            </div>
                        </div>

                        <div class="mt-4 text-right">
                            <button type="submit" class="btn btn-main btn-round-full">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
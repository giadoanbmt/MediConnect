<x-layouts.doctor title="MediConnect - Doctor Profile">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="font-weight-bold mb-1" style="color: #9ac5f5;">
                Doctor Profile
            </h2>

            <p class="text-muted mb-0">
                Xem và cập nhật thông tin cá nhân
            </p>
        </div>
    </div>


    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif


    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <div class="card border-0 shadow-sm"
         style="background-color: #171a1b; color: #fff;">

        <div class="card-body p-4">

            <form action="{{ route('doctor.profile.update') }}" method="POST">

                @csrf
                @method('PUT')


                <div class="row">

                    <!-- Doctor Name -->
                    <div class="col-md-6 mb-3">

                        <label class="font-weight-bold">
                            Doctor Name
                        </label>

                        <input
                            type="text"
                            name="DoctorName"
                            class="form-control"
                            value="{{ old('DoctorName', $doctor->DoctorName) }}"
                            required
                        >

                    </div>


                    <!-- Doctor Account -->
                    <div class="col-md-6 mb-3">

                        <label class="font-weight-bold">
                            Doctor Account
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            value="{{ $doctor->DoctorAccount }}"
                            disabled
                        >

                        <small class="text-muted">
                            Tài khoản đăng nhập không thể thay đổi tại đây.
                        </small>

                    </div>


                    <!-- Sex -->
                    <div class="col-md-6 mb-3">

                        <label class="font-weight-bold">
                            Sex
                        </label>

                        <select
                            name="Sex"
                            class="form-control"
                            required
                        >

                            <option value="Male"
                                {{ old('Sex', $doctor->Sex) == 'Male' ? 'selected' : '' }}>
                                Male
                            </option>

                            <option value="Female"
                                {{ old('Sex', $doctor->Sex) == 'Female' ? 'selected' : '' }}>
                                Female
                            </option>

                        </select>

                    </div>


                    <!-- Phone Number -->
                    <div class="col-md-6 mb-3">

                        <label class="font-weight-bold">
                            Phone Number
                        </label>

                        <input
                            type="text"
                            name="PhoneNumber"
                            class="form-control"
                            value="{{ old('PhoneNumber', $doctor->PhoneNumber) }}"
                            required
                        >

                    </div>


                    <!-- Email -->
                    <div class="col-md-6 mb-3">

                        <label class="font-weight-bold">
                            Email
                        </label>

                        <input
                            type="email"
                            name="Email"
                            class="form-control"
                            value="{{ old('Email', $doctor->Email) }}"
                            required
                        >

                    </div>


                    <!-- Qualifications -->
                    <div class="col-md-6 mb-3">

                        <label class="font-weight-bold">
                            Qualifications
                        </label>

                        <input
                            type="text"
                            name="Qualifications"
                            class="form-control"
                            value="{{ old('Qualifications', $doctor->Qualifications) }}"
                        >

                    </div>


                    <!-- Address -->
                    <div class="col-12 mb-3">

                        <label class="font-weight-bold">
                            Address
                        </label>

                        <textarea
                            name="Address"
                            class="form-control"
                            rows="3"
                        >{{ old('Address', $doctor->Address) }}</textarea>

                    </div>

                </div>


                <!-- Save -->
                <div class="mt-3">

                    <button
                        type="submit"
                        class="btn btn-primary px-4"
                    >

                        <i class="fas fa-save mr-2"></i>

                        Save Changes

                    </button>

                </div>

            </form>

        </div>

    </div>

</x-layouts.doctor>
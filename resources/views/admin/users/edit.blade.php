@extends('components.layouts.admin.master')

@section('content')
<<<<<<< HEAD
<div class="max-w-4xl mx-auto">
    <!-- Header Title -->
    <div class="mb-6 flex justify-between items-center">
=======
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header Title -->
    <div class="flex justify-between items-center">
>>>>>>> 9055961252df2b6344616ae09933e26c5b164dd2
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Edit Account User</h1>
            <p class="text-slate-500 text-sm">Update user information in the system</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="text-slate-600 hover:text-slate-900 text-sm font-medium flex items-center">
            <i class="fa-solid fa-arrow-left mr-1.5"></i> Account List
        </a>
    </div>

    <!-- Alert Thông báo lỗi -->
    @if($errors->any())
<<<<<<< HEAD
    <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
=======
    <div class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
>>>>>>> 9055961252df2b6344616ae09933e26c5b164dd2
        <ul class="list-disc pl-5 space-y-1">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Card Form -->
    <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
<<<<<<< HEAD
        @php
        // 1. Xác định ID người dùng
        $userId = $user->UserId ?? $user->DoctorId ?? $user->id;

        // 2. Xác định Loại tài khoản ban đầu để binding Dropdown Role
        $defaultRole = old('role');
        if (!$defaultRole) {
        if (($user->AccountType ?? '') === 'doctor' || ($user->Role ?? 0) == 3) {
        $defaultRole = 'Doctor';
        } elseif (($user->Role ?? 0) == 1) {
        $defaultRole = 'Admin';
        } else {
        $defaultRole = 'Patient';
        }
        }
        @endphp

        <form action="{{ route('admin.users.update', $userId) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Hidden input lưu AccountType ban đầu để Controller biết bảng cần update -->
            <input type="hidden" name="account_type" value="{{ $user->AccountType ?? 'account' }}">
=======
        <form action="{{ route('admin.users.update', $user->UserId) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            @php
            $selectedRole = old('role', $user->Role == 1 ? 'Admin' : 'Patient');
            @endphp
>>>>>>> 9055961252df2b6344616ae09933e26c5b164dd2

            <!-- 1. Chọn Vai Trò (Dropdown) -->
            <div>
                <label for="role" class="block text-sm font-semibold text-slate-700 mb-2">Account Role <span class="text-red-500">*</span></label>
<<<<<<< HEAD
                <select id="role" name="role" onchange="toggleDoctorFields()" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white text-slate-800">
                    <option value="Patient" {{ $defaultRole === 'Patient' ? 'selected' : '' }}>Patient</option>
                    <option value="Admin" {{ $defaultRole === 'Admin' ? 'selected' : '' }}>Administrator</option>
                    <option value="Doctor" {{ $defaultRole === 'Doctor' ? 'selected' : '' }}>Doctor</option>
                </select>
            </div>

            <!-- 2. Thông tin cơ bản -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Full Name / Doctor Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $user->FullName ?? $user->DoctorName ?? $user->Username) }}" placeholder="Enter full name..." required
                    class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-slate-800">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Email Address <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email', $user->Email ?? $user->email) }}" placeholder="Enter email address..." required
=======
                <select id="role" name="role" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white text-slate-800" required>
                    <option value="Patient" {{ $selectedRole === 'Patient' ? 'selected' : '' }}>Patient (Bệnh nhân)</option>
                    <option value="Admin" {{ $selectedRole === 'Admin' ? 'selected' : '' }}>Administrator (Quản trị viên)</option>
                </select>
            </div>

            <!-- 2. Họ và tên -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Full Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $user->FullName) }}" placeholder="Enter full name..." required
                    class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-slate-800">
            </div>

            <!-- 3. Email & Username -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Email Address <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email', $user->Email) }}" placeholder="Enter email address..." required
>>>>>>> 9055961252df2b6344616ae09933e26c5b164dd2
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-slate-800">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Username <span class="text-red-500">*</span></label>
<<<<<<< HEAD
                    <input type="text" name="username" value="{{ old('username', $user->Username ?? $user->DoctorAccount) }}" placeholder="Enter username..." required
=======
                    <input type="text" name="username" value="{{ old('username', $user->Username) }}" placeholder="Enter username..." required
>>>>>>> 9055961252df2b6344616ae09933e26c5b164dd2
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-slate-800">
                </div>
            </div>

<<<<<<< HEAD
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">New Password <span class="text-xs text-slate-400 font-normal">(Leave blank to keep current password)</span></label>
=======
            <!-- 4. Mật khẩu mới (Không bắt buộc) -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    New Password <span class="text-xs text-slate-400 font-normal">(Leave blank to keep current password)</span>
                </label>
>>>>>>> 9055961252df2b6344616ae09933e26c5b164dd2
                <input type="password" name="password" placeholder="Enter new password..."
                    class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-slate-800">
            </div>

<<<<<<< HEAD
            <!-- 3. Thông tin bổ sung riêng cho Bác sĩ (Hiện khi chọn Doctor) -->
            <div id="doctor-fields" class="space-y-6 pt-4 border-t border-slate-100 hidden">
                <div class="bg-blue-50 p-3 rounded-lg text-blue-800 font-semibold text-sm flex items-center">
                    <i class="fa-solid fa-user-doctor mr-2 text-blue-600"></i> Additional information for Doctor accounts
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Phone Number</label>
                        <input type="text" name="phone_number" value="{{ old('phone_number', $user->PhoneNumber ?? '') }}" placeholder="Enter phone number..."
                            class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-slate-800">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Gender</label>
                        @php $currentGender = old('Gender', $user->Gender ?? 'Male'); @endphp
                        <select name="Gender" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white text-slate-800">
                            <option value="Male" {{ $currentGender === 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ $currentGender === 'Female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Qualifications</label>
                        <input type="text" name="qualifications" value="{{ old('qualifications', $user->Qualifications ?? '') }}" placeholder="Master's / Doctorate"
                            class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-slate-800">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Specialization</label>
                        <select name="specialization_id" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white text-slate-800">
                            <option value="">-- Select Specialization --</option>
                            @if(isset($specializations))
                            @foreach($specializations as $spec)
                            @php
                            $sId = $spec->SpecializationId ?? $spec->id ?? '';
                            $sName = $spec->SpecializationName ?? $spec->Name ?? '';
                            $selectedSpec = old('specialization_id', $user->SpecializationId ?? '');
                            @endphp
                            <option value="{{ $sId }}" {{ $selectedSpec == $sId ? 'selected' : '' }}>
                                {{ $sName }}
                            </option>
                            @endforeach
                            @endif
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">City</label>
                        <select name="city_id" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white text-slate-800">
                            <option value="">-- Select City --</option>
                            @if(isset($cities))
                            @foreach($cities as $city)
                            @php
                            $cId = $city->CityId ?? $city->id ?? '';
                            $cName = $city->City ?? $city->CityName ?? '';
                            $selectedCity = old('city_id', $user->CityId ?? '');
                            @endphp
                            <option value="{{ $cId }}" {{ $selectedCity == $cId ? 'selected' : '' }}>
                                {{ $cName }}
                            </option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Detailed Address</label>
                    <input type="text" name="address" value="{{ old('address', $user->Address ?? '') }}" placeholder="Enter detailed address..."
=======
            <!-- 5. Giới tính & Địa chỉ -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Gender</label>
                    @php $currentGender = old('gender', $user->Gender); @endphp
                    <select name="gender" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white text-slate-800">
                        <option value="">-- Select Gender --</option>
                        <option value="Male" {{ $currentGender === 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ $currentGender === 'Female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Address</label>
                    <input type="text" name="address" value="{{ old('address', $user->Address) }}" placeholder="Enter detailed address..."
>>>>>>> 9055961252df2b6344616ae09933e26c5b164dd2
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-slate-800">
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end pt-4 border-t border-slate-100">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2.5 rounded-lg shadow transition flex items-center">
                    <i class="fa-solid fa-pen-to-square mr-2"></i> Update Account
                </button>
            </div>
        </form>
    </div>
</div>
<<<<<<< HEAD

<!-- JavaScript hiện/ẩn thông tin Bác sĩ -->
<script>
    function toggleDoctorFields() {
        const roleSelect = document.getElementById('role');
        const doctorFields = document.getElementById('doctor-fields');

        if (roleSelect && doctorFields) {
            if (roleSelect.value === 'Doctor') {
                doctorFields.classList.remove('hidden');
            } else {
                doctorFields.classList.add('hidden');
            }
        }
    }

    // Tự động kiểm tra khi vừa tải xong trang
    document.addEventListener('DOMContentLoaded', function() {
        toggleDoctorFields();
    });
</script>
=======
>>>>>>> 9055961252df2b6344616ae09933e26c5b164dd2
@endsection
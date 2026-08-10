@extends('components.layouts.admin.master')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header Title -->
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Create new account</h1>
            <p class="text-slate-500 text-sm">Add new Administrator, Doctor or Patient accounts to the system</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="text-slate-600 hover:text-slate-900 text-sm font-medium flex items-center">
            <i class="fa-solid fa-arrow-left mr-1.5"></i> Account List
        </a>
    </div>

    <!-- Alert Thông báo lỗi -->
    @if($errors->any())
    <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
        <ul class="list-disc pl-5 space-y-1">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Card Form -->
    <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
        <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- 1. Chọn Vai Trò (Dropdown) -->
            <div>
                <label for="role" class="block text-sm font-semibold text-slate-700 mb-2">Account Role <span class="text-red-500">*</span></label>
                <select id="role" name="role" onchange="toggleDoctorFields()" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white text-slate-800">
                    <option value="Patient" {{ old('role') == 'Patient' ? 'selected' : '' }}>Patient</option>
                    <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Administrator</option>
                    <option value="Doctor" {{ old('role') == 'Doctor' ? 'selected' : '' }}>Doctor</option>
                </select>
            </div>
            <!-- <div>
                <label class="block text-sm font-semibold text-slate-700 mb-3">Vai trò tài khoản <span class="text-red-500">*</span></label>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                    Bệnh nhân
                    <label class="relative flex items-center p-4 border border-slate-200 rounded-xl cursor-pointer hover:border-blue-400 transition bg-white has-[:checked]:border-blue-600 has-[:checked]:bg-blue-50/50">
                        <input type="radio" name="role" value="Patient" onchange="toggleDoctorFields()" class="peer sr-only" {{ old('role', 'Patient') === 'Patient' ? 'checked' : '' }}>
                        <div class="w-5 h-5 border-2 border-slate-300 rounded-full mr-3 flex items-center justify-center peer-checked:border-blue-600 peer-checked:bg-blue-600 transition">
                            <div class="w-2 h-2 bg-white rounded-full"></div>
                        </div>
                        <div>
                            <div class="font-semibold text-slate-800 text-sm">Bệnh nhân</div>
                            <div class="text-xs text-slate-400">Tài khoản người dùng</div>
                        </div>
                    </label>

                    Bác sĩ
                    <label class="relative flex items-center p-4 border border-slate-200 rounded-xl cursor-pointer hover:border-blue-400 transition bg-white has-[:checked]:border-blue-600 has-[:checked]:bg-blue-50/50">
                        <input type="radio" name="role" value="Doctor" onchange="toggleDoctorFields()" class="peer sr-only" {{ old('role') === 'Doctor' ? 'checked' : '' }}>
                        <div class="w-5 h-5 border-2 border-slate-300 rounded-full mr-3 flex items-center justify-center peer-checked:border-blue-600 peer-checked:bg-blue-600 transition">
                            <div class="w-2 h-2 bg-white rounded-full"></div>
                        </div>
                        <div>
                            <div class="font-semibold text-slate-800 text-sm">Bác sĩ</div>
                            <div class="text-xs text-slate-400">Tài khoản bác sĩ tư vấn</div>
                        </div>
                    </label>

                    Quản trị viên
                    <label class="relative flex items-center p-4 border border-slate-200 rounded-xl cursor-pointer hover:border-blue-400 transition bg-white has-[:checked]:border-blue-600 has-[:checked]:bg-blue-50/50">
                        <input type="radio" name="role" value="Admin" onchange="toggleDoctorFields()" class="peer sr-only" {{ old('role') === 'Admin' ? 'checked' : '' }}>
                        <div class="w-5 h-5 border-2 border-slate-300 rounded-full mr-3 flex items-center justify-center peer-checked:border-blue-600 peer-checked:bg-blue-600 transition">
                            <div class="w-2 h-2 bg-white rounded-full"></div>
                        </div>
                        <div>
                            <div class="font-semibold text-slate-800 text-sm">Quản trị viên</div>
                            <div class="text-xs text-slate-400">Quyền quản trị hệ thống</div>
                        </div>
                    </label>

                </div>
            </div> -->

            <!-- 2. Thông tin cơ bản -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Full Name / Doctor Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Enter full name..." required
                    class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-slate-800">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Email Address <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter email address..." required
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-slate-800">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Username <span class="text-red-500">*</span></label>
                    <input type="text" name="username" value="{{ old('username') }}" placeholder="Enter username..." required
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-slate-800">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Password <span class="text-red-500">*</span></label>
                <input type="password" name="password" placeholder="Enter password..." required
                    class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-slate-800">
            </div>

            <!-- 3. Thông tin bổ sung riêng cho Bác sĩ (Hiện khi chọn Doctor) -->
            <div id="doctor-fields" class="space-y-6 pt-4 border-t border-slate-100 hidden">
                <div class="bg-blue-50 p-3 rounded-lg text-blue-800 font-semibold text-sm flex items-center">
                    <i class="fa-solid fa-user-doctor mr-2 text-blue-600"></i> Additional information for Doctor accounts
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Phone Number</label>
                        <input type="text" name="phone_number" value="{{ old('phone_number') }}" placeholder="Enter phone number..."
                            class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-slate-800">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Gender</label>
                        <select name="sex" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white text-slate-800">
                            <option value="Male" {{ old('sex') == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('sex') == 'Female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Qualifications</label>
                        <input type="text" name="qualifications" value="{{ old('qualifications') }}" placeholder="Master's / Doctorate"
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
                            $sId = $spec->SpecializationId ?? $spec->id ?? $spec->specialization_id ?? '';
                            $sName = $spec->SpecializationName ?? $spec->Name ?? $spec->name ?? $spec->specialization_name ?? '';
                            @endphp
                            <option value="{{ $sId }}" {{ old('specialization_id') == $sId ? 'selected' : '' }}>
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
                            <option value="{{ $city->CityId ?? $city->id }}" {{ old('city_id') == ($city->CityId ?? $city->id) ? 'selected' : '' }}>
                                {{ $city->City }}
                            </option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Detailed Address</label>
                    <input type="text" name="address" value="{{ old('address') }}" placeholder="Enter detailed address..."
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-slate-800">
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end pt-4 border-t border-slate-100">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2.5 rounded-lg shadow transition flex items-center">
                    <i class="fa-solid fa-user-plus mr-2"></i>Create Account
                </button>
            </div>
        </form>
    </div>
</div>

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
<!-- <script>
    function toggleDoctorFields() {
        // Lấy value của radio card đang được chọn
        const selectedRole = document.querySelector('input[name="role"]:checked')?.value;
        const doctorFields = document.getElementById('doctor-fields');

        if (doctorFields) {
            if (selectedRole === 'Doctor') {
                doctorFields.classList.remove('hidden');
            } else {
                doctorFields.classList.add('hidden');
            }
        }
    }

    // Tự động kích hoạt kiểm tra ngay khi load trang
    document.addEventListener('DOMContentLoaded', function() {
        toggleDoctorFields();
    });
</script> -->
@endsection
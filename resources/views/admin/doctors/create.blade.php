@extends('components.layouts.admin.master')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Add New Doctor</h1>
            <p class="text-slate-500 text-sm">Create a new doctor account and assign specialty/clinic room</p>
        </div>
        <a href="{{ route('admin.doctors.index') }}" class="text-slate-600 hover:text-slate-900 text-sm font-medium flex items-center">
            <i class="fa-solid fa-arrow-left mr-1.5"></i> Doctor List
        </a>
    </div>

    <!-- Alert Error -->
    @if($errors->any())
    <div class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
        <ul class="list-disc pl-5 space-y-1">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Form Container -->
    <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
        <form action="{{ route('admin.doctors.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- 1. Account Details -->
            <div class="space-y-4">
                <h2 class="text-base font-semibold text-slate-800 border-b border-slate-100 pb-2 flex items-center">
                    <i class="fa-solid fa-id-card text-blue-600 mr-2"></i> Account Details
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Doctor Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ request('name', old('name')) }}" placeholder="Enter doctor's name..." required
                            class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-slate-800">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Username <span class="text-red-500">*</span></label>
                        <input type="text" name="username" value="{{ request('username', old('username')) }}" placeholder="Enter doctor's username..." required
                            class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-slate-800">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Email Address <span class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ request('email', old('email')) }}" placeholder="Enter doctor's email..." required
                            class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-slate-800">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password" placeholder="Enter doctor's password..." required
                            class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-slate-800">
                    </div>
                </div>
            </div>

            <!-- 2. Professional & Location Details -->
            <div class="space-y-4 pt-4">
                <h2 class="text-base font-semibold text-slate-800 border-b border-slate-100 pb-2 flex items-center">
                    <i class="fa-solid fa-stethoscope text-blue-600 mr-2"></i> Professional & Location Details
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Phone Number <span class="text-red-500">*</span></label>
                        <input type="text" name="phone_number" value="{{ request('phone_number', old('phone_number')) }}" placeholder="Enter doctor's phone number..." required
                            class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-slate-800">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Gender</label>
                        @php $genderVal = request('gender', old('gender')); @endphp
                        <select name="gender" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white text-slate-800">
                            <option value="">-- Select Gender --</option>
                            <option value="Male" {{ $genderVal == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ $genderVal == 'Female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>

                    <!-- Chọn Specialization (Reload Form qua Controller) -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Specialization</label>
                        @php $currentSpec = request('specialization_id', $selectedSpecId ?? old('specialization_id')); @endphp
                        <select id="specialization_select" name="specialization_id"
                            data-action="{{ route('admin.doctors.create') }}"
                            onchange="this.form.method='GET'; this.form.action=this.dataset.action; this.form.submit();"
                            class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white text-slate-800">
                            <option value="">-- Select Specialization --</option>
                            @foreach($specializations as $spec)
                            <option value="{{ $spec->SpecializationId }}" {{ $currentSpec == $spec->SpecializationId ? 'selected' : '' }}>
                                {{ $spec->SpecializationName }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Chọn Clinic Room (Controller đã lọc theo Specialization) -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Clinic Room</label>
                        @php $currentRoom = request('room_id', old('room_id')); @endphp
                        <select id="room_select" name="room_id" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white text-slate-800">
                            <option value="">-- Select Clinic Room --</option>
                            @foreach($rooms as $room)
                            <option value="{{ $room->RoomId }}" {{ $currentRoom == $room->RoomId ? 'selected' : '' }}>
                                {{ $room->RoomName }} @if($room->RoomNumber) ({{ $room->RoomNumber }}) @endif
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Qualifications</label>
                        <input type="text" name="qualifications" value="{{ request('qualifications', old('qualifications')) }}" placeholder="PhD, Specialist Level II..."
                            class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-slate-800">
                    </div>

                    <!-- Thành phố / Tỉnh (Reload Form qua Controller) -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">City / Province</label>
                        @php $currentCityName = request('city_name', $selectedCity ?? old('city_name')); @endphp
                        <select id="city_filter" name="city_name"
                            data-action="{{ route('admin.doctors.create') }}"
                            onchange="this.form.method='GET'; this.form.action=this.dataset.action; this.form.submit();"
                            class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white text-slate-800">
                            <option value="">-- Select City --</option>
                            @foreach($cities as $city)
                            <option value="{{ $city->CityName }}" {{ $currentCityName == $city->CityName ? 'selected' : '' }}>
                                {{ $city->CityName }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Quận / Huyện (Controller đã lọc theo City) -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">District</label>
                        @php $currentCityId = request('city_id', old('city_id')); @endphp
                        <select id="district_select" name="city_id" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white text-slate-800">
                            <option value="">-- Select District --</option>
                            @foreach($districts as $district)
                            <option value="{{ $district->CityId }}" {{ $currentCityId == $district->CityId ? 'selected' : '' }}>
                                {{ $district->DistrictName }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Detailed Address</label>
                        <input type="text" name="address" value="{{ request('address', old('address')) }}" placeholder="Enter street address, building..."
                            class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-slate-800">
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end pt-4 border-t border-slate-100">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2.5 rounded-lg shadow transition flex items-center">
                    <i class="fa-solid fa-user-plus mr-2"></i> Create Doctor Account
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
@extends('components.layouts.admin.master')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header Title -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Edit Patient Account</h1>
            <p class="text-slate-500 text-sm">Update patient information in the system</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="text-slate-600 hover:text-slate-900 text-sm font-medium flex items-center">
            <i class="fa-solid fa-arrow-left mr-1.5"></i> Patient List
        </a>
    </div>

    <!-- Alert Thông báo lỗi -->
    @if($errors->any())
    <div class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
        <ul class="list-disc pl-5 space-y-1">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Card Form -->
    <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
        <form action="{{ route('admin.users.update', $user->UserId) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- 1. Full Name -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Patient's Full Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $user->FullName) }}" placeholder="Enter patient's full name..." required
                    class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-slate-800">
            </div>

            <!-- 2. Email & Username -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Patient's Email Address <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email', $user->Email) }}" placeholder="Enter patient's email address..." required
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-slate-800">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Patient's Username <span class="text-red-500">*</span></label>
                    <input type="text" name="username" value="{{ old('username', $user->Username) }}" placeholder="Enter patient's username..." required
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-slate-800">
                </div>
            </div>

            <!-- 3. Password mới (Không bắt buộc) -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    New Password <span class="text-xs text-slate-400 font-normal">(Leave blank to keep current password)</span>
                </label>
                <input type="password" name="password" placeholder="Enter new password..."
                    class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-slate-800">
            </div>

            <!-- 4. Gender & Address -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Patient's Gender</label>
                    @php $currentGender = old('gender', $user->Gender); @endphp
                    <select name="gender" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white text-slate-800">
                        <option value="">-- Select Gender --</option>
                        <option value="Male" {{ $currentGender === 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ $currentGender === 'Female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Patient's Address</label>
                    <input type="text" name="address" value="{{ old('address', $user->Address) }}" placeholder="Enter detailed address..."
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-slate-800">
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end pt-4 border-t border-slate-100">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2.5 rounded-lg shadow transition flex items-center">
                    <i class="fa-solid fa-pen-to-square mr-2"></i> Update Patient Account
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
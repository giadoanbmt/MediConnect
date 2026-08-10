@extends('components.layouts.admin.master')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Header Title -->
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Update Admin Account</h1>
            <p class="text-slate-500 text-sm">Manage and update your personal information</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="text-slate-600 hover:text-slate-900 text-sm font-medium">
            <i class="fa-solid fa-arrow-left mr-1"></i> Back toDashboard
        </a>
    </div>

    <!-- Alert Thông báo thành công / Lỗi -->
    @if(session('success'))
    <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg text-sm flex items-center">
        <i class="fa-solid fa-circle-check mr-2 text-emerald-500"></i>
        {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
        <ul class="list-disc pl-5 space-y-1">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Card Form Profile -->
    <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
        <form action="{{ route('admin.profile.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Avatar Preview & User Role Badge -->
            <div class="flex items-center space-x-4 pb-6 border-b border-slate-100">
                <div class="w-16 h-16 rounded-full bg-blue-600 text-white flex items-center justify-center text-2xl font-bold">
                    <i class="fa-solid fa-user-shield"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-slate-800">{{ auth()->user()->FullName ?? auth()->user()->Username ?? 'Administrator' }}</h2>
                    <span class="inline-block mt-1 px-2.5 py-0.5 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full">
                        Administrator
                    </span>
                </div>
            </div>

            <!-- 1. Họ và tên -->
            <div>
                <label for="FullName" class="block text-sm font-semibold text-slate-700 mb-2">Full Name <span class="text-red-500">*</span></label>
                <input type="text" id="FullName" name="FullName"
                    value="{{ old('FullName', auth()->user()->FullName ?? auth()->user()->Username ?? '') }}" required
                    placeholder="Enter full name..."
                    class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-slate-800">
            </div>

            <!-- 2. Email -->
            <div>
                <label for="Email" class="block text-sm font-semibold text-slate-700 mb-2">Email <span class="text-red-500">*</span></label>
                <input type="email" id="Email" name="Email"
                    value="{{ old('Email', auth()->user()->Email ?? auth()->user()->email ?? '') }}" required
                    placeholder="Enter email address..."
                    class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-slate-800">
            </div>

            <!-- 3. Mật khẩu mới -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-2">
                <div>
                    <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">New Password</label>
                    <input type="password" id="password" name="password"
                        placeholder="Leave blank if you do not want to change it..."
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-slate-800">
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-2">Confirm New Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        placeholder="Enter the new password again..."
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-slate-800">
                </div>
            </div>

            <!-- Nút Lưu -->
            <div class="flex justify-end pt-4 border-t border-slate-100">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2.5 rounded-lg shadow transition flex items-center">
                    <i class="fa-solid fa-floppy-disk mr-2"></i> Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
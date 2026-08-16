@extends('components.layouts.admin.master')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header Title -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Create New Patient Account</h1>
            <p class="text-slate-500 text-sm">Add a new Patient account to the system</p>
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
        <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- 1. Full Name -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Patient's Full Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Enter patient's full name..." required
                    class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-slate-800">
            </div>

            <!-- 2. Username + Gender -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Patient's Username <span class="text-red-500">*</span></label>
                    <input type="text" name="username" value="{{ old('username') }}" placeholder="Enter patient's username..." required
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-slate-800">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Patient's Gender</label>
                    <select name="gender" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white text-slate-800">
                        <option value="">-- Select Gender --</option>
                        <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>
            </div>

            <!-- 3. Email Address -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Patient's Email Address <span class="text-red-500">*</span></label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter patient's email address..." required
                    class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-slate-800">
            </div>

            <!-- 4. Password -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Password <span class="text-red-500">*</span></label>
                <input type="password" name="password" placeholder="Enter password..." required
                    class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-slate-800">
            </div>

            <!-- 5. Address -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Patient's Address</label>
                <input type="text" name="address" value="{{ old('address') }}" placeholder="Enter patient's detailed address..."
                    class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-slate-800">
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end pt-4 border-t border-slate-100">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2.5 rounded-lg shadow transition flex items-center">
                    <i class="fa-solid fa-user-plus mr-2"></i> Create Patient Account
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
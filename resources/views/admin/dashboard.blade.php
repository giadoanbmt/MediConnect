@extends('components.layouts.admin.master')

@section('content')
<!-- Page Title -->
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Dashboard</h1>
        <p class="text-slate-500 text-sm">Statistics of overall system activity</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-lg shadow transition">
        <i class="fa-solid fa-plus mr-1"></i> Create Account
    </a>
</div>

<!-- 4 Statistic Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold uppercase text-slate-500 tracking-wider">Patients</p>
            <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ number_format($totalPatients ?? 0) }}</h3>
        </div>
        <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center text-xl">
            <i class="fa-solid fa-user-injured"></i>
        </div>
    </div>

    <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold uppercase text-slate-500 tracking-wider">Doctors</p>
            <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ number_format($totalDoctors ?? 0) }}</h3>
        </div>
        <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center text-xl">
            <i class="fa-solid fa-user-md"></i>
        </div>
    </div>

    <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold uppercase text-slate-500 tracking-wider">Appointments</p>
            <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ number_format($totalAppointments ?? 0) }}</h3>
        </div>
        <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-lg flex items-center justify-center text-xl">
            <i class="fa-solid fa-calendar-check"></i>
        </div>
    </div>

    <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold uppercase text-slate-500 tracking-wider">Blogs</p>
            <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ number_format($totalArticles ?? 0) }}</h3>
        </div>
        <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-lg flex items-center justify-center text-xl">
            <i class="fa-solid fa-newspaper"></i>
        </div>
    </div>
</div>

<!-- Quick Actions Panel -->
<div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
    <h2 class="text-lg font-bold text-slate-800 mb-4">Management Shortcuts</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="{{ route('admin.users.index') }}" class="p-4 border border-slate-200 rounded-lg hover:border-blue-500 hover:bg-blue-50/50 transition group">
            <div class="font-semibold text-slate-800 group-hover:text-blue-600"><i class="fa-solid fa-users mr-2"></i> User List</div>
            <p class="text-xs text-slate-500 mt-1">View, manage permissions, and delete user accounts</p>
        </a>

        <a href="{{ route('admin.users.create') }}" class="p-4 border border-slate-200 rounded-lg hover:border-blue-500 hover:bg-blue-50/50 transition group">
            <div class="font-semibold text-slate-800 group-hover:text-blue-600"><i class="fa-solid fa-user-plus mr-2"></i> Create Account</div>
            <p class="text-xs text-slate-500 mt-1">Create doctor profiles, qualifications, and work locations</p>
        </a>

        <a href="{{ route('admin.blogs.create') }}" class="p-4 border border-slate-200 rounded-lg hover:border-blue-500 hover:bg-blue-50/50 transition group">
            <div class="font-semibold text-slate-800 group-hover:text-blue-600"><i class="fa-solid fa-pen-to-square mr-2"></i> Create Health News</div>
            <p class="text-xs text-slate-500 mt-1">Publish announcements and health advisory articles</p>
        </a>
    </div>
</div>
@endsection
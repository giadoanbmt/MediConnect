@extends('components.layouts.admin.master')

@section('content')
<div class="space-y-8">
    <!-- Page Header Title -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">System Dashboard</h1>
            <p class="text-slate-500 text-sm">Overview of system activity, statistics, and quick navigation</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.news.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2.5 rounded-lg shadow-sm transition inline-flex items-center">
                <i class="fa-solid fa-pen-to-square mr-2"></i> Create News
            </a>
            <a href="{{ route('admin.users.create') }}" class="bg-slate-800 hover:bg-slate-900 text-white text-sm font-semibold px-4 py-2.5 rounded-lg shadow-sm transition inline-flex items-center">
                <i class="fa-solid fa-user-plus mr-2"></i> Create Account
            </a>
        </div>
    </div>

    <!-- 4 Statistic Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Card 1: Patients -->
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase text-slate-500 tracking-wider">Patients</p>
                <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ number_format($totalPatients ?? 0) }}</h3>
            </div>
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-user-injured"></i>
            </div>
        </div>

        <!-- Card 2: Doctors -->
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase text-slate-500 tracking-wider">Doctors</p>
                <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ number_format($totalDoctors ?? 0) }}</h3>
            </div>
            <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-lg flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-user-md"></i>
            </div>
        </div>

        <!-- Card 3: Appointments -->
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase text-slate-500 tracking-wider">Appointments</p>
                <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ number_format($totalAppointments ?? 0) }}</h3>
            </div>
            <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-lg flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
        </div>

        <!-- Card 4: News Articles -->
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase text-slate-500 tracking-wider">News Articles</p>
                <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ number_format($totalNews ?? $totalArticles ?? 0) }}</h3>
            </div>
            <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-lg flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-newspaper"></i>
            </div>
        </div>
    </div>

    <!-- Quick Actions Panel -->
    <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
        <h2 class="text-lg font-bold text-slate-800 mb-4 flex items-center">
            <i class="fa-solid fa-bolt text-amber-500 mr-2"></i> Management Shortcuts
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Shortcut 1 -->
            <a href="{{ route('admin.users.index') }}" class="p-4 border border-slate-200 rounded-xl hover:border-blue-500 hover:bg-blue-50/50 transition group flex flex-col justify-between">
                <div>
                    <div class="font-semibold text-slate-800 group-hover:text-blue-600 flex items-center">
                        <i class="fa-solid fa-users mr-2 text-blue-500"></i> User List
                    </div>
                    <p class="text-xs text-slate-500 mt-1.5">View and manage system user accounts</p>
                </div>
                <span class="text-xs text-blue-600 font-medium mt-3 inline-block">Manage users &rarr;</span>
            </a>

            <!-- Shortcut 2 -->
            <a href="{{ route('admin.users.create') }}" class="p-4 border border-slate-200 rounded-xl hover:border-blue-500 hover:bg-blue-50/50 transition group flex flex-col justify-between">
                <div>
                    <div class="font-semibold text-slate-800 group-hover:text-blue-600 flex items-center">
                        <i class="fa-solid fa-user-plus mr-2 text-emerald-500"></i> Create Account
                    </div>
                    <p class="text-xs text-slate-500 mt-1.5">Register new doctors or admin accounts</p>
                </div>
                <span class="text-xs text-blue-600 font-medium mt-3 inline-block">Add account &rarr;</span>
            </a>

            <!-- Shortcut 3 -->
            <a href="{{ route('admin.news.index') }}" class="p-4 border border-slate-200 rounded-xl hover:border-blue-500 hover:bg-blue-50/50 transition group flex flex-col justify-between">
                <div>
                    <div class="font-semibold text-slate-800 group-hover:text-blue-600 flex items-center">
                        <i class="fa-solid fa-newspaper mr-2 text-amber-500"></i> All News Feed
                    </div>
                    <p class="text-xs text-slate-500 mt-1.5">View published health articles & news</p>
                </div>
                <span class="text-xs text-blue-600 font-medium mt-3 inline-block">View articles &rarr;</span>
            </a>

            <!-- Shortcut 4 -->
            <a href="{{ route('admin.news.create') }}" class="p-4 border border-slate-200 rounded-xl hover:border-blue-500 hover:bg-blue-50/50 transition group flex flex-col justify-between">
                <div>
                    <div class="font-semibold text-slate-800 group-hover:text-blue-600 flex items-center">
                        <i class="fa-solid fa-pen-to-square mr-2 text-purple-500"></i> Post New Article
                    </div>
                    <p class="text-xs text-slate-500 mt-1.5">Publish new announcements and medical advice</p>
                </div>
                <span class="text-xs text-blue-600 font-medium mt-3 inline-block">Write post &rarr;</span>
            </a>
        </div>
    </div>
</div>
@endsection
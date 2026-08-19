<aside class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-900 text-white transition-all duration-300 flex flex-col justify-between">
    <div class="flex flex-col flex-1 min-h-0">
        <!-- Logo Header -->
        <div class="flex items-center justify-center h-16 border-b border-slate-800 px-6 shrink-0">
            <i class="fa-solid fa-hospital-user text-blue-500 text-2xl mr-3"></i>
            <span class="text-lg font-bold tracking-wide">MediConnect</span>
        </div>

        <!-- Navigation Links (Thêm overflow-y-auto để cuộn mượt mà) -->
        <nav class="p-4 space-y-1 text-sm font-medium overflow-y-auto flex-1">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2.5 text-slate-300 hover:bg-slate-800 hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white font-semibold' : '' }}">
                <i class="fa-solid fa-chart-pie w-6 text-center mr-2"></i>
                <span>Dashboard</span>
            </a>

            <!-- Medical and System Configuration -->
            <div class="pt-4 pb-1 px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider">Medical & System Config</div>

            <a href="{{ route('admin.specializations.index') }}" class="flex items-center px-4 py-2.5 text-slate-300 hover:bg-slate-800 hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.specializations.*') ? 'bg-blue-600 text-white font-semibold' : '' }}">
                <i class="fa-solid fa-stethoscope w-6 text-center mr-2"></i>
                <span>Specializations & Rooms</span>
            </a>

            <a href="{{ route('admin.cities.index') }}" class="flex items-center px-4 py-2.5 text-slate-300 hover:bg-slate-800 hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.cities.*') ? 'bg-blue-600 text-white font-semibold' : '' }}">
                <i class="fa-solid fa-city w-6 text-center mr-2"></i>
                <span>Cities & Districts</span>
            </a>

            <!-- Users & Doctors -->
            <div class="pt-4 pb-1 px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider">Users & Doctors</div>

            <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-2.5 text-slate-300 hover:bg-slate-800 hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.users.index') ? 'bg-blue-600 text-white font-semibold' : '' }}">
                <i class="fa-solid fa-users w-6 text-center mr-2"></i>
                <span>Patients List</span>
            </a>

            <a href="{{ Route::has('admin.doctors.index') ? route('admin.doctors.index') : '#' }}" class="flex items-center px-4 py-2.5 text-slate-300 hover:bg-slate-800 hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.doctors.*') ? 'bg-blue-600 text-white font-semibold' : '' }}">
                <i class="fa-solid fa-user-doctor w-6 text-center mr-2"></i>
                <span>Doctors List</span>
            </a>

            <a href="{{ route('admin.users.create') }}" class="flex items-center px-4 py-2.5 text-slate-300 hover:bg-slate-800 hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.users.create') ? 'bg-blue-600 text-white font-semibold' : '' }}">
                <i class="fa-solid fa-user-plus w-6 text-center mr-2"></i>
                <span>Create Account</span>
            </a>

            <!-- Appointments -->
            <div class="pt-4 pb-1 px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider">Appointments</div>

            <a href="{{ route('admin.appointments.index') }}" class="flex items-center px-4 py-2.5 text-slate-300 hover:bg-slate-800 hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.appointments.*') ? 'bg-blue-600 text-white font-semibold' : '' }}">
                <i class="fa-solid fa-calendar-check w-6 text-center mr-2"></i>
                <span>Appointments List</span>
            </a>

            <!-- News & Content -->
            <div class="pt-4 pb-1 px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider">News & Content</div>

            <a href="{{ route('admin.news.index') }}" class="flex items-center px-4 py-2.5 text-slate-300 hover:bg-slate-800 hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.news.index') ? 'bg-blue-600 text-white font-semibold' : '' }}">
                <i class="fa-solid fa-newspaper w-6 text-center mr-2"></i>
                <span>All News</span>
            </a>

            <a href="{{ route('admin.news.create') }}" class="flex items-center px-4 py-2.5 text-slate-300 hover:bg-slate-800 hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.news.create') ? 'bg-blue-600 text-white font-semibold' : '' }}">
                <i class="fa-solid fa-pen-to-square w-6 text-center mr-2"></i>
                <span>Create Post</span>
            </a>

            <!-- Support & Inquiries -->
            <div class="pt-4 pb-1 px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider">Support & Inquiries</div>

            <a href="{{ route('admin.contact.index') }}" class="flex items-center px-4 py-2.5 text-slate-300 hover:bg-slate-800 hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.contact.*') ? 'bg-blue-600 text-white font-semibold' : '' }}">
                <i class="fa-solid fa-comments w-6 text-center mr-2"></i>
                <span>Contact Queries</span>
            </a>

            <!-- Account Settings -->
            <div class="pt-4 pb-1 px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider">Account Settings</div>

            <a href="{{ route('admin.profile.edit') }}" class="flex items-center px-4 py-2.5 text-slate-300 hover:bg-slate-800 hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.profile.*') ? 'bg-blue-600 text-white font-semibold' : '' }}">
                <i class="fa-solid fa-id-card w-6 text-center mr-2"></i>
                <span>Personal Profile</span>
            </a>
        </nav>
    </div>

    <!-- Footer Sidebar -->
    <div class="p-4 border-t border-slate-800 text-xs text-slate-500 text-center shrink-0">
        MediConnect Admin
    </div>
</aside>
<aside class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-900 text-white transition-all duration-300">
    <!-- Brand Logo -->
    <div class="flex items-center justify-center h-16 border-b border-slate-800 px-6">
        <i class="fa-solid fa-hospital-user text-blue-400 text-2xl mr-3"></i>
        <span class="text-lg font-bold tracking-wide">MediConnect</span>
    </div>

    <!-- Navigation Menu -->
    <nav class="p-4 space-y-1 text-sm font-medium">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 text-slate-200 hover:bg-slate-800 hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white font-semibold' : '' }}">
            <i class="fa-solid fa-chart-line w-6 text-center mr-2"></i>
            <span>Dashboard</span>
        </a>

        <div class="pt-4 pb-1 px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider">System Management</div>

        <!-- 1. Nút "Quản lý Tài khoản" (Chỉ active khi đúng trang Index) -->
        <a href="{{ route('admin.users.index') }}"
            class="flex items-center px-4 py-3 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.users.index') ? 'bg-blue-600 text-white font-semibold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <i class="fa-solid fa-users mr-3"></i>Account Management
        </a>

        <!-- 2. Nút "Tạo Tài khoản mới" (Chỉ active khi đúng trang Create) -->
        <a href="{{ route('admin.users.create') }}"
            class="flex items-center px-4 py-3 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.users.create') ? 'bg-blue-600 text-white font-semibold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <i class="fa-solid fa-user-plus mr-3"></i> Create Account
        </a>

        <a href="{{ route('admin.blogs.create') }}" class="flex items-center px-4 py-3 text-slate-300 hover:bg-slate-800 hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.blogs.*') ? 'bg-blue-600 text-white' : '' }}">
            <i class="fa-solid fa-newspaper w-6 text-center mr-2"></i>
            <span>Create Health News</span>
        </a>

        <div class="pt-4 pb-1 px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider">Profile</div>

        <a href="{{ route('admin.profile.edit') }}" class="flex items-center px-4 py-3 text-slate-300 hover:bg-slate-800 hover:text-white rounded-lg transition-colors">
            <i class="fa-solid fa-id-card w-6 text-center mr-2"></i>
            <span>Personal Profile</span>
        </a>
    </nav>
</aside>
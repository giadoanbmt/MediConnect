<header class="bg-white border-b border-slate-200 px-6 py-3 sticky top-0 z-40 shadow-sm">
    <div class="flex items-center justify-between w-full">

        <!-- Bên trái: Tiêu đề trang / Breadcrumb -->
        <div class="flex items-center">
            <h2 class="text-base font-bold text-slate-800">Admin Dashboard</h2>
        </div>

        <!-- Bên phải: Lời chào & Nút Đăng xuất -->
        <div class="flex items-center space-x-4">
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.profile.edit') }}" class="flex items-center space-x-3 group">
                    <!-- Avatar Container -->
                    <div class="w-9 h-9 rounded-full overflow-hidden border border-slate-200 shrink-0 bg-slate-100 shadow-sm">
                        <img src="{{ (auth()->check() && (auth()->user()->AvatarUrl || auth()->user()->avatar)) ? asset(auth()->user()->AvatarUrl ?? auth()->user()->avatar) : asset('images/avatars/default-avatar.webp') }}"
                            alt="Default Avatar"
                            class="w-full h-full object-cover">
                    </div>

                    <!-- Tên Admin & Lời chào -->
                    <div class="text-left hidden sm:block">
                        <p class="text-xs text-slate-400">Hello,</p>
                        <p class="text-sm font-semibold text-slate-700 group-hover:text-blue-600 transition">
                            {{ auth()->user()->FullName ?? auth()->user()->Username ?? 'Admin' }}
                        </p>
                    </div>
                </a>
            </div>

            <!-- Vạch phân cách đứng -->
            <div class="h-4 w-px bg-slate-200"></div>

            <!-- Form & Nút Đăng xuất (btn_logout) -->
            <form action="{{ route('logout') }}" method="POST" class="inline m-0">
                @csrf
                <button type="submit" id="btn_logout" class="flex items-center text-sm font-medium text-slate-600 hover:text-red-600 bg-slate-100 hover:bg-red-50 px-3 py-1.5 rounded-lg transition-colors">
                    <i class="fa-solid fa-right-from-bracket mr-1.5 text-xs"></i>
                    <span>Logout</span>
                </button>
            </form>

        </div>
    </div>
</header>
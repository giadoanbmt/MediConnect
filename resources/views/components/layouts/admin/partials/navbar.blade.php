<header class="bg-white border-b border-slate-200 px-6 py-3 sticky top-0 z-40 shadow-sm">
    <div class="flex items-center justify-between w-full">

        <!-- Bên trái: Tiêu đề trang -->
        <div class="flex items-center">
            <h2 class="text-base font-bold text-slate-800">Dashboard</h2>
        </div>

        <!-- Bên phải: Tên tài khoản & Nút Đăng xuất -->
        <div class="flex items-center space-x-4">

            <!-- Tên User Admin -->
            <div class="flex items-center text-sm font-semibold text-slate-700">
                <i class="fa-solid fa-circle-user text-lg text-slate-500 mr-2"></i>
                <span>{{ auth()->user()->FullName ?? auth()->user()->Username ?? 'Admin' }}</span>
            </div>

            <!-- Vạch phân cách đứng -->
            <div class="h-4 w-px bg-slate-200"></div>

            <!-- Form Đăng xuất -->
            <form action="{{ route('logout') }}" method="POST" class="inline m-0">
                @csrf
                <button type="submit" class="flex items-center text-sm font-medium text-slate-600 hover:text-red-600 transition">
                    <i class="fa-solid fa-right-from-bracket mr-1.5"></i>
                    <span>Đăng xuất</span>
                </button>
            </form>

        </div>
    </div>
</header>
@extends('components.layouts.admin.master')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Header Title -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Update Profile</h1>
            <p class="text-slate-500 text-sm">Manage and update your personal information</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="text-slate-600 hover:text-slate-900 text-sm font-medium flex items-center">
            <i class="fa-solid fa-arrow-left mr-1.5"></i> Back to Dashboard
        </a>
    </div>

    <!-- Alert Thông báo thành công / Lỗi -->
    @if(session('success'))
    <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg text-sm flex justify-between items-center">
        <div class="flex items-center">
            <i class="fa-solid fa-circle-check mr-2 text-emerald-500"></i>
            <span>{{ session('success') }}</span>
        </div>
        <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    @endif

    @if($errors->any())
    <div class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
        <ul class="list-disc pl-5 space-y-1">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Card Form Profile -->
    <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
        <!-- Bắt buộc phải có enctype="multipart/form-data" để upload file -->
        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Khu vực Upload Avatar -->
            <div class="pb-6 border-b border-slate-100">
                <label class="block text-sm font-semibold text-slate-700 mb-3">Profile Picture</label>
                <div class="flex items-center space-x-5">
                    <!-- Khung Avatar Preview -->
                    <div class="relative w-20 h-20 rounded-full overflow-hidden bg-slate-100 border-2 border-slate-200 shrink-0">
                        <img id="avatar-preview"
                            src="{{ (auth()->user()->AvatarUrl || auth()->user()->avatar) ? asset(auth()->user()->AvatarUrl ?? auth()->user()->avatar) : asset('images/avatars/default-avatar.webp') }}"
                            alt="Default Avatar"
                            class="w-full h-full object-cover">
                    </div>

                    <!-- Nút chọn file ảnh -->
                    <div class="space-y-2">
                        <label for="avatar" class="cursor-pointer inline-flex items-center px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold rounded-lg transition border border-slate-300">
                            <i class="fa-solid fa-camera mr-2 text-slate-500"></i> Change Avatar
                        </label>
                        <input type="file" id="avatar" name="avatar" accept="image/*" class="hidden" onchange="previewImage(event)">
                        <p class="text-xs text-slate-400">JPG, PNG, GIF or WEBP.</p>
                        @if($user->AvatarUrl)
                        <div class="mt-2 flex items-center space-x-2">
                            <input type="checkbox" id="remove_avatar" name="remove_avatar" value="1" class="rounded text-red-600 border-slate-300 focus:ring-red-500">
                            <label for="remove_avatar" class="text-xs font-semibold text-red-600 cursor-pointer">
                                <i class="fa-solid fa-trash-can mr-1"></i> Delete current avatar
                            </label>
                        </div>
                        @endif
                    </div>
                </div>


            </div>

            <!-- 1. Full Name (Chỉnh name="name" để khớp với Controller) -->
            <div>
                <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">Full Name <span class="text-red-500">*</span></label>
                <input type="text" id="name" name="name"
                    value="{{ old('name', auth()->user()->FullName ?? auth()->user()->name ?? '') }}" required
                    placeholder="Enter full name..."
                    class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-slate-800">
            </div>

            <!-- 2. Username & Gender (Chỉnh name="username" và name="gender") -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="username" class="block text-sm font-semibold text-slate-700 mb-2">Username <span class="text-red-500">*</span></label>
                    <input type="text" id="username" name="username"
                        value="{{ old('username', auth()->user()->Username ?? auth()->user()->username ?? '') }}" required
                        placeholder="Enter username..."
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-slate-800">
                </div>

                <div>
                    <label for="gender" class="block text-sm font-semibold text-slate-700 mb-2">Gender</label>
                    <select id="gender" name="gender" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white text-slate-800">
                        <option value="">-- Select Gender --</option>
                        <option value="Male" {{ old('gender', auth()->user()->Gender ?? auth()->user()->gender ?? '') == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('gender', auth()->user()->Gender ?? auth()->user()->gender ?? '') == 'Female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>
            </div>

            <!-- 3. Email Address (Chỉnh name="email") -->
            <div>
                <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Email Address <span class="text-red-500">*</span></label>
                <input type="email" id="email" name="email"
                    value="{{ old('email', auth()->user()->Email ?? auth()->user()->email ?? '') }}" required
                    placeholder="Enter email address..."
                    class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-slate-800">
            </div>

            <!-- 4. Address (Chỉnh name="address") -->
            <div>
                <label for="address" class="block text-sm font-semibold text-slate-700 mb-2">Address</label>
                <input type="text" id="address" name="address"
                    value="{{ old('address', auth()->user()->Address ?? auth()->user()->address ?? '') }}"
                    placeholder="Enter detailed address..."
                    class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-slate-800">
            </div>

            <!-- 5. Change Password Section -->
            <div class="pt-4 border-t border-slate-100 space-y-4">
                <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Change Password</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">New Password</label>
                        <input type="password" id="password" name="password"
                            placeholder="Leave blank to keep current password..."
                            class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-slate-800">
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-2">Confirm New Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            placeholder="Re-enter new password..."
                            class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-slate-800">
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end pt-4 border-t border-slate-100">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2.5 rounded-lg shadow transition flex items-center">
                    <i class="fa-solid fa-floppy-disk mr-2"></i> Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Script Xem trước ảnh Avatar khi chọn file -->
<script>
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('avatar-preview');
                const placeholder = document.getElementById('avatar-placeholder');

                preview.src = e.target.result;
                preview.classList.remove('hidden');
                if (placeholder) {
                    placeholder.classList.add('hidden');
                }
            }
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection
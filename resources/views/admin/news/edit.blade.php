@extends('components.layouts.admin.master')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header Title -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Edit Health & News Post</h1>
            <p class="text-slate-500 text-sm">Update post details and content</p>
        </div>
        <a href="{{ route('admin.news.index') }}" class="text-slate-600 hover:text-slate-900 text-sm font-medium flex items-center">
            <i class="fa-solid fa-arrow-left mr-1.5"></i> News List
        </a>
    </div>

    <!-- Alert Thông báo Lỗi -->
    @if($errors->any())
    <div class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
        <ul class="list-disc pl-5 space-y-1">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Form Chỉnh Sửa Bài Viết -->
    <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
        <form action="{{ route('admin.news.update', $news->NewsId) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- 1. Tiêu đề bài viết -->
            <div>
                <label for="title" class="block text-sm font-semibold text-slate-700 mb-2">Post Title <span class="text-red-500">*</span></label>
                <input type="text" id="title" name="title" value="{{ old('title', $news->Title) }}" required placeholder="Enter post title..."
                    class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-slate-800">
            </div>

            <!-- 2. Chuyên mục & Hình ảnh đại diện -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Chuyên mục -->
                <div>
                    <label for="category" class="block text-sm font-semibold text-slate-700 mb-2">Category <span class="text-red-500">*</span></label>
                    @php $selectedCategory = old('category', $news->Category); @endphp
                    <select id="category" name="category" required
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white text-slate-800">
                        <option value="">-- Select category --</option>
                        <option value="Health & Lifestyle" {{ $selectedCategory == 'Health & Lifestyle' ? 'selected' : '' }}>Health & Lifestyle</option>
                        <option value="General Medicine" {{ $selectedCategory == 'General Medicine' ? 'selected' : '' }}>General Medicine</option>
                        <option value="Doctor Advice" {{ $selectedCategory == 'Doctor Advice' ? 'selected' : '' }}>Doctor Advice</option>
                        <option value="MediConnect News" {{ $selectedCategory == 'MediConnect News' ? 'selected' : '' }}>MediConnect News</option>
                    </select>
                </div>

                <!-- Up File Hình ảnh mới (Không bắt buộc) -->
                <div>
                    <label for="image" class="block text-sm font-semibold text-slate-700 mb-2">
                        Featured Image <span class="text-xs text-slate-400 font-normal">(Leave blank to keep current image)</span>
                    </label>
                    <input type="file" id="image" name="image" accept="image/*"
                        class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 border border-slate-300 rounded-lg cursor-pointer">

                    @if($news->ThumbnailUrl)
                    <div class="mt-2 w-48 h-36 shrink-0 rounded-lg overflow-hidden border border-slate-200 bg-slate-50">
                        <img src="{{ asset($news->ThumbnailUrl) }}" alt="{{ $news->Title }}" class="w-full h-full object-cover">
                    </div>
                    @endif
                </div>
            </div>

            <!-- 3. Nội dung bài viết -->
            <div>
                <label for="content" class="block text-sm font-semibold text-slate-700 mb-2">Content <span class="text-red-500">*</span></label>
                <textarea id="content" name="content" rows="8" required placeholder="Write your post content..."
                    class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-slate-800">{{ old('content', $news->Content) }}</textarea>
            </div>

            <!-- Nút gửi form -->
            <div class="flex justify-end pt-4 border-t border-slate-100">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2.5 rounded-lg shadow transition flex items-center">
                    <i class="fa-solid fa-pen-to-square mr-2"></i> Update Article
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
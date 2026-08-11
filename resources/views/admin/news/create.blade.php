@extends('components.layouts.admin.master')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header Title -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Create Health & News Post</h1>
            <p class="text-slate-500 text-sm">Create a new post to share health information with everyone.</p>
        </div>
        <a href="{{ route('admin.news.index') }}" class="text-slate-600 hover:text-slate-900 text-sm font-medium flex items-center">
            <i class="fa-solid fa-arrow-left mr-1.5"></i> News List
        </a>
    </div>

    <!-- Alert Errors -->
    @if($errors->any())
    <div class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
        <ul class="list-disc pl-5 space-y-1">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Create Post Form -->
    <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
        <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- 1. Post Title -->
            <div>
                <label for="title" class="block text-sm font-semibold text-slate-700 mb-2">Post Title <span class="text-red-500">*</span></label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" required placeholder="Enter post title..."
                    class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-slate-800">
            </div>

            <!-- 2. Category & Featured Image -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Category -->
                <div>
                    <label for="category" class="block text-sm font-semibold text-slate-700 mb-2">Category <span class="text-red-500">*</span></label>
                    <select id="category" name="category" required
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white text-slate-800">
                        <option value="">-- Select category --</option>
                        <option value="Health & Lifestyle" {{ old('category') == 'Health & Lifestyle' ? 'selected' : '' }}>Health & Lifestyle</option>
                        <option value="General Medicine" {{ old('category') == 'General Medicine' ? 'selected' : '' }}>General Medicine</option>
                        <option value="Doctor Advice" {{ old('category') == 'Doctor Advice' ? 'selected' : '' }}>Doctor Advice</option>
                        <option value="MediConnect News" {{ old('category') == 'MediConnect News' ? 'selected' : '' }}>MediConnect News</option>
                    </select>
                </div>

                <!-- Optional Featured Image -->
                <div>
                    <label for="image" class="block text-sm font-semibold text-slate-700 mb-2">
                        Featured Image
                    </label>
                    <input type="file" id="image" name="image" accept="image/*"
                        class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 border border-slate-300 rounded-lg cursor-pointer">
                </div>
            </div>

            <!-- 3. Extended Content Area (rows="14") -->
            <div>
                <label for="content" class="block text-sm font-semibold text-slate-700 mb-2">Content <span class="text-red-500">*</span></label>
                <textarea id="content" name="content" rows="14" required placeholder="Write your post content..."
                    class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-slate-800">{{ old('content') }}</textarea>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end pt-4 border-t border-slate-100">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2.5 rounded-lg shadow transition flex items-center">
                    <i class="fa-solid fa-paper-plane mr-2"></i> Publish Post
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
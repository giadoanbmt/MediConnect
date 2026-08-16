@extends('components.layouts.admin.master')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header Title & Back Button -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.news.index') }}" class="text-slate-600 hover:text-slate-900 text-sm font-medium flex items-center">
            <i class="fa-solid fa-arrow-left mr-1.5"></i> Back to News List
        </a>
        <div class="flex items-center space-x-2">
            <a href="{{ route('admin.news.edit', $news->NewsId) }}" class="bg-blue-50 text-blue-600 hover:bg-blue-100 px-3 py-1.5 rounded-lg text-xs font-semibold transition flex items-center">
                <i class="fa-solid fa-pen-to-square mr-1.5"></i> Edit Article
            </a>
        </div>
    </div>

    <!-- Article Detail Container -->
    <article class="bg-white rounded-xl border border-slate-200 p-8 shadow-sm space-y-6">
        <!-- Category & Title -->
        <div class="space-y-3">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                <i class="fa-solid fa-tag mr-1.5 text-xs"></i> {{ $news->Category ?? 'General News' }}
            </span>
            <h1 class="text-3xl font-extrabold text-slate-900 leading-tight">
                {{ $news->Title }}
            </h1>

            <!-- Meta Data -->
            <div class="flex items-center text-xs text-slate-500 space-x-4 pt-2 border-b border-slate-100 pb-4">
                <span class="flex items-center font-medium text-slate-700">
                    <i class="fa-regular fa-user mr-1.5 text-slate-400"></i> Author: {{ $news->AuthorName ?? 'Admin' }}
                </span>
                <span>•</span>
                <span class="flex items-center">
                    <i class="fa-regular fa-calendar-days mr-1.5 text-slate-400"></i>
                    Published at: {{ \Carbon\Carbon::parse($news->CreatedAt)->format('d/m/Y - H:i') }}
                </span>
            </div>
        </div>

        <!-- Featured Image -->
        <div class="w-full max-h-[450px] rounded-xl overflow-hidden border border-slate-100 bg-slate-50">
            <img src="{{ $news->ThumbnailUrl ? asset($news->ThumbnailUrl) : asset('images/thumbnails/news-placeholder.png') }}"
                alt="{{ $news->Title }}"
                class="w-full h-full object-cover">
        </div>

        <!-- Content Area -->
        <div class="text-slate-800 leading-relaxed text-base whitespace-pre-line space-y-4 pt-2">
            {!! e($news->Content) !!}
        </div>
    </article>
</div>
@endsection
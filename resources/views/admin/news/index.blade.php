@extends('components.layouts.admin.master')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <!-- Header Title, Search Form & Action Button -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-200">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Health & News Management</h1>
            <p class="text-slate-500 text-sm">Manage articles, health announcements, and news</p>
        </div>

        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
            <!-- Form Tìm Kiếm -->
            <form action="{{ route('admin.news.index') }}" method="GET" class="flex items-center gap-2">
                <div class="relative w-full sm:w-64">
                    <input type="text"
                        name="keyword"
                        value="{{ $keyword ?? '' }}"
                        placeholder="Search title, category, author..."
                        class="w-full pl-9 pr-8 py-2 text-sm bg-white border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>

                    @if(!empty($keyword))
                    <a href="{{ route('admin.news.index') }}"
                        class="absolute right-2.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 text-xs">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                    @endif
                </div>

                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition shadow-sm">
                    Search
                </button>
            </form>

            <a href="{{ route('admin.news.create') }}" class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2.5 rounded-lg transition shadow-sm whitespace-nowrap">
                <i class="fa-solid fa-pen-to-square mr-2"></i> Create New Post
            </a>
        </div>
    </div>

    <!-- Alert Notifications -->
    @if(session('success'))
    <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg text-sm flex justify-between items-center">
        <span>{{ session('success') }}</span>
        <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    @endif

    @if(session('error'))
    <div class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm flex justify-between items-center">
        <span>{{ session('error') }}</span>
        <button onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    @endif

    <!-- News Grid List -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($newsList as $item)
        <article class="bg-white rounded-xl border border-slate-200 shadow-sm hover:shadow-md transition flex flex-col overflow-hidden">
            <!-- Thumbnail Image -->
            <div class="relative h-48 w-full bg-slate-100 overflow-hidden">
                <img src="{{ $item->ThumbnailUrl ? asset($item->ThumbnailUrl) : asset('images/thumbnails/news-placeholder.png') }}"
                    alt="{{ $item->Title }}"
                    class="w-full h-full object-cover">
                <span class="absolute top-3 left-3 px-3 py-1 rounded-full text-xs font-semibold bg-white/90 backdrop-blur-sm text-blue-700 border border-blue-100 shadow-sm">
                    {{ $item->Category ?? 'News' }}
                </span>
            </div>

            <!-- Card Body -->
            <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
                <div class="space-y-2">
                    <h2 class="text-lg font-bold text-slate-900 line-clamp-2 hover:text-blue-600 transition leading-snug">
                        <a href="{{ route('admin.news.show', $item->NewsId) }}">{{ $item->Title }}</a>
                    </h2>
                </div>

                <!-- Meta & Action Button -->
                <div class="pt-4 border-t border-slate-100 space-y-3">
                    <div class="flex items-center justify-between text-xs text-slate-500">
                        <span class="flex items-center font-medium text-slate-700">
                            <i class="fa-regular fa-user mr-1.5 text-slate-400"></i> {{ $item->AuthorName ?? 'Admin' }}
                        </span>
                        <span class="flex items-center">
                            <i class="fa-regular fa-calendar-days mr-1.5 text-slate-400"></i>
                            {{ \Carbon\Carbon::parse($item->CreatedAt)->format('d/m/Y') }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between pt-1">
                        <a href="{{ route('admin.news.show', $item->NewsId) }}" class="inline-flex items-center text-xs font-semibold text-blue-600 hover:text-blue-800 transition">
                            Read More <i class="fa-solid fa-arrow-right ml-1 text-[10px]"></i>
                        </a>

                        <!-- Actions (Edit/Delete) -->
                        <div class="flex items-center space-x-1">
                            <a href="{{ route('admin.news.edit', $item->NewsId) }}" class="p-1.5 text-slate-400 hover:text-blue-600 transition" title="Edit Article">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <form action="{{ route('admin.news.destroy', $item->NewsId) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this article?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 text-slate-400 hover:text-red-600 transition" title="Delete Article">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </article>
        @empty
        <div class="col-span-full bg-white rounded-xl border border-slate-200 p-12 text-center text-slate-400">
            <i class="fa-regular fa-newspaper text-4xl mb-3 block"></i>
            <p class="text-base font-medium text-slate-600">
                @if(!empty($keyword))
                No news articles found matching "{{ $keyword }}".
                @else
                No news articles found.
                @endif
            </p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="pt-4">
        {{ $newsList->links() }}
    </div>
</div>
@endsection
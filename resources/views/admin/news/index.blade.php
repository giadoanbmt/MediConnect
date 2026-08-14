@extends('components.layouts.admin.master')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header Title & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-200">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Health & News Feed</h1>
            <p class="text-slate-500 text-sm">Manage articles, health announcements, and news</p>
        </div>
        <a href="{{ route('admin.news.create') }}" class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2.5 rounded-lg transition shadow-sm">
            <i class="fa-solid fa-pen-to-square mr-2"></i> Create New Post
        </a>
    </div>

    <!-- Alert Thông báo -->
    @if(session('success'))
    <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg text-sm flex justify-between items-center">
        <span>{{ session('success') }}</span>
        <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    @endif

    <!-- Article Feed List -->
    <div class="space-y-6">
        @forelse($newsList as $item)
        <article class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm hover:shadow-md transition">
            <!-- Top Row: Category Badge & Admin Action Buttons -->
            <div class="flex items-center justify-between mb-3">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                    <i class="fa-solid fa-tag mr-1.5 text-xs"></i> {{ $item->Category }}
                </span>

                <!-- Fast Actions (Edit / Delete) -->
                <div class="flex items-center space-x-2">
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

            <!-- Title -->
            <h2 class="text-xl font-bold text-slate-900 mb-3 leading-snug">
                {{ $item->Title }}
            </h2>

            <!-- Article Body -->
            <div class="flex flex-col md:flex-row gap-5 mb-4">
                @if($item->ThumbnailUrl)
                <div class="w-full md:w-48 h-36 shrink-0 rounded-lg overflow-hidden border border-slate-200 bg-slate-50">
                    <img src="{{ asset($item->ThumbnailUrl) }}" alt="{{ $item->Title }}" class="w-full h-full object-cover">
                </div>
                @endif

                <div class="flex-1 text-slate-600 text-sm leading-relaxed">
                    <!-- Nội dung rút gọn (Mặc định hiển thị) -->
                    <div id="excerpt-{{ $item->NewsId }}">
                        <p>{{ \Illuminate\Support\Str::limit(strip_tags($item->Content), 220, '...') }}</p>
                        @if(mb_strlen(strip_tags($item->Content)) > 220)
                        <button onclick="toggleContent({{ $item->NewsId }})" class="mt-2 inline-flex items-center text-xs font-semibold text-blue-600 hover:text-blue-800 transition">
                            Read full article <i class="fa-solid fa-chevron-down ml-1 text-[10px]"></i>
                        </button>
                        @endif
                    </div>

                    <!-- Nội dung đầy đủ (Mặc định ẩn) -->
                    <div id="full-content-{{ $item->NewsId }}" class="hidden space-y-3">
                        <div class="text-slate-700 whitespace-pre-line leading-relaxed">
                            {!! e($item->Content) !!}
                        </div>
                        <button onclick="toggleContent({{ $item->NewsId }})" class="mt-2 inline-flex items-center text-xs font-semibold text-slate-500 hover:text-slate-800 transition">
                            Show less <i class="fa-solid fa-chevron-up ml-1 text-[10px]"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Bottom Row: Meta Data -->
            <div class="pt-4 border-t border-slate-100 flex items-center text-xs text-slate-500 space-x-4">
                <span class="flex items-center font-medium text-slate-700">
                    <i class="fa-regular fa-user mr-1.5 text-slate-400"></i> {{ $item->AuthorName ?? 'MediConnect Admin' }}
                </span>
                <span>•</span>
                <span class="flex items-center">
                    <i class="fa-regular fa-calendar-days mr-1.5 text-slate-400"></i>
                    {{ \Carbon\Carbon::parse($item->CreatedAt)->format('d/m/Y - H:i') }}
                </span>
            </div>
        </article>
        @empty
        <div class="bg-white rounded-xl border border-slate-200 p-12 text-center text-slate-400">
            <i class="fa-regular fa-newspaper text-4xl mb-3 block"></i>
            <p class="text-base font-medium text-slate-600">No news articles found.</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="pt-4">
        {{ $newsList->links() }}
    </div>
</div>

<!-- Script xử lý Thu gọn / Mở rộng -->
<script>
    function toggleContent(newsId) {
        const excerpt = document.getElementById(`excerpt-${newsId}`);
        const fullContent = document.getElementById(`full-content-${newsId}`);

        if (excerpt && fullContent) {
            excerpt.classList.toggle('hidden');
            fullContent.classList.toggle('hidden');
        }
    }
</script>
@endsection
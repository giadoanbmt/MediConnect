@extends('doctor.layouts.dashboard')

@section('title', 'News - MediConnect')

@section('content')

<style>
    .news-page {
        --news-card: #16263d;
        --news-text: #f2f6fb;
        --news-muted: #aebdd0;
        --news-border: #30445f;
        --news-input: #101a29;
        --news-image-bg: #101f32;
        --news-primary: #3da9e0;
        --news-shadow: 0 8px 24px rgba(0, 0, 0, .16);
        color: var(--news-text);
    }

    .news-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .news-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 20px;
        gap: 20px;
    }

    .news-heading h2 {
        margin: 0;
        color: var(--news-text);
        font-size: 28px;
        font-weight: 700;
    }

    .news-heading p {
        margin: 5px 0 0;
        color: var(--news-muted);
        font-size: 13px;
    }

    .news-top-right {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .news-search {
        width: 230px;
        height: 38px;
        padding: 0 14px;
        border: 1px solid var(--news-border);
        border-radius: 6px;
        background: var(--news-input);
        color: var(--news-text);
        outline: none;
        font-size: 12px;
    }

    .news-search::placeholder {
        color: #9aa8b8;
    }

    .news-search:focus {
        border-color: var(--news-primary);
        box-shadow: 0 0 0 2px rgba(61, 169, 224, .12);
    }

    .create-news-btn {
        height: 38px;
        padding: 0 15px;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        border: none;
        border-radius: 5px;
        background: var(--news-primary);
        color: #fff;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
    }

    .create-news-btn:hover {
        background: #2998d1;
        color: #fff;
        text-decoration: none;
    }

    .featured-news {
        display: grid;
        grid-template-columns: 44% 56%;
        min-height: 320px;
        max-height: 340px;
        margin-bottom: 18px;
        overflow: hidden;
        border: 1px solid var(--news-border);
        border-radius: 8px;
        background: var(--news-card);
        box-shadow: var(--news-shadow);
    }

    .featured-image {
        width: 100%;
        height: 320px;
        display: block;
        object-fit: cover;
        background: var(--news-image-bg);
    }

    .featured-content {
        padding: 24px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        position: relative;
    }

    .article-top {
        display: flex;
        align-items: center;
        gap: 9px;
        margin-bottom: 10px;
    }

    .article-category {
        padding: 4px 9px;
        border-radius: 12px;
        background: rgba(61, 169, 224, .10);
        color: var(--news-primary);
        font-size: 10px;
        font-weight: 600;
    }

    .article-date {
        color: var(--news-muted);
        font-size: 10px;
    }

    .featured-content h3 {
        margin: 0 0 9px;
        color: var(--news-text);
        font-size: 21px;
        line-height: 1.35;
        font-weight: 700;
    }

    .featured-description {
        max-width: 560px;
        margin: 0;
        color: var(--news-muted);
        font-size: 12px;
        line-height: 1.55;
    }

    .featured-actions {
        position: absolute;
        top: 13px;
        right: 13px;
        display: flex;
        gap: 6px;
    }

    .edit-btn,
    .delete-btn {
        height: 28px;
        padding: 0 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        border-radius: 4px;
        font-size: 10px;
    }

    .edit-btn {
        border: 1px solid #315b7e;
        background: #122d47;
        color: #7fc9ef;
        text-decoration: none;
    }

    .edit-btn:hover {
        background: #173b5b;
        color: #a9ddf7;
        text-decoration: none;
    }

    .delete-btn {
        border: 1px solid #633b45;
        background: #35232c;
        color: #f27c86;
        cursor: pointer;
    }

    .news-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px;
    }

    .news-card {
        overflow: hidden;
        border: 1px solid var(--news-border);
        border-radius: 8px;
        background: var(--news-card);
        box-shadow: var(--news-shadow);
    }

    .news-card-image {
        width: 100%;
        height: 135px;
        display: block;
        object-fit: cover;
        background: var(--news-image-bg);
    }

    .news-card-body {
        padding: 14px;
    }

    .news-card-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 7px;
        margin-bottom: 8px;
    }

    .card-category {
        padding: 4px 8px;
        border-radius: 10px;
        background: rgba(61, 169, 224, .10);
        color: var(--news-primary);
        font-size: 9px;
        font-weight: 600;
    }

    .card-date {
        color: var(--news-muted);
        font-size: 9px;
    }

    .news-card h4 {
        min-height: 42px;
        margin: 0 0 12px;
        color: var(--news-text);
        font-size: 14px;
        line-height: 1.4;
        font-weight: 700;
    }

    .news-card-bottom {
        display: flex;
        justify-content: flex-end;
        align-items: center;
    }

    .card-actions {
        display: flex;
        gap: 5px;
    }

    .card-action {
        width: 28px;
        height: 26px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--news-border);
        border-radius: 4px;
        background: var(--news-input);
        color: var(--news-primary);
        text-decoration: none;
        font-size: 10px;
    }

    .card-action:hover {
        background: rgba(61, 169, 224, .08);
        color: var(--news-primary);
        text-decoration: none;
    }

    .card-action.delete {
        border-color: #633b45;
        background: #35232c;
        color: #f27c86;
        cursor: pointer;
    }

    .news-bottom {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 18px;
        color: var(--news-muted);
        font-size: 10px;
    }

    .pagination {
        display: flex;
        align-items: center;
        gap: 5px;
        margin: 0;
    }

    .page-btn {
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--news-border);
        border-radius: 4px;
        background: var(--news-input);
        color: var(--news-muted);
        font-size: 10px;
    }

    .page-btn.active {
        background: var(--news-primary);
        border-color: var(--news-primary);
        color: #fff;
    }

    .delete-modal {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 9999;
        align-items: center;
        justify-content: center;
    }

    .delete-modal.show {
        display: flex;
    }

    .delete-modal-overlay {
        position: absolute;
        inset: 0;
        background: rgba(5, 15, 30, .65);
        backdrop-filter: blur(3px);
    }

    .delete-modal-box {
        position: relative;
        width: 400px;
        max-width: calc(100% - 30px);
        padding: 28px;
        border: 1px solid var(--news-border);
        border-radius: 10px;
        background: var(--news-card);
        color: var(--news-text);
        box-shadow: 0 20px 60px rgba(0, 0, 0, .25);
        text-align: center;
    }

    .delete-modal-icon {
        width: 52px;
        height: 52px;
        margin: 0 auto 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: rgba(217, 83, 95, .12);
        color: #d9535f;
        font-size: 20px;
    }

    .delete-modal-box h3 {
        margin: 0 0 8px;
        font-size: 19px;
        font-weight: 700;
    }

    .delete-modal-box p {
        margin: 0 0 4px;
        font-size: 13px;
    }

    .delete-modal-box span {
        color: var(--news-muted);
        font-size: 11px;
    }

    .delete-modal-actions {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-top: 24px;
    }

    .modal-cancel,
    .modal-delete {
        min-width: 90px;
        height: 36px;
        padding: 0 16px;
        border-radius: 5px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
    }

    .modal-cancel {
        border: 1px solid var(--news-border);
        background: var(--news-input);
        color: var(--news-text);
    }

    .modal-delete {
        border: 1px solid #d9535f;
        background: #d9535f;
        color: #fff;
    }

    @media (max-width: 1000px) {
        .featured-news {
            grid-template-columns: 1fr;
            max-height: none;
        }

        .featured-image {
            height: 230px;
        }

        .news-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 700px) {
        .news-top {
            align-items: flex-start;
            flex-direction: column;
        }

        .news-top-right {
            width: 100%;
        }

        .news-search {
            width: 100%;
        }

        .news-grid {
            grid-template-columns: 1fr;
        }

        .news-bottom {
            align-items: flex-start;
            flex-direction: column;
            gap: 12px;
        }
    }
</style>

<div class="news-page">

    <div class="news-container">

        {{-- Header --}}
        <div class="news-top">

            <div class="news-heading">
                <h2>News</h2>
                <p>Latest medical news & health information</p>
            </div>

            <div class="news-top-right">

                <form
                    method="GET"
                    action="{{ route('doctor.news.index') }}"
                >
                    <input
                        type="text"
                        name="search"
                        class="news-search"
                        value="{{ request('search') }}"
                        placeholder="Search news..."
                    >
                </form>

                <a
                    href="{{ route('doctor.news.create') }}"
                    class="create-news-btn"
                >
                    <i class="fas fa-plus"></i>
                    Create News
                </a>

            </div>

        </div>

        {{-- News data --}}
        @if($news->count())

            @php
                $featured = $news->first();
                $otherNews = $news->skip(1);

                $featuredImage = data_get($featured, 'Image')
                    ?: data_get($featured, 'ThumbnailUrl');

                $placeholder = 'images/thumbnails/news-placeholder.png';
            @endphp

            {{-- Featured news --}}
            <div class="featured-news">

                <div>

                    {{-- Featured image --}}
                    @if($featuredImage)

                        <img
                            src="{{ asset($featuredImage) }}"
                            class="featured-image"
                            alt="{{ $featured->Title }}"
                            onerror="this.onerror=null;this.src='{{ asset($placeholder) }}';"
                        >

                    @else

                        <img
                            src="{{ asset($placeholder) }}"
                            class="featured-image"
                            alt="News placeholder"
                        >

                    @endif

                </div>

                <div class="featured-content">

                    <div class="featured-actions">

                        <a
                            href="{{ route('doctor.news.edit', $featured->NewsId) }}"
                            class="edit-btn"
                        >
                            <i class="fas fa-edit"></i>
                            Edit
                        </a>

                        <button
                            type="button"
                            class="delete-btn"
                            onclick="openDeleteModal(
                                '{{ $featured->NewsId }}',
                                @js($featured->Title)
                            )"
                        >
                            <i class="fas fa-trash"></i>
                            Delete
                        </button>

                    </div>

                    <div class="article-top">

                        <span class="article-category">
                            {{ $featured->Category }}
                        </span>

                        <span class="article-date">
                            <i class="far fa-calendar-alt"></i>
                            {{ \Carbon\Carbon::parse($featured->CreatedAt)->format('d M Y') }}
                        </span>

                    </div>

                    <h3>
                        {{ $featured->Title }}
                    </h3>

                    <p class="featured-description">
                        {{ \Illuminate\Support\Str::limit(strip_tags($featured->Content), 180) }}
                    </p>

                    <a
                        href="{{ route('doctor.news.show', $featured->NewsId) }}"
                        class="edit-btn"
                        style="width: fit-content; margin-top: 12px;"
                        title="Read More"
                    >
                        <i class="fas fa-book-open"></i>
                        Read More
                    </a>

                </div>

            </div>

            {{-- Other news --}}
            @if($otherNews->count())

                <div class="news-grid">

                    @foreach($otherNews as $item)

    @php
        $itemImage = data_get($item, 'Image')
            ?: data_get($item, 'ThumbnailUrl');

        $newsImage = null;

        if ($itemImage) {
            $newsImagePath = ltrim(
                trim((string) $itemImage),
                '/'
            );

            if (file_exists(
                public_path($newsImagePath)
            )) {
                $newsImage = asset(
                    $newsImagePath
                );
            }
        }

        if (!$newsImage) {
            $newsImage = asset($placeholder);
        }
    @endphp

    <div class="news-card">

        <img
            src="{{ $newsImage }}"
            class="news-card-image"
            alt="{{ $item->Title }}"
            onerror="this.onerror=null;this.src='{{ asset($placeholder) }}';"
        >

        <div class="news-card-body">

            <div class="news-card-meta">

                <span class="card-category">
                    {{ $item->Category }}
                </span>

                <span class="card-date">
                    <i class="far fa-calendar-alt"></i>
                    {{ \Carbon\Carbon::parse($item->CreatedAt)->format('d M Y') }}
                </span>

            </div>

            <h4>
                {{ $item->Title }}
            </h4>

            <div class="news-card-bottom">

                <div class="card-actions">

                    <a
                        href="{{ route('doctor.news.show', $item->NewsId) }}"
                        class="card-action"
                        title="Read More"
                    >
                        <i class="fas fa-book-open"></i>
                    </a>

                    <a
                        href="{{ route('doctor.news.edit', $item->NewsId) }}"
                        class="card-action"
                        title="Edit"
                    >
                        <i class="fas fa-edit"></i>
                    </a>

                    <button
                        type="button"
                        class="card-action delete"
                        title="Delete"
                        onclick="openDeleteModal(
                            '{{ $item->NewsId }}',
                            @js($item->Title)
                        )"
                    >
                        <i class="fas fa-trash"></i>
                    </button>

                </div>

            </div>

        </div>

    </div>

@endforeach

                </div>

            @endif

            {{-- Result count --}}
            <div class="news-bottom">

                <div>
                    Showing 1 to {{ $news->count() }} of {{ $news->count() }} news
                </div>

                <div class="pagination">

    {{-- Previous --}}
    @if($news->onFirstPage())

        <button
            type="button"
            class="page-btn"
            disabled
        >
            <i class="fas fa-chevron-left"></i>
        </button>

    @else

        <a
            href="{{ $news->previousPageUrl() }}"
            class="page-btn"
        >
            <i class="fas fa-chevron-left"></i>
        </a>

    @endif


    {{-- Page numbers --}}
    @foreach($news->getUrlRange(1, $news->lastPage()) as $page => $url)

        @if($page == $news->currentPage())

            <span class="page-btn active">
                {{ $page }}
            </span>

        @else

            <a
                href="{{ $url }}"
                class="page-btn"
            >
                {{ $page }}
            </a>

        @endif

    @endforeach


    {{-- Next --}}
    @if($news->hasMorePages())

        <a
            href="{{ $news->nextPageUrl() }}"
            class="page-btn"
        >
            <i class="fas fa-chevron-right"></i>
        </a>

    @else

        <button
            type="button"
            class="page-btn"
            disabled
        >
            <i class="fas fa-chevron-right"></i>
        </button>

    @endif

</div>

            </div>

        @else

            {{-- Empty state --}}
            <div class="featured-news">

                <div>
                    <img
                        src="{{ asset('images/thumbnails/news-placeholder.png') }}"
                        class="featured-image"
                        alt="News placeholder"
                    >
                </div>

                <div class="featured-content">

                    <h3>
                        No news found
                    </h3>

                    <p class="featured-description">
                        There are currently no news articles available.
                    </p>

                </div>

            </div>

        @endif

    </div>

</div>

{{-- Delete modal --}}
<div
    id="deleteModal"
    class="delete-modal"
>

    <div
        class="delete-modal-overlay"
        onclick="closeDeleteModal()"
    ></div>

    <div class="delete-modal-box">

        <div class="delete-modal-icon">
            <i class="fas fa-trash"></i>
        </div>

        <h3>
            Delete News
        </h3>

        <p>
            Are you sure you want to delete this news?
        </p>

        <span id="deleteNewsTitle"></span>

        <form
            id="deleteNewsForm"
            method="POST"
        >

            @csrf
            @method('DELETE')

            <div class="delete-modal-actions">

                <button
                    type="button"
                    class="modal-cancel"
                    onclick="closeDeleteModal()"
                >
                    Cancel
                </button>

                <button
                    type="submit"
                    class="modal-delete"
                >
                    Delete
                </button>

            </div>

        </form>

    </div>

</div>

<script>
    // Open delete modal
    function openDeleteModal(id, title) {
        const modal = document.getElementById('deleteModal');
        const form = document.getElementById('deleteNewsForm');
        const titleElement = document.getElementById('deleteNewsTitle');

        form.action = "{{ url('/doctor/news') }}/" + id;
        titleElement.textContent = title;

        modal.classList.add('show');
    }

    // Close delete modal
    function closeDeleteModal() {
        document
            .getElementById('deleteModal')
            .classList.remove('show');
    }

    // Close with Escape
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeDeleteModal();
        }
    });
</script>

@endsection
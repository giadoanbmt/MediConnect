@extends('doctor.layouts.dashboard')

@section('title', 'News - MediConnect')

@section('content')

<style>
    .news-show {
        color: var(--doctor-text);
    }

    .news-show-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .back-news {
        color: var(--doctor-muted);
        text-decoration: none;
        font-size: 13px;
    }

    .back-news:hover {
        color: var(--accent-blue);
        text-decoration: none;
    }

    .edit-news {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 11px;
        border: 1px solid var(--doctor-border);
        border-radius: 5px;
        background: var(--doctor-card);
        color: var(--accent-blue);
        text-decoration: none;
        font-size: 12px;
        font-weight: 600;
    }

    .edit-news:hover {
        border-color: var(--accent-blue);
        color: var(--accent-blue);
        text-decoration: none;
    }

    .news-show-card {
        background: var(--doctor-card);
        border: 1px solid var(--doctor-border);
        border-radius: 8px;
        padding: 25px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, .08);
    }

    .news-category {
        display: inline-flex;
        align-items: center;
        padding: 5px 10px;
        border-radius: 12px;
        background: rgba(0, 136, 204, .10);
        color: var(--accent-blue);
        font-size: 10px;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .news-show-title {
        margin: 0 0 10px;
        color: var(--doctor-text);
        font-size: 28px;
        line-height: 1.35;
        font-weight: 700;
    }

    .news-meta {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        padding-bottom: 15px;
        border-bottom: 1px solid var(--doctor-border);
        color: var(--doctor-muted);
        font-size: 11px;
    }

    .news-meta span {
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .news-meta i {
        color: var(--accent-blue);
    }

    .news-featured-image {
    width: 100%;
    height: 300px;
    margin-top: 20px;
    display: block;
    object-fit: cover;
    border-radius: 7px;
    border: 1px solid var(--doctor-border);
    background: var(--doctor-status-bg);
}

    .news-image-placeholder {
        width: 100%;
        height: 300px;
        margin-top: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--doctor-border);
        border-radius: 7px;
        background: var(--doctor-status-bg);
        color: var(--accent-blue);
        font-size: 40px;
    }

    /*
     * Content được tạo từ editor.
     * Không dùng e() để HTML như <p>, <strong>...
     * được render thành nội dung thật.
     */
    .news-content {
        margin-top: 25px;
        color: var(--doctor-text);
        font-size: 14px;
        line-height: 1.7;
    }

    .news-content p {
        margin: 0 0 12px;
    }

    .news-content h1,
    .news-content h2,
    .news-content h3,
    .news-content h4 {
        color: var(--doctor-text);
        font-weight: 700;
        margin: 20px 0 10px;
    }

    .news-content strong {
        font-weight: 700;
    }

    .news-content em {
        font-style: italic;
    }

    .news-content u {
        text-decoration: underline;
    }

    .news-content ul,
    .news-content ol {
        margin: 10px 0 15px;
        padding-left: 25px;
    }

    .news-content li {
        margin-bottom: 5px;
    }

    .news-content blockquote {
        margin: 15px 0;
        padding: 10px 15px;
        border-left: 3px solid var(--accent-blue);
        color: var(--doctor-muted);
        background: var(--doctor-status-bg);
    }

    .news-content a {
        color: var(--accent-blue);
        text-decoration: underline;
    }

    .news-content img {
        max-width: 100%;
        height: auto;
        border-radius: 6px;
    }

    .news-content iframe {
        max-width: 100%;
    }

    @media (max-width: 700px) {

        .news-show-card {
            padding: 18px;
        }

        .news-show-title {
            font-size: 22px;
        }

        .news-show-top {
            align-items: flex-start;
            gap: 10px;
        }

        .news-meta {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>

<div class="news-show">

    {{-- Top actions --}}
    <div class="news-show-top">

        <a
            href="{{ route('doctor.news.index') }}"
            class="back-news"
        >
            <i class="fas fa-arrow-left mr-1"></i>
            Back to News
        </a>

        <a
            href="{{ route('doctor.news.edit', $news->NewsId) }}"
            class="edit-news"
        >
            <i class="fas fa-edit"></i>
            Edit
        </a>

    </div>


    {{-- News detail --}}
    <article class="news-show-card">

        {{-- Category --}}
        <div class="news-category">

            <i class="fas fa-tag mr-1"></i>

            {{ $news->Category ?? 'General News' }}

        </div>


        {{-- Title --}}
        <h1 class="news-show-title">
            {{ $news->Title }}
        </h1>


        {{-- Meta --}}
        <div class="news-meta">

            <span>
                <i class="far fa-user"></i>

                {{ $news->AuthorName ?? 'Doctor' }}
            </span>

            <span>
                <i class="far fa-calendar"></i>

                {{ \Carbon\Carbon::parse($news->CreatedAt)->format('d/m/Y - H:i') }}
            </span>

        </div>


        {{-- Featured image --}}
        {{-- Featured image --}}
@php
    $newsImagePath = trim(
        (string) ($news->ThumbnailUrl ?? '')
    );

    $newsImagePath = ltrim(
        $newsImagePath,
        '/'
    );

    $newsImageExists =
        $newsImagePath !== '' &&
        file_exists(
            public_path($newsImagePath)
        );
@endphp

@if($newsImageExists)

    <img
        src="{{ asset($newsImagePath) }}"
        alt="{{ $news->Title }}"
        class="news-featured-image"
        onerror="this.onerror=null;this.style.display='none';this.nextElementSibling.style.display='flex';"
    >

    <div
        class="news-image-placeholder"
        style="display:none;"
    >   
        <i class="fas fa-newspaper"></i>
    </div>

@else

    <div class="news-image-placeholder">
        <i class="fas fa-newspaper"></i>
    </div>

@endif


        {{-- News content --}}
        <div class="news-content">
            {!! $news->Content !!}
        </div>

    </article>

</div>

@endsection
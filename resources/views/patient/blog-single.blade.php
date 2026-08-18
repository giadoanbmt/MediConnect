@extends('components.layouts.partials.frontend')
@section('title', 'Home - MediConnect')

@section('content')

<section class="page-title bg-1">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="block text-center">
                    <span class="text-white">Our blog</span>
                    <h1 class="text-capitalize mb-5 text-lg">Blog articles</h1>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section blog-wrap">
    <div class="container">
        <div class="row">
            <!-- DANH SÁCH BÀI VIẾT (BÊN TRÁI) -->
            <div class="col-lg-8">
                <div class="row">

                    @forelse($news as $item)
                    <div class="col-lg-12 col-md-12 mb-5">
                        <div class="blog-item">
                            @if($item->ThumbnailUrl)
                            <div class="blog-thumb overflow-hidden" style="border-radius: 5px;">
                                <img src="{{ str_starts_with($item->ThumbnailUrl, 'http') ? $item->ThumbnailUrl : asset('storage/' . $item->ThumbnailUrl) }}"
                                    alt="{{ $item->Title }}"
                                    class="img-fluid w-100"
                                    style="height: 380px; object-fit: cover;">
                            </div>
                            @endif

                            <div class="blog-item-content">
                                <div class="blog-item-meta mb-3 mt-4">
                                    <span class="text-black text-capitalize mr-3">
                                        <i class="icofont-calendar mr-1"></i>
                                        {{ \Carbon\Carbon::parse($item->PublishedAt ?? $item->created_at)->format('d M, Y') }}
                                    </span>
                                    @if(isset($item->category))
                                    <span class="text-black text-capitalize mr-3">
                                        <i class="icofont-folder mr-1"></i>
                                        {{ $item->category->CategoryName ?? $item->category->name }}
                                    </span>
                                    @endif
                                </div>

                                <h2 class="mt-3 mb-3 text-break">
                                    <a href="{{ url('/blog/' . $item->NewsId) }}">{{ $item->Title }}</a>
                                </h2>

                                <p class="mb-4 text-break">
                                    {{ Str::limit(strip_tags($item->Summary ?? $item->Content), 200) }}
                                </p>

                                <a href="{{ url('/blog/' . $item->NewsId) }}" class="btn btn-main btn-icon btn-round-full">
                                    Read More <i class="icofont-simple-right ml-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-lg-12 text-center py-5">
                        <p class="text-muted fs-5">Không tìm thấy bài viết nào.</p>
                    </div>
                    @endforelse

                    <!-- PHÂN TRANG -->
                    <div class="col-lg-12 col-md-12">
                        <div class="py-2 d-flex justify-content-center">
                            {{ $news->withQueryString()->links() }}
                        </div>
                    </div>

                </div>
            </div>

            <!-- SIDEBAR (BÊN PHẢI) -->
            <div class="col-lg-4">
                <div class="sidebar-wrap pl-lg-4 mt-5 mt-lg-0">

                    <!-- Tìm kiếm -->
                    <div class="sidebar-widget search mb-4">
                        <h5>Search Here</h5>
                        <form action="{{ url('/blog') }}" method="GET" class="search-form position-relative mt-3">
                            <input type="text" name="keyword" class="form-control pr-5" placeholder="search" value="{{ request('keyword') }}">
                            <button type="submit" style="border:none; background:none; position:absolute; right:15px; top:50%; transform:translateY(-50%); cursor:pointer;">
                                <i class="icofont-search"></i>
                            </button>
                        </form>
                    </div>

                    <!-- Bài viết mới nhất (New Posts) -->
                    <div class="sidebar-widget latest-post mb-4">
                        <h5 class="mb-4">New Posts</h5>

                        @if(isset($popularNews) && count($popularNews) > 0)
                        @foreach($popularNews as $pop)
                        <div class="py-2 d-flex align-items-center border-bottom mb-2">
                            @if($pop->ThumbnailUrl)
                            <div class="post-thumb mr-3 flex-shrink-0">
                                <a href="{{ url('/blog/' . $pop->NewsId) }}">
                                    <img src="{{ str_starts_with($pop->ThumbnailUrl, 'http') ? $pop->ThumbnailUrl : asset('storage/' . $pop->ThumbnailUrl) }}"
                                        alt="{{ $pop->Title }}"
                                        class="img-fluid"
                                        style="width: 70px; height: 70px; object-fit: cover; border-radius: 5px;">
                                </a>
                            </div>
                            @endif
                            <div class="post-content overflow-hidden">
                                <span class="text-sm text-muted d-block mb-1">{{ \Carbon\Carbon::parse($pop->PublishedAt ?? $pop->created_at)->format('d M, Y') }}</span>
                                <h6 class="mb-0 text-truncate"><a href="{{ url('/blog/' . $pop->NewsId) }}">{{ $pop->Title }}</a></h6>
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>

                    <!-- Danh mục (Categories lấy từ DB) -->
                    <div class="sidebar-widget category mb-4">
                        <h5 class="mb-4">Categories</h5>

                        <ul class="list-unstyled mb-0">
                            @forelse($categories ?? [] as $cat)
                            <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                <a href="{{ url('/blog?category=' . ($cat->CategoryId ?? $cat->id)) }}">
                                    {{ $cat->CategoryName ?? $cat->name }}
                                </a>
                                @if(isset($cat->news_count))
                                <span class="badge bg-light text-dark">{{ $cat->news_count }}</span>
                                @endif
                            </li>
                            @empty
                            <li class="text-muted">Chưa có danh mục nào.</li>
                            @endforelse
                        </ul>
                    </div>

                    <!-- Lịch làm việc -->
                    <div class="sidebar-widget schedule-widget mb-4">
                        <h5 class="mb-4">Time Schedule</h5>

                        <ul class="list-unstyled">
                            <li class="d-flex justify-content-between align-items-center py-1">
                                <span>Monday - Friday</span>
                                <span>9:00 - 17:00</span>
                            </li>
                            <li class="d-flex justify-content-between align-items-center py-1">
                                <span>Saturday</span>
                                <span>9:00 - 16:00</span>
                            </li>
                            <li class="d-flex justify-content-between align-items-center py-1">
                                <span>Sunday</span>
                                <span>Closed</span>
                            </li>
                        </ul>

                        <div class="sidebar-contatct-info mt-4">
                            <p class="mb-0">Need Urgent Help?</p>
                            <h3>+23-4565-65768</h3>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

@endsection
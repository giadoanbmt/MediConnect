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
            <!-- KHUNG CHỨA BÀI VIẾT TỰ ĐỘNG CẬP NHẬT QUA AJAX -->
            <div class="col-lg-8" id="blog-news-list-container">
                @include('patient.blog-news-list')
            </div>

            <!-- SIDEBAR -->
            <div class="col-lg-4">
                <div class="sidebar-wrap pl-lg-4 mt-5 mt-lg-0">

                    <!-- Ô TÌM KIẾM TỰ ĐỘNG -->
                    <div class="sidebar-widget search mb-4">
                        <h5>Search Here</h5>
                        <form id="search-form" onsubmit="return false;" class="sidebar-widget search  mb-3">
                            <input type="text" id="search-keyword" name="keyword" class="form-control pr-5" placeholder="Search..." value="{{ request('keyword') }}" autocomplete="off">
                            <i class="ti-search"></i>
                        </form>
                    </div>

                    <!-- Bài viết mới nhất -->
                    <div class="sidebar-widget latest-post mb-4">
                        <h5 class="mb-4">New Posts</h5>
                        @if(isset($popularNews) && count($popularNews) > 0)
                        @foreach($popularNews as $pop)
                        <div class="py-2 d-flex align-items-center border-bottom mb-2">
                            @if($pop->ThumbnailUrl)
                            <div class="post-thumb mr-3 flex-shrink-0">
                                <a href="{{ url('/blog-single/' . $pop->NewsId) }}">
                                    <img src="{{ $pop->ThumbnailUrl ? asset($pop->ThumbnailUrl) : asset('images/thumbnails/news-placeholder.png') }}"
                                        alt="{{ $pop->Title }}" class="img-fluid" style="width: 70px; height: 70px; object-fit: cover; border-radius: 5px;">
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

                    <!-- Categories -->
                    <div class="sidebar-widget category mb-4">
                        <h5 class="mb-4">Categories</h5>
                        <ul class="list-unstyled mb-0">
                            @forelse($categories as $cat)
                            <li class="d-flex justify-content-between align-items-center py-2 border-bottom">

                                <a href="{{ route('public.blog-sidebar', ['category' => $cat->Category]) }}" class="category-link">
                                    {{ $cat->Category }}
                                </a>
                                <span class="badge bg-light text-dark">{{ $cat->news_count }}</span>
                            </li>
                            @empty
                            <li class="text-muted">There are no categories yet.</li>
                            @endforelse
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<!-- SCRIPT AJAX XỬ LÝ LIVE SEARCH & CHUYỂN TRANG -->
<script src="{{ asset('Novena/plugins/jquery/jquery.js') }}"></script>

<script>
    $(document).ready(function() {
        let searchTimer;
        const currentUrl = "{{ request()->url() }}";

        function fetchNewsData(targetUrl) {
            $('#blog-news-list-container').css('opacity', '0.4');

            $.ajax({
                url: targetUrl,
                type: "GET",
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    if (typeof response === 'object' && response.html) {
                        $('#blog-news-list-container').html(response.html);
                    } else if (typeof response === 'string') {
                        let freshContent = $(response).find('#blog-news-list-container').html();
                        if (freshContent) {
                            $('#blog-news-list-container').html(freshContent);
                        }
                    }
                    $('#blog-news-list-container').css('opacity', '1');
                },
                error: function(xhr, status, error) {
                    console.error("Lỗi AJAX:", error, xhr.responseText);
                    $('#blog-news-list-container').css('opacity', '1');
                }
            });
        }

        // 1. Bắt sự kiện click chọn Category bằng AJAX
        $(document).on('click', '.category-link', function(e) {
            e.preventDefault();
            let targetUrl = $(this).attr('href');

            // Cập nhật lại URL trên thanh địa chỉ trình duyệt không cần load lại trang
            window.history.pushState(null, '', targetUrl);

            // Reset ô tìm kiếm nếu chuyển danh mục
            $('#search-keyword').val('');

            fetchNewsData(targetUrl);
        });

        // 2. Bắt sự kiện gõ phím vào ô tìm kiếm
        $('#search-keyword').on('input', function() {
            clearTimeout(searchTimer);
            let keyword = $(this).val();
            let url = currentUrl + "?keyword=" + encodeURIComponent(keyword);

            searchTimer = setTimeout(function() {
                fetchNewsData(url);
            }, 300);
        });

        // 3. Bắt sự kiện click chuyển trang (Pagination)
        $(document).on('click', '#blog-news-list-container .pagination a', function(e) {
            e.preventDefault();
            let pageUrl = $(this).attr('href');
            if (pageUrl) {
                window.history.pushState(null, '', pageUrl);
                fetchNewsData(pageUrl);
            }
        });
    });
</script>

@endsection
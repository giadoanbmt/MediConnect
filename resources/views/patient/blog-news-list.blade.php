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
                    @if(!empty($item->Category))
                    <span class="text-black text-capitalize mr-3">
                        <i class="icofont-folder mr-1"></i>
                        {{ $item->Category }}
                    </span>
                    @endif
                </div>

                <h2 class="mt-3 mb-3 text-break">
                    <a href="{{ url('/blog/' . $item->NewsId) }}">{{ $item->Title }}</a>
                </h2>

                <p class="mb-4 text-break">
                    {{ Str::limit(strip_tags($item->Summary ?? $item->Content), 200) }}
                </p>

                <a href="{{ url('/blog-single/' . $item->NewsId) }}" class="btn btn-main btn-icon btn-round-full">
                    Read More <i class="icofont-simple-right ml-2"></i>
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="col-lg-12 text-center py-5">
        <p class="text-muted fs-5">No articles were found that matched the keyword.</p>
    </div>
    @endforelse

    <!-- PHÂN TRANG AJAX -->
    <div class="col-lg-12 col-md-12">
        <div class="py-4 d-flex justify-content-center">
            {{ $news->withQueryString()->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
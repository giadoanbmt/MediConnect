@extends('components.layouts.partials.frontend')
@section('title', ($news->Title ?? 'News Details') . ' - MediConnect')

@section('content')

<section class="page-title bg-1">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="block text-center">
                    <span class="text-white">News Details</span>
                    <h1 class="text-capitalize mb-5 text-lg">{{ $news->Title }}</h1>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section blog-wrap">
    <div class="container">
        <div class="row">
            <!-- CỘT NỘI DUNG CHÍNH -->
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-lg-12 mb-5">
                        <div class="single-blog-item">
                            <!-- THUMBNAIL -->
                            @php
                            $imgPath = $news->ImageUrl ?? $news->ThumbnailUrl ?? null;
                            @endphp

                            @if(!empty($imgPath) && file_exists(public_path($imgPath)))
                            <img src="{{ asset($imgPath) }}" alt="{{ $news->Title }}" class="img-fluid w-100 rounded" style="max-height: 450px; object-fit: cover;">
                            @else
                            <img src="{{ asset('Novena/images/blog/blog-1.jpg') }}" alt="{{ $news->Title }}" class="img-fluid w-100 rounded">
                            @endif

                            <div class="blog-item-content mt-5">
                                <!-- THÔNG TIN METADATA (Ngày tạo & Danh mục) -->
                                <div class="blog-item-meta mb-3">
                                    <span class="text-color-2 text-capitalize mr-3">
                                        <i class="icofont-book-mark mr-2"></i> {{ $news->Category ?? 'Medical News' }}
                                    </span>
                                    <span class="text-black text-capitalize mr-3">
                                        <i class="icofont-calendar mr-2"></i>
                                        {{ \Carbon\Carbon::parse($news->CreatedDate ?? $news->created_at ?? now())->format('d M Y') }}
                                    </span>
                                </div>

                                <!-- TIÊU ĐỀ BÀI VIẾT -->
                                <h2 class="mb-4 text-md">{{ $news->Title }}</h2>

                                <!-- NỘI DUNG CHÍNH (Cột Content) -->
                                <div class="blog-body-content text-muted" style="line-height: 1.8; font-size: 1.05rem;">
                                    {!! nl2br(e($news->Content)) !!}
                                </div>

                                <div class="mt-5 clearfix">
                                    <ul class="float-right list-inline">
                                        <li class="list-inline-item"> Share: </li>
                                        <li class="list-inline-item"><a href="#!"><i class="icofont-facebook"></i></a></li>
                                        <li class="list-inline-item"><a href="#!"><i class="icofont-twitter"></i></a></li>
                                        <li class="list-inline-item"><a href="#!"><i class="icofont-pinterest"></i></a></li>
                                        <li class="list-inline-item"><a href="#!"><i class="icofont-linkedin"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- BÌNH LUẬN GIỮ NGUYÊN GIAO DIỆN MẪU -->
                    <!-- <div class="col-lg-12">
                        <div class="comment-area mt-4 mb-5">
                            <h4 class="mb-4">Comments</h4>
                            <ul class="comment-tree list-unstyled">
                                <li class="mb-5">
                                    <div class="comment-area-box d-block d-sm-flex">
                                        <div class="comment-thumb">
                                            <img alt="" src="{{ asset('Novena/images/blog/testimonial1.jpg') }}" style="width: 70px">
                                        </div>
                                        <div class="block">
                                            <div class="comment-info">
                                                <h5 class="mb-1">John</h5>
                                                <span>United Kingdom</span>
                                                <span class="date-comm">| Posted April 7, 2026</span>
                                            </div>
                                            <div class="comment-meta mt-2">
                                                <a href="#!"><i class="icofont-reply mr-2 text-muted"></i>Reply</a>
                                            </div>
                                            <div class="comment-content mt-3">
                                                <p>Great medical advice and informative post!</p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <form class="comment-form my-5" id="comment-form">
                            <h4 class="mb-4">Write a comment</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="name" id="name" placeholder="Name:">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="mail" id="mail" placeholder="Email:">
                                    </div>
                                </div>
                            </div>
                            <textarea class="form-control mb-4" name="comment" id="comment" cols="30" rows="5" placeholder="Comment"></textarea>
                            <input class="btn btn-main-2 btn-round-full" type="submit" name="submit-contact" id="submit_contact" value="Submit Message">
                        </form>
                    </div> -->
                </div>
            </div>

            <!-- CỘT SIDEBAR -->
            <div class="col-lg-4">
                <div class="sidebar-wrap pl-lg-4 mt-5 mt-lg-0">


                    <!-- BÀI VIẾT KHÁC (Cột NewsId, Title, CreatedDate) -->
                    <div class="sidebar-widget latest-post mb-3">
                        <h5 class="mb-3">Recent Posts</h5>
                        @if(isset($recentNews) && count($recentNews) > 0)
                        @foreach($recentNews as $post)
                        <div class="py-2 border-bottom">
                            <span class="text-sm text-muted">
                                {{ \Carbon\Carbon::parse($post->CreatedDate ?? $post->created_at ?? now())->format('d M Y') }}
                            </span>
                            <h6 class="my-2">
                                <a href="{{ route('public.blog-single', $post->NewsId ?? $post->id) }}" class="text-dark">
                                    {{ Str::limit($post->Title, 55) }}
                                </a>
                            </h6>
                        </div>
                        @endforeach
                        @else
                        <p class="text-muted text-sm">Chưa có bài viết khác.</p>
                        @endif
                    </div>

                    <!-- TIMETABLE SIDEBAR -->
                    <div class="sidebar-widget schedule-widget mb-3">
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
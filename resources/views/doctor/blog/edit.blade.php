@extends('layouts.dashboard')

@section('title', 'Edit blog - MediConnect')

@section('content')
<h2 class="font-weight-bold mb-4" style="color: var(--primary-blue);">Edit blog</h2>

<div class="card border-0 shadow-sm p-4">
    <form action="{{ route('doctor.blog.update', $blog->ContentId) }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group mb-3">
            <label class="font-weight-bold">Title <span class="text-danger">*</span></label>
            <input type="text" name="title" class="form-control" value="{{ $blog->Title }}" required>
        </div>

        <div class="form-group mb-3">
            <label class="font-weight-bold">Current feature Image</label>
            @if($blog->Image)
                <div class="mb-2">
                    <img src="{{ asset($blog->Image) }}" alt="Blog Image" style="max-height: 120px; border-radius: 6px;">
                </div>
            @endif
            <input type="file" name="image" class="form-control-file">
            <small class="text-muted">New Image (Leave blank to keep the current image)</small>
        </div>

        <div class="form-group mb-4">
            <label class="font-weight-bold">Content <span class="text-danger">*</span></label>
            <textarea name="body" class="form-control" rows="10" required>{{ $blog->Body }}</textarea>
        </div>

        <div class="d-flex justify-content-end">
            <a href="{{ route('doctor.blog.index') }}" class="btn btn-secondary mr-2">Cancle</a>
            <button type="submit" class="btn btn-primary" style="background-color: var(--primary-blue); border: none;">Edit blog</button>
        </div>
    </form>
</div>
@endsection
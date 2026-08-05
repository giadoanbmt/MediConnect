@extends('layouts.dashboard')

@section('title', 'Write new content - MediConnect')

@section('content')
<h2 class="font-weight-bold mb-4" style="color: var(--primary-blue);">Create new Blog</h2>

<div class="card border-0 shadow-sm p-4">
    <form action="{{ route('doctor.blog.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group mb-3">
            <label class="font-weight-bold">Title <span class="text-danger">*</span></label>
            <input type="text" name="title" class="form-control"  required>
        </div>

        <div class="form-group mb-3">
            <label class="font-weight-bold">Featured Image</label>
            <input type="file" name="image" class="form-control-file">
        </div>

        <div class="form-group mb-4">
            <label class="font-weight-bold">Content <span class="text-danger">*</span></label>
            <textarea name="body" class="form-control" rows="max"  required></textarea>
        </div>

        <div class="d-flex justify-content-end">
            <a href="{{ route('doctor.blog.index') }}" class="btn btn-secondary mr-2">Cancel</a>
            <button type="submit" class="btn btn-primary" style="background-color: var(--primary-blue); border: none;">Post</button>
        </div>
    </form>
</div>
@endsection
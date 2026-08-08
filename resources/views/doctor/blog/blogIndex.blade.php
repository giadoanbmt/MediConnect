@extends('layouts.dashboard')

@section('title', 'Content manager - MediConnect')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="font-weight-bold" style="color: var(--primary-blue);">Blog Posts</h2>
    <a href="{{ route('doctor.blog.create') }}" class="btn btn-primary" style="background-color: var(--primary-blue); border: none;">
        <i class="icofont-plus mr-1"></i> Write new blog
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success mb-3">{{ session('success') }}</div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="thead-light">
                <tr>
                    <th style="width: 80px;">Picture</th>
                    <th>Title</th>
                    <th style="width: 150px;">Date create</th>
                    <th style="width: 120px;">Status</th>
                    <th style="width: 160px;" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($blogs as $item)
                    <tr>
                        <td>
                            @if($item->Image)
                                <img src="{{ asset($item->Image) }}" alt="Blog Image" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                            @else
                                <span class="badge badge-secondary">No Image</span>
                            @endif
                        </td>
                        <td class="align-middle">
                            <strong class="text-dark">{{ $item->Title }}</strong>
                        </td>
                        <td class="align-middle">{{ \Carbon\Carbon::parse($item->CreatedAt)->format('d/m/Y') }}</td>
                        <td class="align-middle">
                            <span class="badge badge-success">{{ $item->Status ?? 'Published' }}</span>
                        </td>
                        <td class="align-middle text-center">
                            <a href="{{ route('doctor.blog.edit', $item->ContentId) }}" class="btn btn-sm btn-outline-info mr-1">
                                <i class="icofont-edit"></i> Change
                            </a>
                            <form action="{{ route('doctor.blog.delete', $item->ContentId) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa bài viết này?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="icofont-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">There are no articles in the system yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
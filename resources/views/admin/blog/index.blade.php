@extends('layouts.admin')

@section('title', 'Blog Management')

@section('admin-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Blog Management</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Blog</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <!-- REMOVE STATS CARDS HERE -->

        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <div class="card-header bg-white">
                        <h3 class="card-title">
                            <i class="fas fa-blog mr-2 text-primary"></i>
                            Posts List
                        </h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.blog.create') }}" class="btn btn-sm btn-primary btn-gradient">
                                <i class="fas fa-plus mr-1"></i> Add Post
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <!-- Keep table section unchanged -->
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead class="thead-dark">
                                    <tr>
                                        <th width="80" class="text-center">ID</th>
                                        <th width="100" class="text-center">Image</th>
                                        <th>Title</th>
                                        <th width="150">Author</th>
                                        <th width="120" class="text-center">Created Date</th>
                                        <th width="150" class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($blogs as $blog)
                                    <tr class="blog-row">
                                        <td class="text-center">
                                            <span class="badge badge-secondary">#{{ $blog->BlogID }}</span>
                                        </td>
                                        <td class="text-center">
                                            @if($blog->Image)
                                            <img src="{{ asset($blog->Image) }}" alt="{{ $blog->Title }}"
                                                class="blog-image rounded border">
                                            @else
                                            <div class="no-image-placeholder">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="blog-title-wrapper">
                                                <h6 class="blog-title mb-1">{{ Str::limit($blog->Title, 60) }}</h6>
                                                <small class="text-muted blog-excerpt">
                                                    {{ Str::limit(strip_tags($blog->Content), 80) }}
                                                </small>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="author-info">
                                                <i class="fas fa-user-edit text-info mr-1"></i>
                                                <span class="font-weight-semibold">{{ $blog->Author }}</span>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <small class="text-muted">
                                                <i class="far fa-calendar-alt mr-1"></i>
                                                {{ date('d/m/Y', strtotime($blog->created_at)) }}
                                            </small>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm w-100">
                                                {{-- EDIT: route('blog.show') -> route('admin.blog.show') --}}
                                                <a href="{{ route('admin.blog.show', $blog->BlogID) }}"
                                                    class="btn btn-info btn-view"
                                                    title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.blog.edit', $blog->BlogID) }}"
                                                    class="btn btn-warning btn-edit"
                                                    title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.blog.destroy', $blog->BlogID) }}"
                                                    method="POST"
                                                    class="d-inline delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-danger btn-delete"
                                                        title="Delete"
                                                        onclick="return confirm('Are you sure you want to delete this post?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin/blog/index.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('js/admin/blog/index.js') }}"></script>
@endsection
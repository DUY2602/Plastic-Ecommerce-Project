@extends('layouts.admin')

@section('title', 'Blog Details')

@section('admin-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Blog Details</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.blog.index') }}">Blog</a></li>
                    <li class="breadcrumb-item active">Details</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Post Information</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 text-center">
                                @if($blog->Image)
                                <img src="{{ asset($blog->Image) }}" alt="{{ $blog->Title }}"
                                    class="img-fluid rounded shadow" style="max-height: 300px; object-fit: cover;">
                                @else
                                <div class="no-image-placeholder bg-light rounded d-flex align-items-center justify-content-center"
                                    style="height: 300px;">
                                    <i class="fas fa-image fa-5x text-muted"></i>
                                </div>
                                @endif
                            </div>
                            <div class="col-md-8">
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="30%">Post ID</th>
                                        <td>#{{ $blog->BlogID }}</td>
                                    </tr>
                                    <tr>
                                        <th>Title</th>
                                        <td><strong>{{ $blog->Title }}</strong></td>
                                    </tr>
                                    <tr>
                                        <th>Author</th>
                                        <td>
                                            <span class="badge badge-info badge-pill px-3">
                                                <i class="fas fa-user mr-1"></i>{{ $blog->Author }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Content</th>
                                        <td>
                                            <div style="max-height: 200px; overflow-y: auto; padding: 10px; background: #f8f9fa; border-radius: 5px;">
                                                {{ $blog->Content }}
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Content Length</th>
                                        <td>
                                            <span class="badge badge-secondary badge-pill px-3">
                                                <i class="fas fa-ruler mr-1"></i>
                                                {{ strlen($blog->Content) }} characters
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Estimated Reading Time</th>
                                        <td>
                                            <span class="badge badge-primary badge-pill px-3">
                                                <i class="fas fa-clock mr-1"></i>
                                                {{ ceil(strlen($blog->Content) / 1000) }} minutes
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Created Date</th>
                                        <td>{{ $blog->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Updated Date</th>
                                        <td>{{ $blog->updated_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="btn-group">
                            <a href="{{ route('admin.blog.edit', $blog->BlogID) }}" class="btn btn-warning">
                                <i class="fas fa-edit mr-2"></i>Edit
                            </a>
                            <form action="{{ route('admin.blog.destroy', $blog->BlogID) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this post?')">
                                    <i class="fas fa-trash mr-2"></i>Delete
                                </button>
                            </form>
                            <a href="{{ route('admin.blog.index') }}" class="btn btn-default">
                                <i class="fas fa-arrow-left mr-2"></i>Back
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Recent Blogs Section -->
                <div class="card card-info mt-4">
                    <div class="card-header">
                        <h3 class="card-title">Recent Posts</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th width="80">ID</th>
                                        <th>Title</th>
                                        <th width="120">Author</th>
                                        <th width="120">Created Date</th>
                                        <th width="100">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $recentBlogs = \App\Models\Blog::where('BlogID', '!=', $blog->BlogID)
                                    ->orderBy('created_at', 'desc')
                                    ->take(5)
                                    ->get();
                                    @endphp
                                    @foreach($recentBlogs as $recentBlog)
                                    <tr>
                                        <td class="text-center">
                                            <span class="badge badge-secondary">#{{ $recentBlog->BlogID }}</span>
                                        </td>
                                        <td>
                                            <strong>{{ Str::limit($recentBlog->Title, 50) }}</strong>
                                        </td>
                                        <td>{{ $recentBlog->Author }}</td>
                                        <td>{{ $recentBlog->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            <a href="{{ route('admin.blog.show', $recentBlog->BlogID) }}"
                                                class="btn btn-sm btn-info" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
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

<style>
    .card {
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        border: none;
        border-radius: 10px;
    }

    .card-header {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        color: white;
        border-radius: 10px 10px 0 0 !important;
    }

    .card-info .card-header {
        background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
    }

    .table th {
        background-color: #f8f9fa;
        font-weight: 600;
    }

    .btn-group .btn {
        margin-right: 5px;
        border-radius: 6px;
    }

    .no-image-placeholder {
        border: 2px dashed #dee2e6;
    }

    .badge-pill {
        font-size: 0.85rem;
        padding: 6px 12px;
    }

    .table-responsive {
        border-radius: 8px;
        overflow: hidden;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Confirm post deletion
        const deleteForms = document.querySelectorAll('form[action*="destroy"]');
        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                if (!confirm('Are you sure you want to delete this post?')) {
                    e.preventDefault();
                }
            });
        });
    });
</script>
@endsection
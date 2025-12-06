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

<style>
    /* Keep CSS styles unchanged */
    .card-primary.card-outline {
        border-top: 3px solid #007bff;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        border-radius: 8px;
    }

    .card-header.bg-white {
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%) !important;
        border-bottom: 1px solid #e3e6f0;
    }

    .table {
        margin-bottom: 0;
        font-size: 0.9rem;
    }

    .table thead th {
        border-bottom: 2px solid #dee2e6;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
        background: #4e73df;
        color: white;
        padding: 12px 8px;
    }

    .table tbody tr.blog-row {
        transition: all 0.3s ease;
        border-left: 3px solid transparent;
    }

    .table tbody tr.blog-row:hover {
        background-color: #f8f9fa;
        border-left-color: #007bff;
        transform: translateX(2px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .blog-image {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border: 2px solid #e3e6f0;
        transition: all 0.3s ease;
    }

    .blog-image:hover {
        transform: scale(1.1);
        border-color: #007bff;
    }

    .no-image-placeholder {
        width: 50px;
        height: 50px;
        background: #f8f9fa;
        border: 2px dashed #dee2e6;
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }

    .blog-title-wrapper {
        max-width: 400px;
    }

    .blog-title {
        color: #2e3a59;
        font-weight: 600;
        line-height: 1.3;
    }

    .blog-excerpt {
        font-size: 0.8rem;
        line-height: 1.2;
    }

    .author-info {
        display: flex;
        align-items: center;
        font-size: 0.85rem;
    }

    .btn-group-sm>.btn {
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        margin: 0 1px;
    }

    .btn-view {
        background: linear-gradient(135deg, #17a2b8, #138496);
        border: none;
        color: white;
    }

    .btn-edit {
        background: linear-gradient(135deg, #ffc107, #e0a800);
        border: none;
        color: white;
    }

    .btn-delete {
        background: linear-gradient(135deg, #dc3545, #c82333);
        border: none;
        color: white;
    }

    .btn-view:hover {
        background: linear-gradient(135deg, #138496, #117a8b);
    }

    .btn-edit:hover {
        background: linear-gradient(135deg, #e0a800, #d39e00);
    }

    .btn-delete:hover {
        background: linear-gradient(135deg, #c82333, #bd2130);
    }

    .btn-gradient {
        background: linear-gradient(135deg, #007bff, #0056b3);
        border: none;
        color: white;
        font-weight: 500;
    }

    .btn-gradient:hover {
        background: linear-gradient(135deg, #0056b3, #004085);
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3);
    }

    .badge {
        font-size: 0.7rem;
        font-weight: 500;
    }

    @media (max-width: 768px) {
        .table-responsive {
            border: 1px solid #dee2e6;
            border-radius: 4px;
        }

        .blog-title-wrapper {
            max-width: 200px;
        }

        .card-tools {
            margin-top: 10px;
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .blog-row {
        animation: fadeIn 0.5s ease-out;
    }

    .table-responsive::-webkit-scrollbar {
        height: 6px;
    }

    .table-responsive::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }

    .table-responsive::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 3px;
    }

    .table-responsive::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteForms = document.querySelectorAll('.delete-form');
        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                if (!confirm('Are you sure you want to delete this post?')) {
                    e.preventDefault();
                }
            });
        });

        const buttons = document.querySelectorAll('.btn');
        buttons.forEach(button => {
            button.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-1px)';
            });
            button.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    });
</script>
@endsection
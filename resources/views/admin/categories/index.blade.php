@extends('layouts.admin')

@section('title', 'Manage Categories')

@section('admin-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Manage Categories</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Categories</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-12">
                <div class="card animated fadeIn">
                    <div class="card-body">
                        <form id="searchForm" method="GET" action="{{ route('admin.categories') }}">
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-search"></i>
                                                </span>
                                            </div>
                                            <input type="text" name="search" class="form-control"
                                                placeholder="Search categories by name or description..."
                                                value="{{ request('search') }}"
                                                id="searchInput">
                                            <div class="input-group-append">
                                                <div class="input-group-text search-loading d-none">
                                                    <i class="fas fa-spinner fa-spin"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <a href="{{ route('admin.categories.create') }}" class="btn btn-success btn-block waves-effect">
                                        <i class="fas fa-plus mr-2"></i>Add New
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-success card-outline animated fadeInUp">
                    <div class="card-header">
                        <h3 class="card-title">Category List</h3>
                        <div class="card-tools">
                            <div class="btn-group">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                    <i class="fas fa-expand"></i>
                                </button>
                                @if(request('search'))
                                <a href="{{ route('admin.categories') }}" class="btn btn-danger waves-effect" title="Clear filter">
                                    <i class="fas fa-times mr-2"></i>Clear Filter
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body" id="categoriesTable">
                        @if(request('search'))
                        <div class="alert alert-info alert-dismissible fade show mb-3" role="alert">
                            <strong>Search Results:</strong> Keyword: "<strong>{{ request('search') }}</strong>"
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif

                        @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                            <strong>Success!</strong> {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif

                        @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                            <strong>Error!</strong> {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif

                        @if($categories->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead class="thead-dark">
                                    <tr>
                                        <th width="60">ID</th>
                                        <th>Category Name</th>
                                        <th>Description</th>
                                        <th width="120">Products Count</th>
                                        <th width="120">Status</th>
                                        <th width="150" class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categories as $category)
                                    <tr class="animated fadeIn">
                                        <td><strong class="text-primary">#{{ $category->CategoryID }}</strong></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="category-icon mr-3">
                                                    <i class="fas fa-folder text-warning fa-lg"></i>
                                                </div>
                                                <div>
                                                    <strong>{{ $category->CategoryName }}</strong>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-muted">{{ Str::limit($category->Description, 80) }}</span>
                                        </td>
                                        <td>
                                            <div class="product-count">
                                                <span class="badge badge-primary badge-pill px-3 py-2">
                                                    <i class="fas fa-cube mr-1"></i>
                                                    {{ $category->products_count }} products
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            @if($category->Status == 1)
                                            <span class="badge badge-success badge-pill">
                                                <i class="fas fa-eye mr-1"></i>Visible
                                            </span>
                                            @else
                                            <span class="badge badge-danger badge-pill">
                                                <i class="fas fa-eye-slash mr-1"></i>Hidden
                                            </span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm w-100">
                                                <a href="{{ route('admin.categories.show', $category->CategoryID) }}"
                                                    class="btn btn-info btn-flat waves-effect flex-fill"
                                                    title="View details">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.categories.edit', $category->CategoryID) }}"
                                                    class="btn btn-warning btn-flat waves-effect flex-fill"
                                                    title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.categories.destroy', $category->CategoryID) }}"
                                                    method="POST" class="d-inline flex-fill delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-danger btn-flat waves-effect w-100"
                                                        title="Delete"
                                                        onclick="return confirm('Are you sure you want to delete this category?')">
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
                        @else
                        <div class="text-center py-5">
                            <div class="empty-state">
                                <i class="fas fa-folder-open fa-4x text-muted mb-3"></i>
                                <h4 class="text-muted">No categories found</h4>
                                <p class="text-muted mb-4">No categories match your search criteria.</p>
                                @if(request('search'))
                                <a href="{{ route('admin.categories') }}" class="btn btn-primary waves-effect">
                                    <i class="fas fa-redo mr-2"></i>View All Categories
                                </a>
                                @else
                                <a href="{{ route('admin.categories.create') }}" class="btn btn-success waves-effect">
                                    <i class="fas fa-plus mr-2"></i>Add First Category
                                </a>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="card-footer clearfix">
                        <div class="float-left">
                            <span class="text-muted">
                                Showing <strong>{{ $categories->count() }}</strong> categories
                            </span>
                        </div>
                        <div class="float-right">
                            <span class="text-muted">Total {{ $categories->count() }} categories</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin/categories/index.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('js/admin/categories/index.js') }}"></script>
@endsection
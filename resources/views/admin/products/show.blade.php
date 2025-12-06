@extends('layouts.admin')

@section('title', 'Product Details')

@section('admin-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Product Details</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.products') }}">Products</a></li>
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
                        <h3 class="card-title">Product Information</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 text-center">
                                @if($product->Photo && file_exists(public_path($product->Photo)))
                                <img src="{{ asset($product->Photo) }}" alt="{{ $product->ProductName }}"
                                    class="img-fluid rounded shadow" style="max-height: 300px;">
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
                                        <th width="30%">Product ID</th>
                                        <td>#{{ $product->ProductID }}</td>
                                    </tr>
                                    <tr>
                                        <th>Product Name</th>
                                        <td><strong>{{ $product->ProductName }}</strong></td>
                                    </tr>
                                    <tr>
                                        <th>Category</th>
                                        <td>
                                            @if(isset($product->category))
                                            <span class="badge badge-info badge-pill px-3">{{ $product->category->CategoryName }}</span>
                                            @else
                                            <span class="badge badge-secondary badge-pill px-3">Uncategorized</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Description</th>
                                        <td>{{ $product->Description ?: 'No description available' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Variants Count</th>
                                        <td>
                                            <span class="badge badge-secondary badge-pill px-3">
                                                <i class="fas fa-layer-group mr-1"></i>
                                                {{ $product->variants_count ?? $product->variants->count() ?? 0 }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>
                                            @if($product->Status == 1)
                                            <span class="badge badge-success badge-pill">
                                                <i class="fas fa-check mr-1"></i>Active
                                            </span>
                                            @else
                                            <span class="badge badge-danger badge-pill">
                                                <i class="fas fa-times mr-1"></i>Inactive
                                            </span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Created Date</th>
                                        <td>{{ date('m/d/Y H:i', strtotime($product->CreatedAt)) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Last Updated</th>
                                        <td>{{ date('m/d/Y H:i', strtotime($product->UpdatedAt)) }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="btn-group">
                            <a href="{{ route('admin.products.edit', $product->ProductID) }}" class="btn btn-warning">
                                <i class="fas fa-edit mr-2"></i>Edit
                            </a>
                            <form action="{{ route('admin.products.destroy', $product->ProductID) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this product?')">
                                    <i class="fas fa-trash mr-2"></i>Delete
                                </button>
                            </form>
                            <a href="{{ route('admin.products') }}" class="btn btn-default">
                                <i class="fas fa-arrow-left mr-2"></i>Back
                            </a>
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

    .table th {
        background-color: #f8f9fa;
        font-weight: 600;
    }

    .btn-group .btn {
        margin-right: 5px;
        border-radius: 6px;
    }
</style>
@endsection
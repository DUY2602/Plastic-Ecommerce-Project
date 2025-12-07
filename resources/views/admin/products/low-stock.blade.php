@extends('layouts.admin')

@section('title', 'Low Stock Items')

@section('admin-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">
                    <i class="fas fa-exclamation-triangle text-warning mr-2"></i>
                    Low Stock Items
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.products') }}">Products</a></li>
                    <li class="breadcrumb-item active">Low Stock</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">Items with Stock Less Than 5</h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.products') }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-box mr-1"></i> All Products
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($variants->count() > 0)
                        <div class="alert alert-warning alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5><i class="icon fas fa-exclamation-triangle"></i> Stock Alert!</h5>
                            There are <strong>{{ $variants->count() }}</strong> items with low stock (less than 5 items).
                            Consider restocking these items soon.
                        </div>
                        @endif

                        @if($variants->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="20%">Product</th>
                                        <th width="15%">Variant Details</th>
                                        <th width="10%">Price</th>
                                        <th width="10%">Stock</th>
                                        <th width="15%">Status</th>
                                        <th width="10%">Image</th>
                                        <th width="15%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($variants as $variant)
                                    <tr class="@if($variant->StockQuantity == 0) table-danger @else table-warning @endif">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @if($variant->product)
                                            <strong>{{ $variant->product->ProductName }}</strong>
                                            <br>
                                            <small class="text-muted">
                                                Category: {{ $variant->product->category->CategoryName ?? 'N/A' }}
                                            </small>
                                            @else
                                            <span class="text-danger">Product deleted</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($variant->colour)
                                            <div class="mb-1">
                                                <i class="fas fa-palette mr-1"></i>
                                                <strong>Colour:</strong> {{ $variant->colour->ColourName }}
                                                @if($variant->colour->HexCode)
                                                <span class="badge" style="background-color: <?php echo e($variant->colour->HexCode ?? '#cccccc'); ?>; width: 15px; height: 15px; display: inline-block;"></span> @endif
                                            </div>
                                            @endif
                                            @if($variant->volume)
                                            <div>
                                                <i class="fas fa-weight mr-1"></i>
                                                <strong>Volume:</strong> {{ $variant->volume->VolumeValue }}
                                            </div>
                                            @endif
                                        </td>
                                        <td class="font-weight-bold text-primary">
                                            ${{ number_format($variant->Price, 2) }}
                                        </td>
                                        <td>
                                            <div class="progress-group">
                                                <div class="progress">
                                                    @php
                                                    $percentage = min(100, ($variant->StockQuantity / 5) * 100);
                                                    @endphp
                                                    <div class="progress-bar <?php
                                                                                if ($variant->StockQuantity == 0) {
                                                                                    echo 'bg-danger';
                                                                                } elseif ($variant->StockQuantity < 3) {
                                                                                    echo 'bg-warning';
                                                                                } else {
                                                                                    echo 'bg-info';
                                                                                }
                                                                                ?>" style="width: <?php echo e($percentage ?? 0); ?>%"></div>
                                                </div>
                                                <span class="progress-text">
                                                    @if($variant->StockQuantity == 0)
                                                    <span class="badge badge-danger">
                                                        <i class="fas fa-times-circle mr-1"></i> 0
                                                    </span>
                                                    @elseif($variant->StockQuantity < 3)
                                                        <span class="badge badge-warning">
                                                        <i class="fas fa-exclamation-triangle mr-1"></i> {{ $variant->StockQuantity }}
                                                </span>
                                                @else
                                                <span class="badge badge-info">{{ $variant->StockQuantity }}</span>
                                                @endif
                                                / 5
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            @if($variant->Status == 1)
                                            <span class="badge badge-success">Active</span>
                                            @else
                                            <span class="badge badge-danger">Inactive</span>
                                            @endif
                                            <br>
                                            @if($variant->product && $variant->product->Status == 1)
                                            <span class="badge badge-success">Product Active</span>
                                            @elseif($variant->product)
                                            <span class="badge badge-danger">Product Inactive</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($variant->MainImage)
                                            <img src="{{ asset($variant->MainImage) }}" alt="Variant" class="img-thumbnail" style="max-height: 60px; max-width: 60px;">
                                            @elseif($variant->product && $variant->product->Photo)
                                            <img src="{{ asset($variant->product->Photo) }}" alt="Product" class="img-thumbnail" style="max-height: 60px; max-width: 60px;">
                                            @else
                                            <span class="text-muted"><i class="fas fa-image fa-2x"></i></span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($variant->product)
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="{{ route('admin.products.show', $variant->product->ProductID) }}"
                                                    class="btn btn-info" title="View Product">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.products.edit', $variant->product->ProductID) }}"
                                                    class="btn btn-warning" title="Edit Stock">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </div>
                                            <div class="mt-1">
                                                <small class="text-muted">Last updated:
                                                    @if($variant->product->UpdatedAt)
                                                    {{ \Carbon\Carbon::parse($variant->product->UpdatedAt)->format('d/m/Y') }}
                                                    @else
                                                    N/A
                                                    @endif
                                                </small>
                                            </div>
                                            @else
                                            <button class="btn btn-secondary btn-sm" disabled title="Product not available">
                                                <i class="fas fa-ban"></i> N/A
                                            </button>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <i class="fas fa-check-circle text-success fa-4x"></i>
                            </div>
                            <h3 class="text-success">Great! No Low Stock Items</h3>
                            <p class="text-muted">All items have sufficient stock (5 or more items).</p>
                            <a href="{{ route('admin.products') }}" class="btn btn-primary mt-3">
                                <i class="fas fa-shopping-cart mr-2"></i>View All Products
                            </a>
                        </div>
                        @endif
                    </div>
                    <!-- /.card-body -->

                    @if($variants->count() > 0)
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="alert alert-info mb-0">
                                    <h6><i class="fas fa-info-circle mr-2"></i> Stock Level Indicators:</h6>
                                    <div class="d-flex flex-wrap">
                                        <div class="mr-3 mb-1">
                                            <span class="badge badge-danger mr-1">Out of Stock</span> = 0 items
                                        </div>
                                        <div class="mr-3 mb-1">
                                            <span class="badge badge-warning mr-1">Critical</span> = 1-2 items
                                        </div>
                                        <div class="mr-3 mb-1">
                                            <span class="badge badge-info mr-1">Low</span> = 3-4 items
                                        </div>
                                        <div class="mb-1">
                                            <span class="badge badge-success mr-1">Good</span> = 5+ items
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 text-right">
                                <a href="{{ route('admin.products') }}" class="btn btn-primary">
                                    <i class="fas fa-boxes mr-2"></i>Manage All Products
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .table-warning {
        background-color: rgba(255, 193, 7, 0.1) !important;
    }

    .table-danger {
        background-color: rgba(220, 53, 69, 0.1) !important;
    }

    .table-warning:hover {
        background-color: rgba(255, 193, 7, 0.2) !important;
    }

    .table-danger:hover {
        background-color: rgba(220, 53, 69, 0.2) !important;
    }

    .progress {
        height: 10px;
        margin-bottom: 5px;
    }

    .progress-text {
        font-size: 0.85rem;
        font-weight: bold;
    }
</style>
@endsection
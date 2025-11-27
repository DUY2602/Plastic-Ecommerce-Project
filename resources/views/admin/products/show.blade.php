@extends('layouts.admin')

@section('title', 'Chi tiết sản phẩm')

@section('admin-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Chi tiết sản phẩm</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.products') }}">Sản phẩm</a></li>
                    <li class="breadcrumb-item active">Chi tiết</li>
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
                        <h3 class="card-title">Thông tin sản phẩm</h3>
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
                                        <th width="30%">ID sản phẩm</th>
                                        <td>#{{ $product->ProductID }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tên sản phẩm</th>
                                        <td><strong>{{ $product->ProductName }}</strong></td>
                                    </tr>
                                    <tr>
                                        <th>Danh mục</th>
                                        <td>
                                            @if(isset($product->category))
                                                <span class="badge badge-info badge-pill px-3">{{ $product->category->CategoryName }}</span>
                                            @else
                                                <span class="badge badge-secondary badge-pill px-3">Chưa phân loại</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Mô tả</th>
                                        <td>{{ $product->Description ?: 'Chưa có mô tả' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Số biến thể</th>
                                        <td>
                                            <span class="badge badge-secondary badge-pill px-3">
                                                <i class="fas fa-layer-group mr-1"></i>
                                                {{ $product->variants_count ?? $product->variants->count() ?? 0 }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Trạng thái</th>
                                        <td>
                                            @if($product->Status == 1)
                                                <span class="badge badge-success badge-pill">
                                                    <i class="fas fa-check mr-1"></i>Đang bán
                                                </span>
                                            @else
                                                <span class="badge badge-danger badge-pill">
                                                    <i class="fas fa-times mr-1"></i>Ngừng bán
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Ngày tạo</th>
                                        <td>{{ date('d/m/Y H:i', strtotime($product->CreatedAt)) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Ngày cập nhật</th>
                                        <td>{{ date('d/m/Y H:i', strtotime($product->UpdatedAt)) }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="btn-group">
                            <a href="{{ route('admin.products.edit', $product->ProductID) }}" class="btn btn-warning">
                                <i class="fas fa-edit mr-2"></i>Chỉnh sửa
                            </a>
                            <form action="{{ route('admin.products.destroy', $product->ProductID) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" 
                                        onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">
                                    <i class="fas fa-trash mr-2"></i>Xóa
                                </button>
                            </form>
                            <a href="{{ route('admin.products') }}" class="btn btn-default">
                                <i class="fas fa-arrow-left mr-2"></i>Quay lại
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
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
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
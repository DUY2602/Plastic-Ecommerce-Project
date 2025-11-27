@extends('layouts.admin')

@section('title', 'Chi tiết danh mục')

@section('admin-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Chi tiết danh mục</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.categories') }}">Danh mục</a></li>
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
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Thông tin danh mục</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th width="30%">ID danh mục</th>
                                <td>#{{ $category->CategoryID }}</td>
                            </tr>
                            <tr>
                                <th>Tên danh mục</th>
                                <td><strong>{{ $category->CategoryName }}</strong></td>
                            </tr>
                            <tr>
                                <th>Mô tả</th>
                                <td>{{ $category->Description ?: 'Chưa có mô tả' }}</td>
                            </tr>
                            <tr>
                                <th>Số sản phẩm</th>
                                <td>
                                    <span class="badge badge-primary badge-pill px-3">
                                        <i class="fas fa-cube mr-1"></i>
                                        {{ $category->products_count }} sản phẩm
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Trạng thái</th>
                                <td>
                                    @if($category->Status == 1)
                                        <span class="badge badge-success badge-pill">
                                            <i class="fas fa-eye mr-1"></i>Hiển thị
                                        </span>
                                    @else
                                        <span class="badge badge-danger badge-pill">
                                            <i class="fas fa-eye-slash mr-1"></i>Ẩn
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Ngày tạo</th>
                                <td>{{ date('d/m/Y H:i', strtotime($category->CreatedAt)) }}</td>
                            </tr>
                            <tr>
                                <th>Ngày cập nhật</th>
                                <td>{{ date('d/m/Y H:i', strtotime($category->UpdatedAt)) }}</td>
                            </tr>
                        </table>

                        @if($products->count() > 0)
                        <div class="mt-4">
                            <h5 class="mb-3">Sản phẩm thuộc danh mục này:</h5>
                            <div class="table-responsive">
                                <table class="table table-sm table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Tên sản phẩm</th>
                                            <th>Trạng thái</th>
                                            <th>Biến thể</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($products as $product)
                                        <tr>
                                            <td>#{{ $product->ProductID }}</td>
                                            <td>{{ $product->ProductName }}</td>
                                            <td>
                                                @if($product->Status == 1)
                                                    <span class="badge badge-success badge-sm">Đang bán</span>
                                                @else
                                                    <span class="badge badge-danger badge-sm">Ngừng bán</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge badge-secondary badge-sm">
                                                    {{ $product->variants->count() }} biến thể
                                                </span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="card-footer">
                        <div class="btn-group">
                            <a href="{{ route('admin.categories.edit', $category->CategoryID) }}" class="btn btn-warning">
                                <i class="fas fa-edit mr-2"></i>Chỉnh sửa
                            </a>
                            <form action="{{ route('admin.categories.destroy', $category->CategoryID) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" 
                                        onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này?')">
                                    <i class="fas fa-trash mr-2"></i>Xóa
                                </button>
                            </form>
                            <a href="{{ route('admin.categories') }}" class="btn btn-default">
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
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
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
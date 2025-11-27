@extends('layouts.admin')

@section('title', 'Quản lý sản phẩm')

@section('admin-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Quản lý sản phẩm</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Sản phẩm</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Danh sách sản phẩm</h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.products.create') }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-plus"></i> Thêm sản phẩm
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Hình ảnh</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Danh mục</th>
                                        <th>Số lượng biến thể</th>
                                        <th>Trạng thái</th>
                                        <th>Ngày tạo</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                    <tr>
                                        <td>{{ $product->ProductID }}</td>
                                        <td>
                                            <img src="{{ asset($product->Photo) }}" alt="{{ $product->ProductName }}" style="width: 50px; height: 50px; object-fit: cover;">
                                        </td>
                                        <td>{{ $product->ProductName }}</td>
                                        <td>
                                            <span class="badge badge-info">{{ $product->category->CategoryName }}</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-secondary">{{ $product->variants->count() }}</span>
                                        </td>
                                        <td>
                                            @if($product->Status == 1)
                                            <span class="badge badge-success">Đang bán</span>
                                            @else
                                            <span class="badge badge-danger">Ngừng bán</span>
                                            @endif
                                        </td>
                                        <td>{{ date('d/m/Y', strtotime($product->CreatedAt)) }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('admin.products.show', $product->ProductID) }}" class="btn btn-sm btn-info" title="Xem chi tiết">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.products.edit', $product->ProductID) }}" class="btn btn-sm btn-warning" title="Chỉnh sửa">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.products.destroy', $product->ProductID) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Xóa" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
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
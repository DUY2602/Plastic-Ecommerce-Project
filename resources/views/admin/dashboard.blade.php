@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('admin-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dashboard</h1>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <!-- Stats Cards -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $stats['total_products'] }}</h3>
                        <p>Tổng sản phẩm</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-box"></i>
                    </div>
                    <a href="{{ route('admin.products') }}" class="small-box-footer">Xem chi tiết <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $stats['total_categories'] }}</h3>
                        <p>Danh mục</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-list"></i>
                    </div>
                    <a href="{{ route('admin.categories') }}" class="small-box-footer">Xem chi tiết <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $stats['total_users'] }}</h3>
                        <p>Người dùng</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="{{ route('admin.users') }}" class="small-box-footer">Xem chi tiết <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $stats['low_stock_variants'] }}</h3>
                        <p>Sản phẩm sắp hết hàng</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <a href="#" class="small-box-footer">Xem chi tiết <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        <!-- Recent Products & Feedbacks -->
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Sản phẩm mới nhất</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Tên sản phẩm</th>
                                        <th>Danh mục</th>
                                        <th>Ngày tạo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentProducts as $product)
                                    <tr>
                                        <td>{{ $product->ProductName }}</td>
                                        <td>{{ $product->category->CategoryName }}</td>
                                        <td>{{ date('d/m/Y', strtotime($product->CreatedAt)) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Đánh giá mới nhất</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Sản phẩm</th>
                                        <th>Người dùng</th>
                                        <th>Đánh giá</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentFeedbacks as $feedback)
                                    <tr>
                                        <td>{{ $feedback->product->ProductName }}</td>
                                        <td>{{ $feedback->user->Username }}</td>
                                        <td>
                                            <span class="badge badge-warning">{{ $feedback->Rating }}/5</span>
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
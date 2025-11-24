@extends('layouts.admin')

@section('title', 'Quản lý người dùng')

@section('admin-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Quản lý người dùng</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Người dùng</li>
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
                        <h3 class="card-title">Danh sách người dùng</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tên đăng nhập</th>
                                        <th>Email</th>
                                        <th>Vai trò</th>
                                        <th>Trạng thái</th>
                                        <th>Ngày đăng ký</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->AccountID }}</td>
                                        <td>{{ $user->Username }}</td>
                                        <td>{{ $user->Email }}</td>
                                        <td>
                                            @if($user->Role == 1)
                                            <span class="badge badge-danger">Admin</span>
                                            @else
                                            <span class="badge badge-success">User</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($user->Status == 1)
                                            <span class="badge badge-success">Hoạt động</span>
                                            @else
                                            <span class="badge badge-danger">Khóa</span>
                                            @endif
                                        </td>
                                        <td>{{ date('d/m/Y H:i', strtotime($user->CreatedAt)) }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="#" class="btn btn-sm btn-info" title="Xem chi tiết">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="#" class="btn btn-sm btn-warning" title="Chỉnh sửa">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm {{ $user->Status == 1 ? 'btn-danger' : 'btn-success' }}" title="{{ $user->Status == 1 ? 'Khóa tài khoản' : 'Mở khóa tài khoản' }}">
                                                    <i class="fas {{ $user->Status == 1 ? 'fa-lock' : 'fa-unlock' }}"></i>
                                                </button>
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
@extends('layouts.admin')

@section('title', 'Chỉnh sửa người dùng')

@section('admin-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Chỉnh sửa người dùng</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.users') }}">Người dùng</a></li>
                    <li class="breadcrumb-item active">Chỉnh sửa</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Thông tin người dùng</h3>
                    </div>
                    <form action="{{ route('admin.users.update', $user->AccountID) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <label for="Username">Tên đăng nhập</label>
                                <input type="text" class="form-control" id="Username" name="Username"
                                    value="{{ old('Username', $user->Username) }}" required>
                            </div>

                            <div class="form-group">
                                <label for="Email">Email</label>
                                <input type="email" class="form-control" id="Email" name="Email"
                                    value="{{ old('Email', $user->Email) }}" required>
                            </div>

                            <div class="form-group">
                                <label for="Role">Vai trò</label>
                                <select class="form-control" id="Role" name="Role">
                                    <option value="0" {{ $user->Role == 0 ? 'selected' : '' }}>User</option>
                                    <option value="1" {{ $user->Role == 1 ? 'selected' : '' }}>Admin</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="Status">Trạng thái</label>
                                <select class="form-control" id="Status" name="Status">
                                    <option value="1" {{ $user->Status == 1 ? 'selected' : '' }}>Hoạt động</option>
                                    <option value="0" {{ $user->Status == 0 ? 'selected' : '' }}>Khóa</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="password">Mật khẩu mới (để trống nếu không đổi)</label>
                                <input type="password" class="form-control" id="password" name="password">
                                <small class="text-muted">Chỉ điền nếu muốn thay đổi mật khẩu</small>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                            <a href="{{ route('admin.users') }}" class="btn btn-default">Hủy</a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Thông tin thêm</h3>
                    </div>
                    <div class="card-body">
                        <dl class="row">
                            <dt class="col-sm-4">ID:</dt>
                            <dd class="col-sm-8">{{ $user->AccountID }}</dd>

                            <dt class="col-sm-4">Ngày đăng ký:</dt>
                            <dd class="col-sm-8">{{ date('d/m/Y H:i', strtotime($user->CreatedAt)) }}</dd>

                            <dt class="col-sm-4">Cập nhật cuối:</dt>
                            <dd class="col-sm-8">
                                @if($user->UpdatedAt)
                                {{ date('d/m/Y H:i', strtotime($user->UpdatedAt)) }}
                                @else
                                Chưa cập nhật
                                @endif
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
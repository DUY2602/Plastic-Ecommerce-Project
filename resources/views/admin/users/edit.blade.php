@extends('layouts.admin')

@section('title', 'Edit User')

@section('admin-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit User</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.users') }}">Users</a></li>
                    <li class="breadcrumb-item active">Edit</li>
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
                        <h3 class="card-title">User Information</h3>
                    </div>
                    <form action="{{ route('admin.users.update', $user->AccountID) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <label for="Username">Username</label>
                                <input type="text" class="form-control" id="Username" name="Username"
                                    value="{{ old('Username', $user->Username) }}" required>
                            </div>

                            <div class="form-group">
                                <label for="Email">Email</label>
                                <input type="email" class="form-control" id="Email" name="Email"
                                    value="{{ old('Email', $user->Email) }}" required>
                            </div>

                            <div class="form-group">
                                <label for="Role">Role</label>
                                <select class="form-control" id="Role" name="Role">
                                    <option value="0" {{ $user->Role == 0 ? 'selected' : '' }}>User</option>
                                    <option value="1" {{ $user->Role == 1 ? 'selected' : '' }}>Admin</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="Status">Status</label>
                                <select class="form-control" id="Status" name="Status">
                                    <option value="1" {{ $user->Status == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ $user->Status == 0 ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="password">New Password (leave blank to keep current)</label>
                                <input type="password" class="form-control" id="password" name="password">
                                <small class="text-muted">Only fill if you want to change the password</small>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('admin.users') }}" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Additional Information</h3>
                    </div>
                    <div class="card-body">
                        <dl class="row">
                            <dt class="col-sm-4">ID:</dt>
                            <dd class="col-sm-8">{{ $user->AccountID }}</dd>

                            <dt class="col-sm-4">Registration Date:</dt>
                            <dd class="col-sm-8">{{ date('m/d/Y H:i', strtotime($user->CreatedAt)) }}</dd>

                            <dt class="col-sm-4">Last Updated:</dt>
                            <dd class="col-sm-8">
                                @if($user->UpdatedAt)
                                {{ date('m/d/Y H:i', strtotime($user->UpdatedAt)) }}
                                @else
                                Not updated yet
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
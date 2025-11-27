@extends('layouts.admin')

@section('title', 'Thêm danh mục mới')

@section('admin-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Thêm danh mục mới</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.categories') }}">Danh mục</a></li>
                    <li class="breadcrumb-item active">Thêm mới</li>
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
                    <form action="{{ route('admin.categories.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="CategoryName">Tên danh mục *</label>
                                <input type="text" class="form-control @error('CategoryName') is-invalid @enderror" 
                                       id="CategoryName" name="CategoryName" 
                                       value="{{ old('CategoryName') }}" 
                                       placeholder="Nhập tên danh mục" required>
                                @error('CategoryName')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="Description">Mô tả danh mục</label>
                                <textarea class="form-control @error('Description') is-invalid @enderror" 
                                          id="Description" name="Description" 
                                          rows="4" placeholder="Nhập mô tả danh mục">{{ old('Description') }}</textarea>
                                @error('Description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="Status">Trạng thái *</label>
                                <select class="form-control @error('Status') is-invalid @enderror" 
                                        id="Status" name="Status" required>
                                    <option value="1" {{ old('Status', 1) == 1 ? 'selected' : '' }}>Hiển thị</option>
                                    <option value="0" {{ old('Status') == 0 ? 'selected' : '' }}>Ẩn</option>
                                </select>
                                @error('Status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save mr-2"></i>Lưu danh mục
                            </button>
                            <a href="{{ route('admin.categories') }}" class="btn btn-default">
                                <i class="fas fa-arrow-left mr-2"></i>Quay lại
                            </a>
                        </div>
                    </form>
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

.btn-success {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    border: none;
    border-radius: 6px;
    transition: all 0.3s ease;
}

.btn-success:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(40,167,69,0.3);
}
</style>
@endsection
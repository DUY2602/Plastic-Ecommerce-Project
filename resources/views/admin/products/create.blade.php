@extends('layouts.admin')

@section('title', 'Thêm sản phẩm mới')

@section('admin-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Thêm sản phẩm mới</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.products') }}">Sản phẩm</a></li>
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
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Thông tin sản phẩm</h3>
                    </div>
                    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="ProductName">Tên sản phẩm *</label>
                                <input type="text" class="form-control @error('ProductName') is-invalid @enderror" 
                                       id="ProductName" name="ProductName" 
                                       value="{{ old('ProductName') }}" 
                                       placeholder="Nhập tên sản phẩm" required>
                                @error('ProductName')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="CategoryID">Danh mục *</label>
                                <select class="form-control @error('CategoryID') is-invalid @enderror" 
                                        id="CategoryID" name="CategoryID" required>
                                    <option value="">Chọn danh mục</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->CategoryID }}" 
                                        {{ old('CategoryID') == $category->CategoryID ? 'selected' : '' }}>
                                        {{ $category->CategoryName }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('CategoryID')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="Description">Mô tả sản phẩm</label>
                                <textarea class="form-control @error('Description') is-invalid @enderror" 
                                          id="Description" name="Description" 
                                          rows="4" placeholder="Nhập mô tả sản phẩm">{{ old('Description') }}</textarea>
                                @error('Description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="Photo">Hình ảnh sản phẩm</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('Photo') is-invalid @enderror" 
                                           id="Photo" name="Photo" accept="image/*">
                                    <label class="custom-file-label" for="Photo">Chọn hình ảnh</label>
                                </div>
                                @error('Photo')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Định dạng: JPEG, PNG, JPG, GIF. Tối đa 2MB.</small>
                            </div>

                            <div class="form-group">
                                <label for="Status">Trạng thái *</label>
                                <select class="form-control @error('Status') is-invalid @enderror" 
                                        id="Status" name="Status" required>
                                    <option value="1" {{ old('Status', 1) == 1 ? 'selected' : '' }}>Đang bán</option>
                                    <option value="0" {{ old('Status') == 0 ? 'selected' : '' }}>Ngừng bán</option>
                                </select>
                                @error('Status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-2"></i>Lưu sản phẩm
                            </button>
                            <a href="{{ route('admin.products') }}" class="btn btn-default">
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
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    color: white;
    border-radius: 10px 10px 0 0 !important;
}

.btn-primary {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    border: none;
    border-radius: 6px;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,123,255,0.3);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Hiển thị tên file khi chọn ảnh
    document.getElementById('Photo').addEventListener('change', function(e) {
        var fileName = e.target.files[0].name;
        var nextSibling = e.target.nextElementSibling;
        nextSibling.innerText = fileName;
    });
});
</script>
@endsection
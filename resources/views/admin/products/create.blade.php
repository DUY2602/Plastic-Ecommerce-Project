@extends('layouts.admin')

@section('title', 'Add New Product')

@section('admin-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Add New Product</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.products') }}">Products</a></li>
                    <li class="breadcrumb-item active">Add New</li>
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
                        <h3 class="card-title">Product Information</h3>
                    </div>
                    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="ProductName">Product Name *</label>
                                <input type="text" class="form-control @error('ProductName') is-invalid @enderror"
                                    id="ProductName" name="ProductName"
                                    value="{{ old('ProductName') }}"
                                    placeholder="Enter product name" required>
                                @error('ProductName')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="CategoryID">Category *</label>
                                <select class="form-control @error('CategoryID') is-invalid @enderror"
                                    id="CategoryID" name="CategoryID" required>
                                    <option value="">Select category</option>
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
                                <label for="Description">Product Description</label>
                                <textarea class="form-control @error('Description') is-invalid @enderror"
                                    id="Description" name="Description"
                                    rows="4" placeholder="Enter product description">{{ old('Description') }}</textarea>
                                @error('Description')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="Photo">Product Image</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('Photo') is-invalid @enderror"
                                        id="Photo" name="Photo" accept="image/*">
                                    <label class="custom-file-label" for="Photo">Choose image</label>
                                </div>
                                @error('Photo')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Formats: JPEG, PNG, JPG, GIF. Max 2MB.</small>
                            </div>

                            <div class="form-group">
                                <label for="Status">Status *</label>
                                <select class="form-control @error('Status') is-invalid @enderror"
                                    id="Status" name="Status" required>
                                    <option value="1" {{ old('Status', 1) == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('Status') == 0 ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('Status')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-2"></i>Save Product
                            </button>
                            <a href="{{ route('admin.products') }}" class="btn btn-default">
                                <i class="fas fa-arrow-left mr-2"></i>Back
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
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
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
        box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Display file name when selecting image
        document.getElementById('Photo').addEventListener('change', function(e) {
            var fileName = e.target.files[0].name;
            var nextSibling = e.target.nextElementSibling;
            nextSibling.innerText = fileName;
        });
    });
</script>
@endsection
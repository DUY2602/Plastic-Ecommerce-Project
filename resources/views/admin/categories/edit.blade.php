@extends('layouts.admin')

@section('title', 'Edit Category')

@section('admin-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Category</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.categories') }}">Categories</a></li>
                    <li class="breadcrumb-item active">Edit</li>
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
                        <h3 class="card-title">Edit Category Information</h3>
                    </div>
                    <form action="{{ route('admin.categories.update', $category->CategoryID) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <label for="CategoryName">Category Name *</label>
                                <input type="text" class="form-control @error('CategoryName') is-invalid @enderror"
                                    id="CategoryName" name="CategoryName"
                                    value="{{ old('CategoryName', $category->CategoryName) }}"
                                    placeholder="Enter category name" required>
                                @error('CategoryName')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="Description">Category Description</label>
                                <textarea class="form-control @error('Description') is-invalid @enderror"
                                    id="Description" name="Description"
                                    rows="4" placeholder="Enter category description">{{ old('Description', $category->Description) }}</textarea>
                                @error('Description')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="Status">Status *</label>
                                <select class="form-control @error('Status') is-invalid @enderror"
                                    id="Status" name="Status" required>
                                    <option value="1" {{ old('Status', $category->Status) == 1 ? 'selected' : '' }}>Visible</option>
                                    <option value="0" {{ old('Status', $category->Status) == 0 ? 'selected' : '' }}>Hidden</option>
                                </select>
                                @error('Status')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save mr-2"></i>Update Category
                            </button>
                            <a href="{{ route('admin.categories') }}" class="btn btn-default">
                                <i class="fas fa-arrow-left mr-2"></i>Back
                            </a>
                            <a href="{{ route('admin.categories.show', $category->CategoryID) }}" class="btn btn-info">
                                <i class="fas fa-eye mr-2"></i>View Details
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin/categories/edit.css') }}">
@endsection
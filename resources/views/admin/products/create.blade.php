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
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Product Information</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
                        @csrf
                        <div class="card-body">
                            <!-- Basic Product Information -->
                            <div class="row">
                                <div class="col-md-8">
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
                                            rows="3" placeholder="Enter product description">{{ old('Description') }}</textarea>
                                        @error('Description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Photo">Product Main Image</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input @error('Photo') is-invalid @enderror"
                                                id="Photo" name="Photo" accept="image/*">
                                            <label class="custom-file-label" for="Photo">Choose main image</label>
                                        </div>
                                        @error('Photo')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">Formats: JPEG, PNG, JPG, GIF. Max 2MB.</small>
                                        <div id="imagePreview" class="mt-2" style="display: none;">
                                            <img src="" alt="Preview" class="img-thumbnail" style="max-height: 150px;">
                                        </div>
                                    </div>

                                    <!-- THÊM PHẦN DOCUMENT Ở ĐÂY -->
                                    <div class="form-group">
                                        <label for="document">Product Document (Optional)</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input @error('document') is-invalid @enderror"
                                                id="document" name="document" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt">
                                            <label class="custom-file-label" for="document">Choose document</label>
                                        </div>
                                        @error('document')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">
                                            Formats: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, TXT. Max 10MB.
                                        </small>
                                        <div id="documentName" class="mt-1 text-muted small"></div>
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
                            </div>

                            <!-- Product Variants Section -->
                            <div class="card card-secondary mt-4">
                                <div class="card-header">
                                    <h3 class="card-title">Product Variants</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-success btn-sm" id="addVariantBtn">
                                            <i class="fas fa-plus mr-1"></i> Add Variant
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="variantsTable">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th width="20%">Colour</th>
                                                    <th width="20%">Volume</th>
                                                    <th width="15%">Price ($)</th>
                                                    <th width="10%">Stock</th>
                                                    <th width="25%">Variant Image</th>
                                                    <th width="10%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="variantsTbody">
                                                <!-- Variant rows will be added here dynamically -->
                                                <tr class="no-variants">
                                                    <td colspan="6" class="text-center text-muted py-3">
                                                        No variants added yet. Click "Add Variant" to add one.
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
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
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin/products/create.css') }}">
@endsection

@section('scripts')
<script>
    // Lấy dữ liệu từ PHP sang JS - Sử dụng PHP trực tiếp
    const colours = <?php echo json_encode($colours ?? []); ?>;
    const volumes = <?php echo json_encode($volumes ?? []); ?>;
</script>
<script src="{{ asset('js/admin/products/create.js') }}"></script>
@endsection
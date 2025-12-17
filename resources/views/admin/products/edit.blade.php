@extends('layouts.admin')

@section('title', 'Edit Product')

@section('admin-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Product</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.products') }}">Products</a></li>
                    <li class="breadcrumb-item active">Edit</li>
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
                    <form action="{{ route('admin.products.update', $product->ProductID) }}" method="POST" enctype="multipart/form-data" id="productForm">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <!-- Basic Product Information -->
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="ProductName">Product Name *</label>
                                        <input type="text" class="form-control @error('ProductName') is-invalid @enderror"
                                            id="ProductName" name="ProductName"
                                            value="{{ old('ProductName', $product->ProductName) }}"
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
                                                {{ old('CategoryID', $product->CategoryID) == $category->CategoryID ? 'selected' : '' }}>
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
                                            rows="3" placeholder="Enter product description">{{ old('Description', $product->Description) }}</textarea>
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
                                            <label class="custom-file-label" for="Photo">Choose new image</label>
                                        </div>
                                        @error('Photo')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">Formats: JPEG, PNG, JPG, GIF. Max 2MB.</small>

                                        <!-- Hiển thị ảnh hiện tại -->
                                        @if($product->Photo)
                                        <div class="mt-2">
                                            <p>Current Image:</p>
                                            <img src="{{ asset($product->Photo) }}" alt="Current Product Image" class="img-thumbnail" style="max-height: 150px;">
                                        </div>
                                        @endif

                                        <div id="imagePreview" class="mt-2" style="display: none;">
                                            <p>New Image Preview:</p>
                                            <img src="" alt="Preview" class="img-thumbnail" style="max-height: 150px;">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="document">Product Document</label>

                                        @if($product->DocumentURL && file_exists(public_path($product->DocumentURL)))
                                        <div class="mb-2">
                                            <div class="alert alert-info p-2">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <i class="fas fa-file-pdf mr-2"></i>
                                                        <strong>Current Document:</strong>
                                                        {{ basename($product->DocumentURL) }}
                                                    </div>
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="{{ asset($product->DocumentURL) }}" target="_blank"
                                                            class="btn btn-info btn-sm" title="View">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('product.download', $product->ProductID) }}"
                                                            class="btn btn-success btn-sm" title="Download">
                                                            <i class="fas fa-download"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-danger btn-sm"
                                                            onclick="confirmDeleteDocument()" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif

                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input @error('document') is-invalid @enderror"
                                                id="document" name="document" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt">
                                            <label class="custom-file-label" for="document">
                                                {{ $product->DocumentURL ? 'Change document' : 'Choose document' }}
                                            </label>
                                        </div>
                                        @error('document')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">
                                            Formats: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, TXT. Max 10MB.
                                        </small>
                                    </div>

                                    <!-- Thêm form xóa document ẩn -->
                                    <form id="deleteDocumentForm"
                                        action="{{ route('admin.products.delete-document', $product->ProductID) }}"
                                        method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>

                                    <div class="form-group">
                                        <label for="Status">Status *</label>
                                        <select class="form-control @error('Status') is-invalid @enderror"
                                            id="Status" name="Status" required>
                                            <option value="1" {{ old('Status', $product->Status) == 1 ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ old('Status', $product->Status) == 0 ? 'selected' : '' }}>Inactive</option>
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
                            <!-- THAY ĐỔI: type="button" thay vì type="submit" -->
                            <button type="button" id="updateProductBtn" class="btn btn-primary">
                                <i class="fas fa-save mr-2"></i>Update Product
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
<link rel="stylesheet" href="{{ asset('css/admin/products/edit.css') }}">
@endsection

@section('scripts')
<script>
    // Lấy dữ liệu từ PHP
    const colours = <?php echo json_encode($colours ?? []); ?>;
    const volumes = <?php echo json_encode($volumes ?? []); ?>;
    const existingVariants = <?php echo json_encode($product->variants ?? []); ?>;
</script>
<script src="{{ asset('js/admin/products/edit.js') }}"></script>
@endsection
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
                            <button type="submit" class="btn btn-primary">
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

    .card-secondary .card-header {
        background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
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

    .variant-row {
        transition: all 0.3s ease;
    }

    .variant-row:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }

    .remove-variant {
        cursor: pointer;
        color: #dc3545;
        transition: all 0.3s ease;
    }

    .remove-variant:hover {
        color: #bd2130;
        transform: scale(1.2);
    }

    .variant-image-preview {
        max-height: 80px;
        max-width: 100%;
        object-fit: cover;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let variantCounter = 0;

        // Lấy dữ liệu từ PHP sang JS - Sử dụng PHP trực tiếp
        const colours = <?php echo json_encode($colours ?? []); ?>;
        const volumes = <?php echo json_encode($volumes ?? []); ?>;
        const existingVariants = <?php echo json_encode($product->variants ?? []); ?>;

        // Display file name and preview when selecting main image
        document.getElementById('Photo').addEventListener('change', function(e) {
            var fileName = e.target.files[0]?.name || 'Choose image';
            var nextSibling = e.target.nextElementSibling;
            nextSibling.innerText = fileName;

            // Show preview
            if (e.target.files && e.target.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var preview = document.getElementById('imagePreview');
                    preview.style.display = 'block';
                    preview.querySelector('img').src = e.target.result;
                }
                reader.readAsDataURL(e.target.files[0]);
            }
        });

        // Add variant button
        document.getElementById('addVariantBtn').addEventListener('click', function() {
            addVariantRow();
        });

        function addVariantRow(variantData = {}) {
            // Remove "no variants" message
            const noVariantsRow = document.querySelector('.no-variants');
            if (noVariantsRow) {
                noVariantsRow.remove();
            }

            const tbody = document.getElementById('variantsTbody');
            const rowId = variantCounter++;

            // Tạo option cho colour select
            let colourOptions = '<option value="">Select Colour</option>';
            if (colours && Array.isArray(colours)) {
                colours.forEach(colour => {
                    colourOptions += `<option value="${colour.ColourID}" ${variantData.colour_id == colour.ColourID ? 'selected' : ''}>
                        ${colour.ColourName}
                    </option>`;
                });
            }

            // Tạo option cho volume select
            let volumeOptions = '<option value="">Select Volume</option>';
            if (volumes && Array.isArray(volumes)) {
                volumes.forEach(volume => {
                    volumeOptions += `<option value="${volume.VolumeID}" ${variantData.volume_id == volume.VolumeID ? 'selected' : ''}>
                        ${volume.VolumeValue}
                    </option>`;
                });
            }

            // Kiểm tra xem có ID variant không (cho edit)
            const variantIdField = variantData.VariantID ?
                `<input type="hidden" name="variants[${rowId}][id]" value="${variantData.VariantID}">` : '';

            // Hiển thị ảnh hiện tại nếu có
            const currentImageHtml = variantData.MainImage ?
                `<div class="mb-1">
                    <small>Current Image:</small><br>
                    <img src="${variantData.MainImage}" alt="Current" class="img-thumbnail variant-image-preview">
                </div>` : '';

            const row = document.createElement('tr');
            row.className = 'variant-row';
            row.innerHTML = `
                ${variantIdField}
                <td>
                    <select name="variants[${rowId}][colour_id]" class="form-control form-control-sm" required>
                        ${colourOptions}
                    </select>
                </td>
                <td>
                    <select name="variants[${rowId}][volume_id]" class="form-control form-control-sm" required>
                        ${volumeOptions}
                    </select>
                </td>
                <td>
                    <input type="number" step="0.01" min="0" 
                           name="variants[${rowId}][price]" 
                           class="form-control form-control-sm" 
                           value="${variantData.Price || variantData.price || ''}"
                           placeholder="0.00" required>
                </td>
                <td>
                    <input type="number" min="0" 
                           name="variants[${rowId}][stock]" 
                           class="form-control form-control-sm" 
                           value="${variantData.StockQuantity || variantData.stock || ''}"
                           placeholder="0" required>
                </td>
                <td>
                    <div class="form-group mb-0">
                        ${currentImageHtml}
                        <div class="custom-file custom-file-sm">
                            <input type="file" class="custom-file-input variant-image-input" 
                                   name="variants[${rowId}][main_image]" 
                                   accept="image/*"
                                   data-preview-id="preview_${rowId}">
                            <label class="custom-file-label">Choose new image</label>
                        </div>
                        <small class="form-text text-muted">Max 2MB</small>
                        <div id="preview_${rowId}" class="mt-1 variant-image-preview-container" style="display: none;">
                            <small>New Image Preview:</small><br>
                            <img src="" alt="Preview" class="img-thumbnail variant-image-preview">
                        </div>
                    </div>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-danger btn-sm remove-variant" 
                            onclick="removeVariantRow(this)">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;

            tbody.appendChild(row);

            // Thêm event listener cho file input mới
            const fileInput = row.querySelector('.variant-image-input');
            const previewContainer = row.querySelector('.variant-image-preview-container');
            const previewImg = row.querySelector('.variant-image-preview');
            const fileLabel = row.querySelector('.custom-file-label');

            if (fileInput) {
                fileInput.addEventListener('change', function(e) {
                    var fileName = e.target.files[0]?.name || 'Choose image';
                    fileLabel.innerText = fileName;

                    // Show preview
                    if (e.target.files && e.target.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            previewContainer.style.display = 'block';
                            previewImg.src = e.target.result;
                        }
                        reader.readAsDataURL(e.target.files[0]);
                    }
                });
            }
        }

        // Remove variant row
        window.removeVariantRow = function(button) {
            const row = button.closest('tr');
            row.remove();

            // Show "no variants" message if table is empty
            const tbody = document.getElementById('variantsTbody');
            if (tbody.children.length === 0) {
                const noVariantsRow = document.createElement('tr');
                noVariantsRow.className = 'no-variants';
                noVariantsRow.innerHTML = `
                    <td colspan="6" class="text-center text-muted py-3">
                        No variants added yet. Click "Add Variant" to add one.
                    </td>
                `;
                tbody.appendChild(noVariantsRow);
            }
        };

        // Tự động thêm các variant hiện có khi tải trang
        if (existingVariants && Array.isArray(existingVariants)) {
            existingVariants.forEach(variant => {
                // Thêm đường dẫn đầy đủ cho ảnh
                const mainImageUrl = variant.MainImage ? `{{ asset('') }}${variant.MainImage}` : null;

                addVariantRow({
                    VariantID: variant.VariantID,
                    colour_id: variant.ColourID || variant.colour_id,
                    volume_id: variant.VolumeID || variant.volume_id,
                    Price: variant.Price,
                    StockQuantity: variant.StockQuantity,
                    MainImage: mainImageUrl
                });
            });
        }

        // Form validation before submit
        document.getElementById('productForm').addEventListener('submit', function(e) {
            // Check if at least one variant is added
            const hasVariants = document.querySelectorAll('#variantsTbody tr:not(.no-variants)').length > 0;
            if (!hasVariants) {
                e.preventDefault();
                alert('Please add at least one product variant.');
                return false;
            }

            // Validate variant combinations (unique colour-volume)
            const combinations = new Set();
            const variantRows = document.querySelectorAll('#variantsTbody tr:not(.no-variants)');
            let hasDuplicate = false;

            variantRows.forEach(row => {
                const colourSelect = row.querySelector('select[name*="colour_id"]');
                const volumeSelect = row.querySelector('select[name*="volume_id"]');

                if (colourSelect && volumeSelect) {
                    const colourId = colourSelect.value;
                    const volumeId = volumeSelect.value;

                    if (colourId && volumeId) {
                        const combo = `${colourId}-${volumeId}`;
                        if (combinations.has(combo)) {
                            hasDuplicate = true;
                            row.style.backgroundColor = '#ffe6e6';
                        } else {
                            combinations.add(combo);
                        }
                    }
                }
            });

            if (hasDuplicate) {
                e.preventDefault();
                alert('Duplicate colour-volume combination found. Please ensure each variant has unique combination.');
                return false;
            }
        });
    });
</script>
@endsection
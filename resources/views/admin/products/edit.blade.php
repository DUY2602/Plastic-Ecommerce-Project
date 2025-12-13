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
        color: #000000ff;
        transition: all 0.3s ease;
    }

    .remove-variant:hover {
        color: #ffffffff;
        transform: scale(1.2);
    }

    .variant-image-preview {
        max-height: 80px;
        max-width: 100%;
        object-fit: cover;
    }
</style>

<!-- THAY THẾ TOÀN BỘ PHẦN JavaScript bằng code này: -->

<!-- THAY THẾ TOÀN BỘ PHẦN JavaScript bằng code này: -->

<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('=== EDIT PRODUCT PAGE LOADED ===');

        // Khai báo biến
        let variantCounter = 0;
        let isSubmitting = false;

        // Lấy dữ liệu từ PHP
        const colours = <?php echo json_encode($colours ?? []); ?>;
        const volumes = <?php echo json_encode($volumes ?? []); ?>;
        const existingVariants = <?php echo json_encode($product->variants ?? []); ?>;

        // ========== PHẦN QUAN TRỌNG: XỬ LÝ SUBMIT ==========
        const updateButton = document.getElementById('updateProductBtn');
        const productForm = document.getElementById('productForm');

        if (updateButton && productForm) {
            updateButton.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                console.log('=== UPDATE BUTTON CLICKED ===');

                if (isSubmitting) {
                    console.log('Already submitting, please wait...');
                    return false;
                }

                // Validate form
                if (validateForm()) {
                    console.log('Form validation passed, submitting...');
                    performFormSubmit();
                } else {
                    console.log('Form validation failed');
                }

                return false;
            });
        }

        // ========== VALIDATE FORM ==========
        function validateForm() {
            console.log('=== VALIDATING FORM ===');

            // 1. Kiểm tra có variant không
            const variantRows = document.querySelectorAll('#variantsTbody tr.variant-row');
            console.log('Found variant rows:', variantRows.length);

            if (variantRows.length === 0) {
                alert('Please add at least one product variant.');
                return false;
            }

            // 2. Kiểm tra từng variant
            let isValid = true;
            let errorMessages = [];
            const combinations = new Set();

            variantRows.forEach((row, index) => {
                const colourSelect = row.querySelector('select[name*="colour_id"]');
                const volumeSelect = row.querySelector('select[name*="volume_id"]');
                const priceInput = row.querySelector('input[name*="price"]');
                const stockInput = row.querySelector('input[name*="stock"]');

                // Reset error styles
                if (colourSelect) colourSelect.style.borderColor = '';
                if (volumeSelect) volumeSelect.style.borderColor = '';
                if (priceInput) priceInput.style.borderColor = '';
                if (stockInput) stockInput.style.borderColor = '';

                // Kiểm tra các trường bắt buộc
                if (!colourSelect || !colourSelect.value) {
                    errorMessages.push(`Variant ${index + 1}: Please select a colour`);
                    if (colourSelect) colourSelect.style.borderColor = 'red';
                    isValid = false;
                }

                if (!volumeSelect || !volumeSelect.value) {
                    errorMessages.push(`Variant ${index + 1}: Please select a volume`);
                    if (volumeSelect) volumeSelect.style.borderColor = 'red';
                    isValid = false;
                }

                if (!priceInput || !priceInput.value || parseFloat(priceInput.value) <= 0) {
                    errorMessages.push(`Variant ${index + 1}: Please enter a valid price (greater than 0)`);
                    if (priceInput) priceInput.style.borderColor = 'red';
                    isValid = false;
                }

                if (!stockInput || stockInput.value === '' || parseInt(stockInput.value) < 0) {
                    errorMessages.push(`Variant ${index + 1}: Please enter a valid stock quantity`);
                    if (stockInput) stockInput.style.borderColor = 'red';
                    isValid = false;
                }

                // Kiểm tra trùng lặp màu + thể tích
                if (colourSelect && colourSelect.value && volumeSelect && volumeSelect.value) {
                    const combo = colourSelect.value + '-' + volumeSelect.value;
                    if (combinations.has(combo)) {
                        errorMessages.push(`Variant ${index + 1}: Duplicate colour-volume combination`);
                        isValid = false;
                    } else {
                        combinations.add(combo);
                    }
                }
            });

            // Hiển thị lỗi nếu có
            if (!isValid && errorMessages.length > 0) {
                let errorMsg = 'Please fix the following errors:\n\n';
                errorMessages.slice(0, 5).forEach((msg, i) => {
                    errorMsg += `${i + 1}. ${msg}\n`;
                });

                if (errorMessages.length > 5) {
                    errorMsg += `\n...and ${errorMessages.length - 5} more errors`;
                }

                alert(errorMsg);
                return false;
            }

            return true;
        }

        function performFormSubmit() {
            console.log('=== PERFORMING FORM SUBMIT ===');

            if (isSubmitting) return false;
            isSubmitting = true;

            // Disable button và show loading
            if (updateButton) {
                const originalHtml = updateButton.innerHTML;
                updateButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Updating...';
                updateButton.disabled = true;
            }

            // QUAN TRỌNG: Xóa tất cả các _method field cũ
            const oldMethodInputs = productForm.querySelectorAll('input[name="_method"]');
            oldMethodInputs.forEach(input => input.remove());

            // Tạo method input mới cho PUT
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'PUT';
            productForm.appendChild(methodInput);

            // Đảm bảo form method là POST (vì Laravel dùng POST + _method)
            productForm.method = 'POST';

            // DEBUG: Log form data
            console.log('=== FORM DATA DEBUG ===');
            const formData = new FormData(productForm);
            for (let [key, value] of formData.entries()) {
                if (typeof value === 'string') {
                    console.log(key + ':', value);
                } else if (value instanceof File) {
                    console.log(key + ':', value.name, '(File)');
                }
            }

            // Submit form
            setTimeout(() => {
                console.log('Submitting form with PUT method');
                console.log('Form action:', productForm.action);
                productForm.submit();
            }, 100);

            return true;
        }

        // ========== CÁC HÀM KHÁC ==========

        // Display file name and preview when selecting main image
        const photoInput = document.getElementById('Photo');
        if (photoInput) {
            photoInput.addEventListener('change', function(e) {
                var fileName = e.target.files[0]?.name || 'Choose image';
                var nextSibling = e.target.nextElementSibling;
                if (nextSibling) nextSibling.innerText = fileName;

                if (e.target.files && e.target.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        var preview = document.getElementById('imagePreview');
                        if (preview) {
                            preview.style.display = 'block';
                            const img = preview.querySelector('img');
                            if (img) img.src = e.target.result;
                        }
                    }
                    reader.readAsDataURL(e.target.files[0]);
                }
            });
        }

        // Add variant button
        document.getElementById('addVariantBtn').addEventListener('click', function() {
            addVariantRow();
        });

        function addVariantRow(variantData = {}) {
            const noVariantsRow = document.querySelector('.no-variants');
            if (noVariantsRow) noVariantsRow.remove();

            const tbody = document.getElementById('variantsTbody');
            const rowId = variantCounter++;

            // Tạo option cho colour select
            let colourOptions = '<option value="">Select Colour</option>';
            if (colours && Array.isArray(colours)) {
                colours.forEach(colour => {
                    const selected = variantData.colour_id == colour.ColourID ? 'selected' : '';
                    colourOptions += `<option value="${colour.ColourID}" ${selected}>${colour.ColourName}</option>`;
                });
            }

            // Tạo option cho volume select
            let volumeOptions = '<option value="">Select Volume</option>';
            if (volumes && Array.isArray(volumes)) {
                volumes.forEach(volume => {
                    const selected = variantData.volume_id == volume.VolumeID ? 'selected' : '';
                    volumeOptions += `<option value="${volume.VolumeID}" ${selected}>${volume.VolumeValue}</option>`;
                });
            }

            // Variant ID field
            const variantIdField = variantData.VariantID ?
                `<input type="hidden" name="variants[${rowId}][id]" value="${variantData.VariantID}">` : '';

            // Current image HTML
            const currentImageHtml = variantData.MainImage ?
                `<div class="mb-2 current-image-container" id="current_image_${rowId}">
                <small class="text-muted">Current Image:</small><br>
                <img src="${variantData.MainImage}" alt="Current" class="img-thumbnail variant-image-preview">
            </div>` :
                '<div class="mb-2 current-image-container" id="current_image_' + rowId + '" style="display:none;"></div>';

            const row = document.createElement('tr');
            row.className = 'variant-row';
            row.setAttribute('data-row-id', rowId);
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
                <input type="number" step="0.01" min="0.01" 
                       name="variants[${rowId}][price]" 
                       class="form-control form-control-sm" 
                       value="${variantData.Price || variantData.price || '0.00'}"
                       placeholder="0.00" required>
            </td>
            <td>
                <input type="number" min="0" 
                       name="variants[${rowId}][stock]" 
                       class="form-control form-control-sm" 
                       value="${variantData.StockQuantity || variantData.stock || '0'}"
                       placeholder="0" required>
            </td>
            <td>
                <div class="form-group mb-0">
                    ${currentImageHtml}
                    <div class="custom-file custom-file-sm">
                        <input type="file" class="custom-file-input variant-image-input" 
                               name="variants[${rowId}][main_image]" 
                               accept="image/*"
                               data-row-id="${rowId}">
                        <label class="custom-file-label" id="file_label_${rowId}">
                            ${variantData.MainImage ? 'Change image' : 'Choose image'}
                        </label>
                    </div>
                    <small class="form-text text-muted">Max 2MB</small>
                    <div id="new_image_preview_${rowId}" class="mt-1 new-image-preview-container" style="display: none;">
                        <small class="text-success">New Image Preview:</small><br>
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

            // File input event listener
            const fileInput = row.querySelector('.variant-image-input');
            const fileLabel = row.querySelector(`#file_label_${rowId}`);
            const newImagePreview = row.querySelector(`#new_image_preview_${rowId}`);
            const newImagePreviewImg = newImagePreview.querySelector('img');

            if (fileInput) {
                fileInput.addEventListener('change', function(e) {
                    const rowId = this.getAttribute('data-row-id');
                    const currentImageContainer = document.querySelector(`#current_image_${rowId}`);
                    const fileName = e.target.files[0]?.name || 'Choose image';

                    fileLabel.innerText = fileName;

                    if (e.target.files && e.target.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            newImagePreview.style.display = 'block';
                            newImagePreviewImg.src = e.target.result;
                        }
                        reader.readAsDataURL(e.target.files[0]);
                    }

                    if (currentImageContainer && e.target.files[0]) {
                        currentImageContainer.style.display = 'none';
                    }

                    if (!e.target.files[0] && variantData.MainImage) {
                        currentImageContainer.style.display = 'block';
                        newImagePreview.style.display = 'none';
                    }
                });
            }
        }

        // Remove variant row
        window.removeVariantRow = function(button) {
            if (isSubmitting) return;

            const row = button.closest('tr');
            row.remove();

            const tbody = document.getElementById('variantsTbody');
            const remainingRows = tbody.querySelectorAll('tr:not(.no-variants)');

            if (remainingRows.length === 0) {
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

        // ========== LOAD EXISTING VARIANTS ==========
        if (existingVariants && Array.isArray(existingVariants) && existingVariants.length > 0) {
            console.log('Adding existing variants:', existingVariants.length);

            const noVariantsRow = document.querySelector('.no-variants');
            if (noVariantsRow) noVariantsRow.remove();

            existingVariants.forEach((variant, index) => {
                addVariantRow({
                    VariantID: variant.VariantID,
                    colour_id: variant.ColourID,
                    volume_id: variant.VolumeID,
                    Price: variant.Price,
                    StockQuantity: variant.StockQuantity,
                    MainImage: variant.full_image_url || null
                });
            });
        }

        // Document input
        const documentInput = document.getElementById('document');
        if (documentInput) {
            documentInput.addEventListener('change', function(e) {
                var fileName = e.target.files[0]?.name || 'Choose document';
                var nextSibling = e.target.nextElementSibling;
                if (nextSibling) nextSibling.innerText = fileName;
            });
        }

        // Confirm delete document
        window.confirmDeleteDocument = function() {
            if (confirm('Are you sure you want to delete this document?')) {
                document.getElementById('deleteDocumentForm').submit();
            }
        }

        console.log('=== INITIALIZATION COMPLETE ===');
    });
</script>
@endsection
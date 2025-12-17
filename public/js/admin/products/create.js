document.addEventListener("DOMContentLoaded", function () {
    let variantCounter = 0;

    // Display file name and preview when selecting main image
    document.getElementById("Photo").addEventListener("change", function (e) {
        var fileName = e.target.files[0]?.name || "Choose image";
        var nextSibling = e.target.nextElementSibling;
        nextSibling.innerText = fileName;

        // Show preview
        if (e.target.files && e.target.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                var preview = document.getElementById("imagePreview");
                preview.style.display = "block";
                preview.querySelector("img").src = e.target.result;
            };
            reader.readAsDataURL(e.target.files[0]);
        }
    });

    // Display file name for document
    document
        .getElementById("document")
        .addEventListener("change", function (e) {
            var fileName = e.target.files[0]?.name || "Choose document";
            var nextSibling = e.target.nextElementSibling;
            nextSibling.innerText = fileName;

            // Show file name
            document.getElementById("documentName").innerHTML =
                '<i class="fas fa-file mr-1"></i>' + fileName;
        });

    // Add variant button
    document
        .getElementById("addVariantBtn")
        .addEventListener("click", function () {
            addVariantRow();
        });

    function addVariantRow(variantData = {}) {
        // Remove "no variants" message
        const noVariantsRow = document.querySelector(".no-variants");
        if (noVariantsRow) {
            noVariantsRow.remove();
        }

        const tbody = document.getElementById("variantsTbody");
        const rowId = variantCounter++;

        // Tạo option cho colour select
        let colourOptions = '<option value="">Select Colour</option>';
        if (colours && Array.isArray(colours)) {
            colours.forEach((colour) => {
                colourOptions += `<option value="${colour.ColourID}" ${
                    variantData.colour_id == colour.ColourID ? "selected" : ""
                }>
                        ${colour.ColourName}
                    </option>`;
            });
        }

        // Tạo option cho volume select
        let volumeOptions = '<option value="">Select Volume</option>';
        if (volumes && Array.isArray(volumes)) {
            volumes.forEach((volume) => {
                volumeOptions += `<option value="${volume.VolumeID}" ${
                    variantData.volume_id == volume.VolumeID ? "selected" : ""
                }>
                        ${volume.VolumeValue}
                    </option>`;
            });
        }

        const row = document.createElement("tr");
        row.className = "variant-row";
        row.innerHTML = `
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
                           value="${variantData.price || ""}"
                           placeholder="0.00" required>
                </td>
                <td>
                    <input type="number" min="0" 
                           name="variants[${rowId}][stock]" 
                           class="form-control form-control-sm" 
                           value="${variantData.stock || ""}"
                           placeholder="0" required>
                </td>
                <td>
                    <div class="form-group mb-0">
                        <div class="custom-file custom-file-sm">
                            <input type="file" class="custom-file-input variant-image-input" 
                                   name="variants[${rowId}][main_image]" 
                                   accept="image/*"
                                   data-preview-id="preview_${rowId}">
                            <label class="custom-file-label">Choose image</label>
                        </div>
                        <small class="form-text text-muted">Max 2MB</small>
                        <div id="preview_${rowId}" class="mt-1 variant-image-preview-container" style="display: none;">
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
        const fileInput = row.querySelector(".variant-image-input");
        const previewContainer = row.querySelector(
            ".variant-image-preview-container"
        );
        const previewImg = row.querySelector(".variant-image-preview");
        const fileLabel = row.querySelector(".custom-file-label");

        fileInput.addEventListener("change", function (e) {
            var fileName = e.target.files[0]?.name || "Choose image";
            fileLabel.innerText = fileName;

            // Show preview
            if (e.target.files && e.target.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    previewContainer.style.display = "block";
                    previewImg.src = e.target.result;
                };
                reader.readAsDataURL(e.target.files[0]);
            }
        });
    }

    // Remove variant row
    window.removeVariantRow = function (button) {
        const row = button.closest("tr");
        row.remove();

        // Show "no variants" message if table is empty
        const tbody = document.getElementById("variantsTbody");
        if (tbody.children.length === 0) {
            const noVariantsRow = document.createElement("tr");
            noVariantsRow.className = "no-variants";
            noVariantsRow.innerHTML = `
                    <td colspan="6" class="text-center text-muted py-3">
                        No variants added yet. Click "Add Variant" to add one.
                    </td>
                `;
            tbody.appendChild(noVariantsRow);
        }
    };

    // Form validation before submit
    document
        .getElementById("productForm")
        .addEventListener("submit", function (e) {
            // Check if at least one variant is added
            const hasVariants =
                document.querySelectorAll("#variantsTbody tr:not(.no-variants)")
                    .length > 0;
            if (!hasVariants) {
                e.preventDefault();
                alert("Please add at least one product variant.");
                return false;
            }

            // Validate variant combinations (unique colour-volume)
            const combinations = new Set();
            const variantRows = document.querySelectorAll(
                "#variantsTbody tr:not(.no-variants)"
            );
            let hasDuplicate = false;

            variantRows.forEach((row) => {
                const colourSelect = row.querySelector(
                    'select[name*="colour_id"]'
                );
                const volumeSelect = row.querySelector(
                    'select[name*="volume_id"]'
                );

                if (colourSelect && volumeSelect) {
                    const colourId = colourSelect.value;
                    const volumeId = volumeSelect.value;

                    if (colourId && volumeId) {
                        const combo = `${colourId}-${volumeId}`;
                        if (combinations.has(combo)) {
                            hasDuplicate = true;
                            row.style.backgroundColor = "#ffe6e6";
                        } else {
                            combinations.add(combo);
                        }
                    }
                }
            });

            if (hasDuplicate) {
                e.preventDefault();
                alert(
                    "Duplicate colour-volume combination found. Please ensure each variant has unique combination."
                );
                return false;
            }
        });

    // Tự động thêm 1 variant mặc định khi tạo sản phẩm mới
    addVariantRow();
});

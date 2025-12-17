// public/js/show.js - FIXED VERSION
document.addEventListener("DOMContentLoaded", function () {
    // Get data from HTML attributes
    const variantsDataElement = document.getElementById("variants-data");
    const firstColorElement = document.getElementById("first-color");
    const firstVolumeElement = document.getElementById("first-volume");
    const defaultPriceElement = document.getElementById("default-price");

    const allVariants = variantsDataElement
        ? JSON.parse(variantsDataElement.dataset.variants)
        : {};
    let selectedColor = firstColorElement
        ? firstColorElement.dataset.color
        : "";
    let selectedSize = firstVolumeElement
        ? firstVolumeElement.dataset.volume
        : "";
    const defaultPrice = defaultPriceElement
        ? defaultPriceElement.dataset.price
        : "0";

    const mainImage = document.getElementById("mainProductImage");
    const colorItems = document.querySelectorAll(".color__item");
    const sizeItems = document.querySelectorAll(".size__item");
    const variantPrice = document.getElementById("variantPrice");
    const mainProductPrice = document.getElementById("mainProductPrice");
    const variantStock = document.getElementById("variantStock");
    const selectedVariantIdInput = document.getElementById("selectedVariantId");

    const hasVariants = Object.keys(allVariants).length > 0;

    // Set custom styles for color swatches
    document
        .querySelectorAll(".color-swatch[data-custom-style]")
        .forEach((swatch) => {
            const styleValue = swatch.getAttribute("data-custom-style");
            swatch.style.cssText = styleValue;
        });

    function initializeVariant() {
        if (hasVariants) {
            if (selectedColor) {
                const initialColor = document.querySelector(
                    `.color__item[data-color="${selectedColor}"]`
                );
                if (initialColor) initialColor.classList.add("active");
            }
            if (selectedSize) {
                const initialSize = document.querySelector(
                    `.size__item[data-volume="${selectedSize}"]`
                );
                if (initialSize) initialSize.classList.add("active");
            }
            updateVariantDisplay();
        }
    }

    function updateVariantDisplay() {
        if (!hasVariants) return;

        if (selectedColor && selectedSize) {
            const variantKey = selectedColor + "_" + selectedSize;
            const variant = allVariants[variantKey];

            if (variant) {
                variantPrice.textContent = variant.price;
                mainProductPrice.textContent = variant.price;
                variantStock.textContent =
                    variant.stock > 0
                        ? "In Stock (" + variant.stock + " products)"
                        : "Out of Stock";
                selectedVariantIdInput.value = variant.id;
            } else {
                variantPrice.textContent = formatPrice(defaultPrice);
                mainProductPrice.textContent = formatPrice(defaultPrice);
                variantStock.textContent = "Out of Stock";
                selectedVariantIdInput.value = "";
            }
        } else {
            variantPrice.textContent = formatPrice(defaultPrice);
            mainProductPrice.textContent = formatPrice(defaultPrice);
            variantStock.textContent = "-";
            selectedVariantIdInput.value = "";
        }
    }

    function formatPrice(price) {
        const numPrice = parseInt(price) || 0;
        return new Intl.NumberFormat("vi-VN", {
            style: "currency",
            currency: "VND",
        }).format(numPrice);
    }

    // Color selection
    colorItems.forEach((item) => {
        item.addEventListener("click", function () {
            colorItems.forEach((i) => i.classList.remove("active"));
            this.classList.add("active");
            selectedColor = this.dataset.color;

            const newImage = this.dataset.image;
            if (newImage) {
                mainImage.src = newImage;
            }
            updateVariantDisplay();
        });
    });

    // Size selection
    sizeItems.forEach((item) => {
        item.addEventListener("click", function () {
            sizeItems.forEach((i) => i.classList.remove("active"));
            this.classList.add("active");
            selectedSize = this.dataset.volume;
            updateVariantDisplay();
        });
    });

    // Favorite button functionality
    document.querySelectorAll(".favorite-btn").forEach((button) => {
        button.addEventListener("click", function (e) {
            e.preventDefault();
            const productId = this.getAttribute("data-product-id");
            const heartIcon = this.querySelector("i");
            const isRelatedProduct = this.closest(".product__item__pic__hover");

            $.ajax({
                url: "/favorite/toggle",
                type: "POST",
                data: {
                    product_id: productId,
                    _token: $('meta[name="csrf-token"]').attr("content"),
                },
                success: function (response) {
                    if (response.status === "added") {
                        heartIcon.style.color = "#ff0000";
                        if (!isRelatedProduct) {
                            showNotification("Added to favorites", "success");
                        }
                    } else {
                        heartIcon.style.color = isRelatedProduct
                            ? "#ffffff"
                            : "#333";
                        if (!isRelatedProduct) {
                            showNotification("Removed from favorites", "info");
                        }
                    }
                },
                error: function (xhr) {
                    if (xhr.status === 401) {
                        showNotification(
                            "Please login to add favorite products",
                            "warning"
                        );
                        setTimeout(() => {
                            window.location.href = "/login";
                        }, 1500);
                    } else {
                        showNotification(
                            "An error occurred, please try again",
                            "error"
                        );
                    }
                },
            });
        });
    });

    // Notification function
    function showNotification(message, type) {
        const notification = document.createElement("div");
        notification.className = `notification ${type}`;
        notification.innerHTML = `
                <span>${message}</span>
                <button onclick="this.parentElement.remove()">&times;</button>
            `;
        document.body.appendChild(notification);

        setTimeout(() => {
            notification.style.opacity = "0";
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    // Disable click on disabled download buttons
    document.querySelectorAll(".download-btn.disabled").forEach((btn) => {
        btn.addEventListener("click", function (e) {
            e.preventDefault();
            showNotification("No document available for this product", "info");
        });
    });

    initializeVariant();
});

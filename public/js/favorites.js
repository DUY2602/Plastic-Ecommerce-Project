// public/js/favorites.js - FIXED VERSION
$(document).ready(function () {
    $(".favorite-btn").click(function (e) {
        e.preventDefault();
        var productId = $(this).data("product-id");
        var button = $(this);

        $.ajax({
            url: "/favorite/toggle", // Fixed URL
            type: "POST",
            data: {
                product_id: productId,
                _token: $('meta[name="csrf-token"]').attr("content"), // Get token from meta tag
            },
            success: function (response) {
                if (response.status === "removed") {
                    // Remove product from DOM when successfully removed
                    button.closest(".col-lg-3").remove();

                    // If no products left, reload page to show "No Favorite Products Yet" message
                    if ($(".col-lg-3").length === 0) {
                        location.reload();
                    }
                }
                alert(response.message);
            },
            error: function (xhr, status, error) {
                var errorMessage = "Unknown error.";
                if (xhr.status === 401) {
                    errorMessage = "Please login to perform this action.";
                } else if (xhr.status === 419) {
                    errorMessage =
                        "Session expired (419 Page Expired). Please refresh the page.";
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = "Error: " + xhr.responseJSON.message;
                }

                console.error("AJAX Error Status:", xhr.status, error);
                alert("An error occurred: " + errorMessage);
            },
        });
    });
});

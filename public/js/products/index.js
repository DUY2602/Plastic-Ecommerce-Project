// public/js/index.js - FIXED VERSION
$(document).ready(function () {
    let currentCategory = "";
    let currentSearch = "";
    let currentSort = "default";

    // Get CSRF token and routes from global variables
    const csrfToken = $('meta[name="csrf-token"]').attr("content");
    const favoriteRoute =
        $("[data-favorite-route]").attr("data-favorite-route") ||
        "/favorite/toggle";
    const loginRoute =
        $("[data-login-route]").attr("data-login-route") || "/login";
    const productsRoute =
        $("[data-products-route]").attr("data-products-route") || "/products";

    // Function to update category UI
    function updateCategoryUI(categoryName) {
        $(".category-dropdown a").removeClass("active");

        if (categoryName) {
            $(`.category-dropdown a[data-category="${categoryName}"]`).addClass(
                "active"
            );
            $("#selected-category-name").text(categoryName);
            $("#category-selected").slideDown(300);
        } else {
            $(`.category-dropdown a[data-category=""]`).addClass("active");
            $("#category-selected").slideUp(300);
        }
    }

    updateCategoryUI("");

    // Category dropdown - hover effect
    $(".hero__categories").hover(
        function () {
            $(this).find(".category-dropdown").stop(true, true).slideDown(300);
            $(this).find(".hero__categories__all").addClass("active");
        },
        function () {
            $(this).find(".category-dropdown").stop(true, true).slideUp(300);
            $(this).find(".hero__categories__all").removeClass("active");
        }
    );

    // Handle category click
    $(document).on("click", ".category-dropdown a", function (e) {
        e.preventDefault();
        e.stopPropagation();

        currentCategory = $(this).data("category") || "";
        updateCategoryUI(currentCategory);
        $(".category-dropdown").slideUp(300);
        $(".hero__categories__all").removeClass("active");
        loadProducts();
    });

    // Handle clear category
    $(document).on("click", "#clear-category", function (e) {
        e.preventDefault();
        e.stopPropagation();

        currentCategory = "";
        updateCategoryUI("");
        loadProducts();
    });

    // Handle search
    $("#search-form").on("submit", function (e) {
        e.preventDefault();
        currentSearch = $('input[name="search"]').val();
        loadProducts();
    });

    // Handle sort
    $("#sort-select").on("change", function () {
        currentSort = $(this).val();
        loadProducts();
    });

    // Function to load products
    function loadProducts() {
        console.log("Loading products:", {
            search: currentSearch,
            sort: currentSort,
            category: currentCategory,
        });

        $("#product-list").addClass("loading");

        $.ajax({
            url: productsRoute,
            type: "GET",
            data: {
                search: currentSearch,
                sort_by: currentSort,
                category: currentCategory,
                ajax: true,
            },
            success: function (response) {
                $("#product-list .row").html(response.html);
                $("#product-count").text(response.count);
                $("#product-list").removeClass("loading");
                attachFavoriteEvents();
            },
            error: function (xhr) {
                console.log("AJAX error:", xhr.responseText);
                $("#product-list").removeClass("loading");
                alert("An error occurred while loading products");
            },
        });
    }

    // Handle favorite button
    function attachFavoriteEvents() {
        $(".favorite-btn")
            .off("click")
            .on("click", function (e) {
                e.preventDefault();
                var productId = $(this).data("product-id");
                var heartIcon = $(this).find(".heart-icon");
                var button = $(this);

                $.ajax({
                    url: favoriteRoute,
                    type: "POST",
                    data: {
                        product_id: productId,
                        _token: csrfToken,
                    },
                    success: function (response) {
                        if (response.status === "added") {
                            heartIcon.css("color", "#ff0000");
                            button.addClass("active");
                            alert("Added to favorites");
                        } else {
                            heartIcon.css("color", "#010101ff");
                            button.removeClass("active");
                            alert("Removed from favorites");
                        }
                    },
                    error: function (xhr) {
                        if (xhr.status === 401) {
                            alert("Please login to add favorite products");
                            window.location.href = loginRoute;
                        } else {
                            alert("An error occurred, please try again");
                        }
                    },
                });
            });
    }

    attachFavoriteEvents();
});

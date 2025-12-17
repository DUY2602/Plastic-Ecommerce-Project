document.addEventListener("DOMContentLoaded", function () {
    // Add loading effect when clicking buttons
    const buttons = document.querySelectorAll(".waves-effect");
    buttons.forEach((button) => {
        button.addEventListener("click", function (e) {
            this.classList.add("active");
            setTimeout(() => {
                this.classList.remove("active");
            }, 1000);
        });
    });

    // Hover effect for cards
    const cards = document.querySelectorAll(".card");
    cards.forEach((card) => {
        card.addEventListener("mouseenter", function () {
            this.style.transform = "translateY(-5px)";
        });

        card.addEventListener("mouseleave", function () {
            this.style.transform = "translateY(0)";
        });
    });

    // Auto-submit form when category changes
    const categorySelect = document.getElementById("categorySelect");
    const searchForm = document.getElementById("searchForm");

    categorySelect.addEventListener("change", function () {
        searchForm.submit();
    });

    // Auto-search after 1 second when typing
    const searchInput = document.getElementById("searchInput");
    let searchTimeout;

    searchInput.addEventListener("input", function () {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            searchForm.submit();
        }, 1000);
    });

    // Confirm product deletion
    const deleteForms = document.querySelectorAll(".delete-form");
    deleteForms.forEach((form) => {
        form.addEventListener("submit", function (e) {
            if (!confirm("Are you sure you want to delete this product?")) {
                e.preventDefault();
            }
        });
    });

    // Show success message for 5 seconds
    const successAlert = document.querySelector(".alert-success");
    if (successAlert) {
        setTimeout(() => {
            successAlert.remove();
        }, 5000);
    }
});

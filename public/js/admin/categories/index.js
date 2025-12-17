document.addEventListener("DOMContentLoaded", function () {
    // Theme management
    const themeButtons = document.querySelectorAll(".theme-btn");
    const savedTheme =
        localStorage.getItem("admin-categories-theme") || "default";

    // Apply saved theme
    document.body.classList.add(`theme-${savedTheme}`);
    document
        .querySelector(`.theme-btn[data-theme="${savedTheme}"]`)
        .classList.add("active");

    // Handle theme switching
    themeButtons.forEach((button) => {
        button.addEventListener("click", function () {
            const theme = this.getAttribute("data-theme");

            // Remove all theme classes
            document.body.classList.remove("theme-default", "theme-dark");

            // Add new theme class
            document.body.classList.add(`theme-${theme}`);

            // Update button states
            themeButtons.forEach((btn) => btn.classList.remove("active"));
            this.classList.add("active");

            // Save to localStorage
            localStorage.setItem("admin-categories-theme", theme);
        });
    });

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

    // Real-time search
    const searchInput = document.getElementById("searchInput");
    const searchForm = document.getElementById("searchForm");
    const searchLoading = document.querySelector(".search-loading");
    const categoriesTable = document.getElementById("categoriesTable");

    let searchTimeout;
    let currentSearchTerm = "";

    searchInput.addEventListener("input", function () {
        const searchTerm = this.value.trim();

        // Show loading
        searchLoading.classList.remove("d-none");

        // Cancel previous timeout
        clearTimeout(searchTimeout);

        // Only search if keyword changed
        if (searchTerm !== currentSearchTerm) {
            currentSearchTerm = searchTerm;

            // Set new timeout with shorter time (300ms)
            searchTimeout = setTimeout(() => {
                performSearch(searchTerm);
            }, 300);
        } else {
            searchLoading.classList.add("d-none");
        }
    });

    function performSearch(searchTerm) {
        // Use fetch to load search results
        fetch(
            `{{ route('admin.categories') }}?search=${encodeURIComponent(
                searchTerm
            )}&ajax=1`
        )
            .then((response) => response.text())
            .then((html) => {
                // Update table content
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, "text/html");
                const newTableContent = doc.getElementById("categoriesTable");

                if (newTableContent) {
                    categoriesTable.innerHTML = newTableContent.innerHTML;
                }

                // Hide loading
                searchLoading.classList.add("d-none");

                // Re-add event listeners to new elements
                addEventListenersToNewElements();
            })
            .catch((error) => {
                console.error("Search error:", error);
                searchLoading.classList.add("d-none");
            });
    }

    function addEventListenersToNewElements() {
        // Re-add event listeners for delete buttons
        const deleteForms = document.querySelectorAll(".delete-form");
        deleteForms.forEach((form) => {
            form.addEventListener("submit", function (e) {
                if (
                    !confirm("Are you sure you want to delete this category?")
                ) {
                    e.preventDefault();
                }
            });
        });

        // Re-add event listeners for other buttons
        const newButtons = document.querySelectorAll(".waves-effect");
        newButtons.forEach((button) => {
            button.addEventListener("click", function (e) {
                this.classList.add("active");
                setTimeout(() => {
                    this.classList.remove("active");
                }, 1000);
            });
        });
    }

    // Confirm category deletion
    const deleteForms = document.querySelectorAll(".delete-form");
    deleteForms.forEach((form) => {
        form.addEventListener("submit", function (e) {
            if (!confirm("Are you sure you want to delete this category?")) {
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

    const errorAlert = document.querySelector(".alert-danger");
    if (errorAlert) {
        setTimeout(() => {
            errorAlert.remove();
        }, 5000);
    }
});

document.addEventListener("DOMContentLoaded", function () {
    // Confirm post deletion
    const deleteForms = document.querySelectorAll('form[action*="destroy"]');
    deleteForms.forEach((form) => {
        form.addEventListener("submit", function (e) {
            if (!confirm("Are you sure you want to delete this post?")) {
                e.preventDefault();
            }
        });
    });
});

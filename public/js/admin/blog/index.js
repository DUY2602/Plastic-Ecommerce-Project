document.addEventListener("DOMContentLoaded", function () {
    const deleteForms = document.querySelectorAll(".delete-form");
    deleteForms.forEach((form) => {
        form.addEventListener("submit", function (e) {
            if (!confirm("Are you sure you want to delete this post?")) {
                e.preventDefault();
            }
        });
    });

    const buttons = document.querySelectorAll(".btn");
    buttons.forEach((button) => {
        button.addEventListener("mouseenter", function () {
            this.style.transform = "translateY(-1px)";
        });
        button.addEventListener("mouseleave", function () {
            this.style.transform = "translateY(0)";
        });
    });
});

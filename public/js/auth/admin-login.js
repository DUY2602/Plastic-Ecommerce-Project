document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("adminLoginForm");
    const loginBtn = document.getElementById("loginBtn");

    // Input effects
    const inputs = document.querySelectorAll(".form-control");
    inputs.forEach((input) => {
        if (input.value) {
            input.parentElement.classList.add("focused");
        }

        input.addEventListener("focus", function () {
            this.parentElement.classList.add("focused");
        });

        input.addEventListener("blur", function () {
            if (!this.value) {
                this.parentElement.classList.remove("focused");
            }
        });
    });

    // Form submit effect
    form.addEventListener("submit", function (e) {
        loginBtn.style.transform = "scale(0.98)";
        setTimeout(() => {
            loginBtn.style.transform = "";
        }, 150);
    });

    // Page load effect for card
    const card = document.querySelector(".admin-login-card");
    card.style.opacity = "0";
    card.style.transform = "translateY(50px) scale(0.9)";

    setTimeout(() => {
        card.style.transition =
            "all 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275)";
        card.style.opacity = "1";
        card.style.transform = "translateY(0) scale(1)";
    }, 100);
});

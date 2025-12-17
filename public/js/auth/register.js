document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");

    form.addEventListener("submit", function (e) {
        let isValid = true;
        const password = document.getElementById("password").value;
        const confirmPassword = document.getElementById(
            "password_confirmation"
        ).value;
        const terms = document.getElementById("terms").checked;

        // Clear previous errors
        document.querySelectorAll(".text-danger").forEach((el) => el.remove());

        if (password.length < 6) {
            isValid = false;
            const errorElement = document.createElement("span");
            errorElement.className = "text-danger";
            errorElement.textContent =
                "Password must be at least 6 characters long.";
            document
                .getElementById("password")
                .parentNode.appendChild(errorElement);
        }

        if (password !== confirmPassword) {
            isValid = false;
            const errorElement = document.createElement("span");
            errorElement.className = "text-danger";
            errorElement.textContent = "Passwords do not match.";
            document
                .getElementById("password_confirmation")
                .parentNode.appendChild(errorElement);
        }

        if (!terms) {
            isValid = false;
            const errorElement = document.createElement("span");
            errorElement.className = "text-danger";
            errorElement.textContent =
                "Please agree to the Terms and Conditions.";
            document
                .getElementById("terms")
                .parentNode.appendChild(errorElement);
        }

        if (!isValid) {
            e.preventDefault();
        }
    });
    // 🔥 CAPTCHA REFRESH CODE
    document
        .querySelector(".refresh-captcha")
        ?.addEventListener("click", function (e) {
            e.preventDefault();
            // Update Captcha image URL to generate new one
            const captchaImgBox = document.querySelector(".captcha-img-box");
            const newUrl = "/captcha/flat?" + Math.random();
            captchaImgBox.innerHTML =
                '<img src="' + newUrl + '" alt="captcha">';
            document.getElementById("captcha").value = ""; // Clear old Captcha input
        });
    // END CAPTCHA REFRESH CODE
});

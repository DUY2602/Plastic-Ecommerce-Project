// Run immediately when page loads, don't wait for DOMContentLoaded
(function () {
    setTimeout(function () {
        const inputs = document.querySelectorAll(".checkout__input input");
        inputs.forEach((input) => {
            input.style.cssText +=
                "font-weight: 600 !important; color: #000000 !important;";
        });
    }, 100);
})();

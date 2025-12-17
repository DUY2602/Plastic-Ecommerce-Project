document.addEventListener("DOMContentLoaded", function () {
    // Display file name when image is selected
    document.getElementById("Image").addEventListener("change", function (e) {
        var fileName = e.target.files[0]
            ? e.target.files[0].name
            : "Choose Image";
        var nextSibling = e.target.nextElementSibling;
        nextSibling.innerText = fileName;

        // Preview image
        if (e.target.files[0]) {
            var reader = new FileReader();
            reader.onload = function (event) {
                var preview = document.getElementById("imagePreview");
                if (!preview) {
                    preview = document.createElement("div");
                    preview.id = "imagePreview";
                    preview.className = "mt-2";
                    e.target.parentNode.parentNode.appendChild(preview);
                }
                preview.innerHTML = `
                    <p class="mb-1">Preview:</p>
                    <img src="${event.target.result}" 
                         class="img-thumbnail" 
                         style="max-height: 150px;">
                `;
            };
            reader.readAsDataURL(e.target.files[0]);
        }
    });
});

// public/js/tinymce-init.js
function initTinyMCE(selector = "#Content") {
    tinymce.init({
        selector: selector,
        height: 500,
        menubar: true,
        plugins: [
            "advlist",
            "autolink",
            "lists",
            "link",
            "image",
            "charmap",
            "preview",
            "anchor",
            "searchreplace",
            "visualblocks",
            "code",
            "fullscreen",
            "insertdatetime",
            "media",
            "table",
            "help",
            "wordcount",
        ],
        toolbar:
            "undo redo | blocks | " +
            "bold italic underline strikethrough | forecolor backcolor | " +
            "alignleft aligncenter alignright alignjustify | " +
            "bullist numlist outdent indent | " +
            "link image | removeformat | help",
        content_style:
            "body { font-family: Arial, sans-serif; font-size: 14px; }",
        language: "vi",

        // Upload ảnh
        images_upload_url: "/admin/blog/upload-image",
        automatic_uploads: true,
        images_upload_handler: function (blobInfo) {
            return new Promise((resolve, reject) => {
                const formData = new FormData();
                formData.append("file", blobInfo.blob(), blobInfo.filename());
                formData.append(
                    "_token",
                    document.querySelector('meta[name="csrf-token"]').content
                );

                fetch("/admin/blog/upload-image", {
                    method: "POST",
                    body: formData,
                })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.location) {
                            resolve(data.location);
                        } else {
                            reject(data.error || "Upload failed");
                        }
                    })
                    .catch((error) => reject(error));
            });
        },
    });
}

// Tự động khởi tạo khi trang load
document.addEventListener("DOMContentLoaded", function () {
    if (document.querySelector("#Content")) {
        initTinyMCE();
    }

    // Trigger save khi submit form
    document.addEventListener("submit", function (e) {
        if (window.tinymce && window.tinymce.get("Content")) {
            tinymce.triggerSave();
        }
    });
});

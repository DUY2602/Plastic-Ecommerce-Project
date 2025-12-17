function confirmDelete(feedbackId) {
    if (confirm("Are you sure you want to delete this review?")) {
        // Gửi request xóa (cần tạo route và method)
        fetch(`/admin/reviews/${feedbackId}`, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Content-Type": "application/json",
            },
        }).then((response) => {
            if (response.ok) {
                location.reload();
            }
        });
    }
}

@extends('layouts.admin')

@section('title', 'Quản lý danh mục')

@section('admin-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Quản lý danh mục</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Danh mục</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <!-- Theme Selector -->
        <div class="row mb-3">
            <div class="col-12">
                <div class="card theme-selector-card">
                    <div class="card-body py-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Chọn giao diện:</span>
                            <div class="theme-selector">
                                <button class="theme-btn active" data-theme="default" title="Sáng">
                                    <i class="fas fa-sun"></i>
                                </button>
                                <button class="theme-btn" data-theme="dark" title="Tối">
                                    <i class="fas fa-moon"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12">
                <div class="card animated fadeIn">
                    <div class="card-body">
                        <form id="searchForm" method="GET" action="{{ route('admin.categories') }}">
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-search"></i>
                                                </span>
                                            </div>
                                            <input type="text" name="search" class="form-control"
                                                placeholder="Tìm kiếm danh mục theo tên hoặc mô tả..."
                                                value="{{ request('search') }}"
                                                id="searchInput">
                                            <div class="input-group-append">
                                                <div class="input-group-text search-loading d-none">
                                                    <i class="fas fa-spinner fa-spin"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <a href="{{ route('admin.categories.create') }}" class="btn btn-success btn-block waves-effect">
                                        <i class="fas fa-plus mr-2"></i>Thêm mới
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-success card-outline animated fadeInUp">
                    <div class="card-header">
                        <h3 class="card-title">Danh sách danh mục</h3>
                        <div class="card-tools">
                            <div class="btn-group">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                    <i class="fas fa-expand"></i>
                                </button>
                                @if(request('search'))
                                <a href="{{ route('admin.categories') }}" class="btn btn-danger waves-effect" title="Xóa bộ lọc">
                                    <i class="fas fa-times mr-2"></i>Xóa lọc
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body" id="categoriesTable">
                        @if(request('search'))
                        <div class="alert alert-info alert-dismissible fade show mb-3" role="alert">
                            <strong>Kết quả tìm kiếm:</strong> Từ khóa: "<strong>{{ request('search') }}</strong>"
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif

                        @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                            <strong>Thành công!</strong> {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif

                        @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                            <strong>Lỗi!</strong> {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif

                        @if($categories->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead class="thead-dark">
                                    <tr>
                                        <th width="60">ID</th>
                                        <th>Tên danh mục</th>
                                        <th>Mô tả</th>
                                        <th width="120">Số sản phẩm</th>
                                        <th width="120">Trạng thái</th>
                                        <th width="150" class="text-center">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categories as $category)
                                    <tr class="animated fadeIn">
                                        <td><strong class="text-primary">#{{ $category->CategoryID }}</strong></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="category-icon mr-3">
                                                    <i class="fas fa-folder text-warning fa-lg"></i>
                                                </div>
                                                <div>
                                                    <strong>{{ $category->CategoryName }}</strong>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-muted">{{ Str::limit($category->Description, 80) }}</span>
                                        </td>
                                        <td>
                                            <div class="product-count">
                                                <span class="badge badge-primary badge-pill px-3 py-2">
                                                    <i class="fas fa-cube mr-1"></i>
                                                    {{ $category->products_count }} sản phẩm
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            @if($category->Status == 1)
                                            <span class="badge badge-success badge-pill">
                                                <i class="fas fa-eye mr-1"></i>Hiển thị
                                            </span>
                                            @else
                                            <span class="badge badge-danger badge-pill">
                                                <i class="fas fa-eye-slash mr-1"></i>Ẩn
                                            </span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm w-100">
                                                <a href="{{ route('admin.categories.show', $category->CategoryID) }}"
                                                    class="btn btn-info btn-flat waves-effect flex-fill"
                                                    title="Xem chi tiết">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.categories.edit', $category->CategoryID) }}"
                                                    class="btn btn-warning btn-flat waves-effect flex-fill"
                                                    title="Chỉnh sửa">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.categories.destroy', $category->CategoryID) }}"
                                                    method="POST" class="d-inline flex-fill delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-danger btn-flat waves-effect w-100"
                                                        title="Xóa"
                                                        onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="text-center py-5">
                            <div class="empty-state">
                                <i class="fas fa-folder-open fa-4x text-muted mb-3"></i>
                                <h4 class="text-muted">Không tìm thấy danh mục nào</h4>
                                <p class="text-muted mb-4">Không có danh mục nào phù hợp với tiêu chí tìm kiếm của bạn.</p>
                                @if(request('search'))
                                <a href="{{ route('admin.categories') }}" class="btn btn-primary waves-effect">
                                    <i class="fas fa-redo mr-2"></i>Xem tất cả danh mục
                                </a>
                                @else
                                <a href="{{ route('admin.categories.create') }}" class="btn btn-success waves-effect">
                                    <i class="fas fa-plus mr-2"></i>Thêm danh mục đầu tiên
                                </a>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="card-footer clearfix">
                        <div class="float-left">
                            <span class="text-muted">
                                Hiển thị <strong>{{ $categories->count() }}</strong> danh mục
                            </span>
                        </div>
                        <div class="float-right">
                            <span class="text-muted">Tổng cộng {{ $categories->count() }} danh mục</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    :root {
        --theme-bg: #ffffff;
        --theme-card-bg: #ffffff;
        --theme-text: #212529;
        --theme-border: #dee2e6;
        --theme-primary: #007bff;
        --theme-success: #28a745;
        --theme-warning: #ffc107;
        --theme-danger: #dc3545;
        --theme-info: #17a2b8;
    }

    .theme-dark {
        --theme-bg: #1a1a1a;
        --theme-card-bg: #2d3748;
        --theme-text: #e2e8f0;
        --theme-border: #4a5568;
        --theme-primary: #4299e1;
        --theme-success: #48bb78;
        --theme-warning: #ed8936;
        --theme-danger: #f56565;
        --theme-info: #0bc5ea;
    }

    body {
        background-color: var(--theme-bg);
        color: var(--theme-text);
        transition: all 0.3s ease;
    }

    .card {
        border: none;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        background-color: var(--theme-card-bg);
        color: var(--theme-text);
    }

    .card:hover {
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .theme-selector-card {
        background: linear-gradient(135deg, var(--theme-primary) 0%, var(--theme-info) 100%);
        color: white;
    }

    .theme-selector {
        display: flex;
        gap: 10px;
    }

    .theme-btn {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: 2px solid transparent;
        background: rgba(255, 255, 255, 0.2);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .theme-btn:hover {
        transform: scale(1.1);
        background: rgba(255, 255, 255, 0.3);
    }

    .theme-btn.active {
        border-color: white;
        background: rgba(255, 255, 255, 0.4);
    }

    .table-hover tbody tr {
        transition: all 0.3s ease;
        cursor: pointer;
        background-color: var(--theme-card-bg);
        color: var(--theme-text);
    }

    .table-hover tbody tr:hover {
        background-color: rgba(40, 167, 69, 0.05);
        transform: translateX(5px);
    }

    .category-icon {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 193, 7, 0.1);
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .table-hover tbody tr:hover .category-icon {
        background: rgba(255, 193, 7, 0.2);
        transform: scale(1.1);
    }

    .product-count .badge {
        font-size: 0.85em;
        transition: all 0.3s ease;
    }

    .table-hover tbody tr:hover .product-count .badge {
        transform: scale(1.05);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .btn-flat {
        border-radius: 4px;
        transition: all 0.3s ease;
        border: none;
    }

    .btn-flat:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .badge-pill {
        border-radius: 15px;
        padding: 6px 12px;
    }

    .animated {
        animation-duration: 0.6s;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    .waves-effect {
        position: relative;
        overflow: hidden;
    }

    .waves-effect:after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 5px;
        height: 5px;
        background: rgba(255, 255, 255, 0.5);
        opacity: 0;
        border-radius: 100%;
        transform: scale(1, 1) translate(-50%);
        transform-origin: 50% 50%;
    }

    .waves-effect:focus:after,
    .waves-effect:active:after {
        animation: ripple 1s ease-out;
    }

    @keyframes ripple {
        0% {
            transform: scale(0, 0);
            opacity: 0.5;
        }

        100% {
            transform: scale(20, 20);
            opacity: 0;
        }
    }

    .flex-fill {
        flex: 1 1 auto;
    }

    .thead-dark th {
        background: linear-gradient(135deg, #343a40 0%, #495057 100%);
        border-color: #454d55;
        color: white;
        font-weight: 600;
    }

    .card-footer {
        background: rgba(0, 0, 0, 0.02);
        border-top: 1px solid rgba(0, 0, 0, 0.1);
    }

    .empty-state {
        padding: 2rem 0;
    }

    .empty-state i {
        opacity: 0.5;
    }

    .input-group-text {
        background: #f8f9fa;
        border-color: #ced4da;
    }

    .alert {
        border: none;
        border-left: 4px solid #17a2b8;
        border-radius: 8px;
    }

    .btn-tool {
        border: 1px solid #dee2e6;
        margin-left: 2px;
    }

    .delete-form {
        display: flex;
    }

    .search-loading {
        transition: all 0.3s ease;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Quản lý theme
        const themeButtons = document.querySelectorAll('.theme-btn');
        const savedTheme = localStorage.getItem('admin-categories-theme') || 'default';

        // Áp dụng theme đã lưu
        document.body.classList.add(`theme-${savedTheme}`);
        document.querySelector(`.theme-btn[data-theme="${savedTheme}"]`).classList.add('active');

        // Xử lý chuyển đổi theme
        themeButtons.forEach(button => {
            button.addEventListener('click', function() {
                const theme = this.getAttribute('data-theme');

                // Xóa tất cả class theme
                document.body.classList.remove('theme-default', 'theme-dark');

                // Thêm class theme mới
                document.body.classList.add(`theme-${theme}`);

                // Cập nhật trạng thái nút
                themeButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');

                // Lưu vào localStorage
                localStorage.setItem('admin-categories-theme', theme);
            });
        });

        // Thêm hiệu ứng loading khi click các nút
        const buttons = document.querySelectorAll('.waves-effect');
        buttons.forEach(button => {
            button.addEventListener('click', function(e) {
                this.classList.add('active');
                setTimeout(() => {
                    this.classList.remove('active');
                }, 1000);
            });
        });

        // Hiệu ứng hover cho card
        const cards = document.querySelectorAll('.card');
        cards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Tìm kiếm thời gian thực
        const searchInput = document.getElementById('searchInput');
        const searchForm = document.getElementById('searchForm');
        const searchLoading = document.querySelector('.search-loading');
        const categoriesTable = document.getElementById('categoriesTable');

        let searchTimeout;
        let currentSearchTerm = '';

        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.trim();

            // Hiển thị loading
            searchLoading.classList.remove('d-none');

            // Hủy timeout trước đó
            clearTimeout(searchTimeout);

            // Chỉ tìm kiếm nếu từ khóa thay đổi
            if (searchTerm !== currentSearchTerm) {
                currentSearchTerm = searchTerm;

                // Đặt timeout mới với thời gian ngắn hơn (300ms)
                searchTimeout = setTimeout(() => {
                    performSearch(searchTerm);
                }, 300);
            } else {
                searchLoading.classList.add('d-none');
            }
        });

        function performSearch(searchTerm) {
            // Sử dụng fetch để tải kết quả tìm kiếm
            fetch(`{{ route('admin.categories') }}?search=${encodeURIComponent(searchTerm)}&ajax=1`)
                .then(response => response.text())
                .then(html => {
                    // Cập nhật nội dung bảng
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newTableContent = doc.getElementById('categoriesTable');

                    if (newTableContent) {
                        categoriesTable.innerHTML = newTableContent.innerHTML;
                    }

                    // Ẩn loading
                    searchLoading.classList.add('d-none');

                    // Thêm lại sự kiện cho các nút sau khi cập nhật nội dung
                    addEventListenersToNewElements();
                })
                .catch(error => {
                    console.error('Lỗi tìm kiếm:', error);
                    searchLoading.classList.add('d-none');
                });
        }

        function addEventListenersToNewElements() {
            // Thêm lại sự kiện cho các nút xóa
            const deleteForms = document.querySelectorAll('.delete-form');
            deleteForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    if (!confirm('Bạn có chắc chắn muốn xóa danh mục này?')) {
                        e.preventDefault();
                    }
                });
            });

            // Thêm lại sự kiện cho các nút khác
            const newButtons = document.querySelectorAll('.waves-effect');
            newButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    this.classList.add('active');
                    setTimeout(() => {
                        this.classList.remove('active');
                    }, 1000);
                });
            });
        }

        // Xác nhận xóa danh mục
        const deleteForms = document.querySelectorAll('.delete-form');
        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                if (!confirm('Bạn có chắc chắn muốn xóa danh mục này?')) {
                    e.preventDefault();
                }
            });
        });

        // Hiển thị thông báo thành công trong 5 giây
        const successAlert = document.querySelector('.alert-success');
        if (successAlert) {
            setTimeout(() => {
                successAlert.remove();
            }, 5000);
        }

        const errorAlert = document.querySelector('.alert-danger');
        if (errorAlert) {
            setTimeout(() => {
                errorAlert.remove();
            }, 5000);
        }
    });
</script>
@endsection
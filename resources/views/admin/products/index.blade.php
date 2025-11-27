@extends('layouts.admin')

@section('title', 'Quản lý sản phẩm')

@section('admin-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Quản lý sản phẩm</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Sản phẩm</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-12">
                <div class="card animated fadeIn">
                    <div class="card-body">
                        <form id="searchForm" method="GET" action="{{ route('admin.products') }}">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-search"></i>
                                                </span>
                                            </div>
                                            <input type="text" name="search" class="form-control"
                                                placeholder="Tìm kiếm sản phẩm theo tên..."
                                                value="{{ request('search') }}"
                                                id="searchInput">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <select name="category" class="form-control" id="categorySelect">
                                            <option value="">Tất cả danh mục</option>
                                            <option value="PET" {{ request('category') == 'PET' ? 'selected' : '' }}>PET</option>
                                            <option value="PP" {{ request('category') == 'PP' ? 'selected' : '' }}>PP</option>
                                            <option value="PC" {{ request('category') == 'PC' ? 'selected' : '' }}>PC</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline animated fadeInUp">
                    <div class="card-header">
                        <h3 class="card-title">Danh sách sản phẩm</h3>
                        <div class="card-tools">
                            <div class="btn-group">
                                <a href="{{ route('admin.products.create') }}" class="btn btn-success waves-effect">
                                    <i class="fas fa-plus mr-2"></i>Thêm sản phẩm mới
                                </a>
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                    <i class="fas fa-expand"></i>
                                </button>
                                @if(request('search') || request('category'))
                                <a href="{{ route('admin.products') }}" class="btn btn-danger waves-effect" title="Xóa bộ lọc">
                                    <i class="fas fa-times mr-2"></i>Xóa lọc
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(request('search') || request('category'))
                        <div class="alert alert-info alert-dismissible fade show mb-3" role="alert">
                            <strong>Kết quả tìm kiếm:</strong>
                            @if(request('search')) Từ khóa: "<strong>{{ request('search') }}</strong>" @endif
                            @if(request('category')) | Danh mục: <strong>{{ request('category') }}</strong> @endif
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

                        @if($products->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead class="thead-dark">
                                    <tr>
                                        <th width="50">ID</th>
                                        <th width="80">Hình ảnh</th>
                                        <th>Tên sản phẩm</th>
                                        <th width="120">Danh mục</th>
                                        <th width="100">Biến thể</th>
                                        <th width="120">Trạng thái</th>
                                        <th width="120">Ngày tạo</th>
                                        <th width="160" class="text-center">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                    <tr class="animated fadeIn">
                                        <td><strong class="text-primary">#{{ $product->ProductID }}</strong></td>
                                        <td>
                                            <div class="product-image-wrapper">
                                                @if($product->Photo && file_exists(public_path($product->Photo)))
                                                <img src="{{ asset($product->Photo) }}" alt="{{ $product->ProductName }}"
                                                    class="product-image img-thumbnail">
                                                @else
                                                <div class="no-image-placeholder">
                                                    <i class="fas fa-image text-muted"></i>
                                                </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="product-info">
                                                <h6 class="mb-0 font-weight-bold">{{ $product->ProductName }}</h6>
                                                <small class="text-muted">{{ Str::limit($product->Description, 60) }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            @if(isset($product->category))
                                            <span class="badge badge-info badge-pill px-3">{{ $product->category->CategoryName }}</span>
                                            @else
                                            <span class="badge badge-secondary badge-pill px-3">Chưa phân loại</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge badge-secondary badge-pill px-3">
                                                <i class="fas fa-layer-group mr-1"></i>
                                                {{ $product->variants_count ?? $product->variants->count() ?? 0 }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($product->Status == 1)
                                            <span class="badge badge-success badge-pill">
                                                <i class="fas fa-check mr-1"></i>Đang bán
                                            </span>
                                            @else
                                            <span class="badge badge-danger badge-pill">
                                                <i class="fas fa-times mr-1"></i>Ngừng bán
                                            </span>
                                            @endif
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                <i class="far fa-calendar mr-1"></i>
                                                {{ date('d/m/Y', strtotime($product->CreatedAt)) }}
                                            </small>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm w-100">
                                                <a href="{{ route('admin.products.show', $product->ProductID) }}"
                                                    class="btn btn-info btn-flat waves-effect flex-fill"
                                                    title="Xem chi tiết">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.products.edit', $product->ProductID) }}"
                                                    class="btn btn-warning btn-flat waves-effect flex-fill"
                                                    title="Chỉnh sửa">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.products.destroy', $product->ProductID) }}"
                                                    method="POST" class="d-inline flex-fill delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-danger btn-flat waves-effect w-100"
                                                        title="Xóa"
                                                        onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">
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
                                <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                                <h4 class="text-muted">Không tìm thấy sản phẩm nào</h4>
                                <p class="text-muted mb-4">Không có sản phẩm nào phù hợp với tiêu chí tìm kiếm của bạn.</p>
                                @if(request('search') || request('category'))
                                <a href="{{ route('admin.products') }}" class="btn btn-primary waves-effect">
                                    <i class="fas fa-redo mr-2"></i>Xem tất cả sản phẩm
                                </a>
                                @else
                                <a href="{{ route('admin.products.create') }}" class="btn btn-success waves-effect">
                                    <i class="fas fa-plus mr-2"></i>Thêm sản phẩm đầu tiên
                                </a>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="card-footer clearfix">
                        <div class="float-left">
                            <span class="text-muted">
                                Hiển thị <strong>{{ $products->count() }}</strong> sản phẩm
                            </span>
                        </div>
                        <div class="float-right">
                            <span class="text-muted">Tổng cộng {{ $products->count() }} sản phẩm</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .card {
        border: none;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .table-hover tbody tr {
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
        transform: translateX(5px);
    }

    .product-image-wrapper {
        width: 60px;
        height: 60px;
        border-radius: 8px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
        border: 2px solid #e9ecef;
        transition: all 0.3s ease;
    }

    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: all 0.3s ease;
    }

    .no-image-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #e9ecef;
        font-size: 1.5em;
    }

    .table-hover tbody tr:hover .product-image-wrapper {
        border-color: #007bff;
        transform: scale(1.1);
    }

    .table-hover tbody tr:hover .product-image {
        transform: scale(1.1);
    }

    .product-info h6 {
        color: #343a40;
        transition: all 0.3s ease;
    }

    .table-hover tbody tr:hover .product-info h6 {
        color: #007bff;
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
        font-size: 0.85em;
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
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
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

        // Tự động submit form khi thay đổi danh mục
        const categorySelect = document.getElementById('categorySelect');
        const searchForm = document.getElementById('searchForm');

        categorySelect.addEventListener('change', function() {
            searchForm.submit();
        });

        // Tìm kiếm tự động sau 1 giây khi nhập
        const searchInput = document.getElementById('searchInput');
        let searchTimeout;

        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                searchForm.submit();
            }, 1000);
        });

        // Xác nhận xóa sản phẩm
        const deleteForms = document.querySelectorAll('.delete-form');
        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                if (!confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')) {
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
    });
</script>
@endsection
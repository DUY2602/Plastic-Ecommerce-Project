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

<script>
// Thêm lại sự kiện cho các phần tử mới được tải qua AJAX
document.addEventListener('DOMContentLoaded', function() {
    // Thêm sự kiện cho các nút xóa
    const deleteForms = document.querySelectorAll('.delete-form');
    deleteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!confirm('Bạn có chắc chắn muốn xóa danh mục này?')) {
                e.preventDefault();
            }
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
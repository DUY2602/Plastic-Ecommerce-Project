@extends('layouts.admin')

@section('title', 'Chỉnh sửa bài viết')

@section('admin-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Chỉnh sửa bài viết</h1>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card card-primary">
                    <form action="{{ route('admin.blog.update', $blog->BlogID) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="Image">Hình ảnh bài viết</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('Image') is-invalid @enderror"
                                    id="Image" name="Image" accept="image/*">
                                <label class="custom-file-label" for="Image">
                                    {{ isset($blog) && $blog->Image ? 'Thay đổi hình ảnh' : 'Chọn hình ảnh' }}
                                </label>
                            </div>
                            @error('Image')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Định dạng: JPEG, PNG, JPG, GIF. Tối đa 2MB.</small>

                            {{-- Preview ảnh hiện tại (chỉ trong edit) --}}
                            @if(isset($blog) && $blog->Image)
                            <div class="mt-2">
                                <p class="mb-1">Hình ảnh hiện tại:</p>
                                <img src="{{ asset($blog->Image) }}" alt="{{ $blog->Title }}"
                                    class="img-thumbnail" style="max-height: 150px;">
                            </div>
                            @endif
                        </div>

                        {{-- Các trường khác --}}
                        <div class="form-group">
                            <label for="Title">Tiêu đề *</label>
                            <input type="text" class="form-control @error('Title') is-invalid @enderror"
                                id="Title" name="Title"
                                value="{{ old('Title', isset($blog) ? $blog->Title : '') }}"
                                placeholder="Nhập tiêu đề bài viết" required>
                            @error('Title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="Content">Nội dung *</label>
                            <textarea class="form-control @error('Content') is-invalid @enderror"
                                id="Content" name="Content" rows="6"
                                placeholder="Nhập nội dung bài viết" required>{{ old('Content', isset($blog) ? $blog->Content : '') }}</textarea>
                            @error('Content')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="Author">Tác giả *</label>
                            <input type="text" class="form-control @error('Author') is-invalid @enderror"
                                id="Author" name="Author"
                                value="{{ old('Author', isset($blog) ? $blog->Author : '') }}"
                                placeholder="Nhập tên tác giả" required>
                            @error('Author')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-2"></i>{{ isset($blog) ? 'Cập nhật' : 'Thêm' }} bài viết
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Hiển thị tên file khi chọn ảnh
        document.getElementById('Image').addEventListener('change', function(e) {
            var fileName = e.target.files[0] ? e.target.files[0].name : 'Chọn hình ảnh';
            var nextSibling = e.target.nextElementSibling;
            nextSibling.innerText = fileName;

            // Preview ảnh
            if (e.target.files[0]) {
                var reader = new FileReader();
                reader.onload = function(event) {
                    var preview = document.getElementById('imagePreview');
                    if (!preview) {
                        preview = document.createElement('div');
                        preview.id = 'imagePreview';
                        preview.className = 'mt-2';
                        e.target.parentNode.parentNode.appendChild(preview);
                    }
                    preview.innerHTML = `
                    <p class="mb-1">Preview:</p>
                    <img src="${event.target.result}" 
                         class="img-thumbnail" 
                         style="max-height: 150px;">
                `;
                }
                reader.readAsDataURL(e.target.files[0]);
            }
        });
    });
</script>
@endsection
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
                    <form action="{{ route('admin.blog.update', $blog->BlogID) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <label for="Title">Tiêu đề</label>
                                <input type="text" class="form-control" id="Title" name="Title" value="{{ old('Title', $blog->Title) }}" required>
                            </div>

                            <div class="form-group">
                                <label for="Content">Nội dung</label>
                                <textarea class="form-control" id="Content" name="Content" rows="10" required>{{ old('Content', $blog->Content) }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="Image">URL hình ảnh</label>
                                <input type="text" class="form-control" id="Image" name="Image" value="{{ old('Image', $blog->Image) }}" placeholder="/images/blog/example.jpg">
                            </div>

                            <div class="form-group">
                                <label for="Author">Tác giả</label>
                                <input type="text" class="form-control" id="Author" name="Author" value="{{ old('Author', $blog->Author) }}" required>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                            <a href="{{ route('admin.blog.index') }}" class="btn btn-default">Hủy</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
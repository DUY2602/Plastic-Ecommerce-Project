@extends('layouts.admin')

@section('title', 'Add New Post')

@section('admin-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Add New Post</h1>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card card-primary">
                    <form action="{{ route('admin.blog.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="Image">Post Image</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('Image') is-invalid @enderror"
                                    id="Image" name="Image" accept="image/*">
                                <label class="custom-file-label" for="Image">
                                    {{ isset($blog) && $blog->Image ? 'Change Image' : 'Choose Image' }}
                                </label>
                            </div>
                            @error('Image')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Formats: JPEG, PNG, JPG, GIF. Max 2MB.</small>

                            {{-- Current image preview (only in edit) --}}
                            @if(isset($blog) && $blog->Image)
                            <div class="mt-2">
                                <p class="mb-1">Current Image:</p>
                                <img src="{{ asset($blog->Image) }}" alt="{{ $blog->Title }}"
                                    class="img-thumbnail" style="max-height: 150px;">
                            </div>
                            @endif
                        </div>

                        {{-- Other fields --}}
                        <div class="form-group">
                            <label for="Title">Title *</label>
                            <input type="text" class="form-control @error('Title') is-invalid @enderror"
                                id="Title" name="Title"
                                value="{{ old('Title', isset($blog) ? $blog->Title : '') }}"
                                placeholder="Enter post title" required>
                            @error('Title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="Content">Content *</label>
                            <textarea class="form-control @error('Content') is-invalid @enderror"
                                id="Content" name="Content" rows="6"
                                placeholder="Enter post content" required>{{ old('Content', isset($blog) ? $blog->Content : '') }}</textarea>
                            @error('Content')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="Author">Author *</label>
                            <input type="text" class="form-control @error('Author') is-invalid @enderror"
                                id="Author" name="Author"
                                value="{{ old('Author', isset($blog) ? $blog->Author : '') }}"
                                placeholder="Enter author name" required>
                            @error('Author')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-2"></i>{{ isset($blog) ? 'Update' : 'Add' }} Post
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
        // Display file name when image is selected
        document.getElementById('Image').addEventListener('change', function(e) {
            var fileName = e.target.files[0] ? e.target.files[0].name : 'Choose Image';
            var nextSibling = e.target.nextElementSibling;
            nextSibling.innerText = fileName;

            // Preview image
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

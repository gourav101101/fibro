@extends('backend.layouts.admin')
@section('title', 'Edit Material')
@section('header', 'Edit Material')

@section('content')
<a href="{{ route('admin.materials.index') }}" class="admin-back">← Back to materials</a>

<div class="admin-detail">
    <div class="admin-detail-header">
        <h3>Edit: {{ $material->name }}</h3>
    </div>
    <div class="admin-detail-body">
        <form method="POST" enctype="multipart/form-data" action="{{ route('admin.materials.update', $material) }}">
            @csrf @method('PUT')
            
            @if($errors->any())
                <div class="admin-alert admin-alert-error">
                    <ul style="margin:0;padding-left:20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="admin-form-grid">
                <div>
                    @if($material->image)
                        <img src="{{ \App\Support\PublicImage::url($material->image) }}" alt="{{ $material->alt ?: $material->name }}" style="display:block;width:100%;max-width:360px;aspect-ratio:16/10;object-fit:cover;border-radius:8px;margin-bottom:20px;">
                    @endif
                    <div class="admin-form-group">
                        <label for="name">Name *</label>
                        <input type="text" id="name" name="name" class="admin-input" value="{{ old('name', $material->name) }}" required>
                    </div>
                    <div class="admin-form-group">
                        <label for="category">Category</label>
                        <input type="text" id="category" name="category" class="admin-input" value="{{ old('category', $material->category) }}">
                    </div>
                    <div class="admin-form-group">
                        <label for="use">Use</label>
                        <input type="text" id="use" name="use" class="admin-input" value="{{ old('use', $material->use) }}">
                    </div>
                    <div class="admin-form-group">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" class="admin-textarea" style="min-height:80px">{{ old('description', $material->description) }}</textarea>
                    </div>
                    <div class="admin-form-group">
                        <label for="details">Details</label>
                        <textarea id="details" name="details" class="admin-textarea">{{ old('details', $material->details) }}</textarea>
                    </div>
                </div>
                
                <div>
                    <div class="admin-form-group">
                        <label for="image_file">Material image</label>
                        <input type="hidden" name="image" value="{{ old('image', $material->image) }}">
                        <input type="file" id="image_file" name="image_file" class="admin-input" accept="image/jpeg,image/png,image/webp">
                        <small>JPG, PNG or WebP, maximum 8 MB. Leave empty to keep the current image.</small>
                    </div>
                    <div class="admin-form-group">
                        <label for="alt">Image Alt Text</label>
                        <input type="text" id="alt" name="alt" class="admin-input" value="{{ old('alt', $material->alt) }}">
                    </div>
                    
                    <h4 style="margin-top:24px;margin-bottom:12px;font-size:14px;">Attributes</h4>
                    @php
                        $attrs = old('attributes', $material->attributes ?? []);
                    @endphp
                    @for($i = 0; $i < 3; $i++)
                        <div class="admin-form-group">
                            <input type="text" name="attributes[]" class="admin-input" value="{{ $attrs[$i] ?? '' }}" placeholder="Attribute {{ $i+1 }}">
                        </div>
                    @endfor
                </div>
            </div>
            
            <div class="admin-detail-actions">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="{{ route('admin.materials.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

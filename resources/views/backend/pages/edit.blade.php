@extends('backend.layouts.admin')
@section('title', 'Edit Page SEO')
@section('header', 'Edit Page SEO')

@section('content')
<a href="{{ route('admin.pages.index') }}" class="admin-back">← Back to pages</a>

<div class="admin-detail">
    <div class="admin-detail-header">
        <h3>Edit: {{ $page->page_key }}</h3>
    </div>
    <div class="admin-detail-body">
        <form method="POST" action="{{ route('admin.pages.update', $page) }}">
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

            <div class="admin-form-group">
                <label for="title">Page Title (used for &lt;title&gt;) *</label>
                <input type="text" id="title" name="title" class="admin-input" value="{{ old('title', $page->title) }}" required>
            </div>
            
            <div class="admin-form-group">
                <label for="description">Page Description (used for meta description)</label>
                <textarea id="description" name="description" class="admin-textarea" style="min-height:80px">{{ old('description', $page->description) }}</textarea>
            </div>

            <div class="admin-form-group">
                <label for="meta_title">Meta Title Override (optional)</label>
                <input type="text" id="meta_title" name="meta_title" class="admin-input" value="{{ old('meta_title', $page->meta_title) }}">
            </div>
            
            <div class="admin-form-group">
                <label for="meta_description">Meta Description Override (optional)</label>
                <textarea id="meta_description" name="meta_description" class="admin-textarea" style="min-height:80px">{{ old('meta_description', $page->meta_description) }}</textarea>
            </div>

            <div class="admin-form-group">
                <label for="og_image">OG Image URL (optional)</label>
                <input type="text" id="og_image" name="og_image" class="admin-input" value="{{ old('og_image', $page->og_image) }}">
            </div>

            <div class="admin-form-group" style="display:flex;align-items:center;gap:8px;">
                <input type="checkbox" id="is_active" name="is_active" value="1" style="accent-color:var(--admin-accent)" {{ old('is_active', $page->is_active) ? 'checked' : '' }}>
                <label for="is_active" style="margin:0;cursor:pointer">Published and included in search engines</label>
            </div>
            
            <div class="admin-detail-actions">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

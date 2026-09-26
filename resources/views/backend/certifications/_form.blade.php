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
    <label for="name">Name *</label>
    <input type="text" id="name" name="name" class="admin-input" value="{{ old('name', $certification->name) }}" required>
</div>
<div class="admin-form-group">
    <label for="category">Category</label>
    <input type="text" id="category" name="category" class="admin-input" value="{{ old('category', $certification->category) }}">
</div>
<div class="admin-form-group">
    <label for="image_file">Certification image</label>
    @if($certification->image)
        <img src="{{ \App\Support\PublicImage::url($certification->image, 'credentials') }}" alt="{{ $certification->name ?: 'Certification preview' }}" style="display:block;width:180px;height:100px;padding:10px;object-fit:contain;background:#fff;border-radius:8px;margin-bottom:12px;">
    @endif
    <input type="hidden" name="image" value="{{ old('image', $certification->image) }}">
    <input type="file" id="image_file" name="image_file" class="admin-input" accept="image/jpeg,image/png,image/webp">
    <small>JPG, PNG or WebP, maximum 8 MB. Leave empty to keep the current image.</small>
</div>

<div class="admin-form-group" style="display:flex;align-items:center;gap:8px;margin-top:24px;">
    <input type="checkbox" id="is_active" name="is_active" value="1" style="accent-color:var(--admin-accent)" 
           {{ old('is_active', $certification->is_active ?? true) ? 'checked' : '' }}>
    <label for="is_active" style="margin:0;cursor:pointer">Active (Visible on website)</label>
</div>

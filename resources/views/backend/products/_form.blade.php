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
        <div class="admin-form-group">
            <label for="name">Name *</label>
            <input type="text" id="name" name="name" class="admin-input" value="{{ old('name', $product->name) }}" required>
        </div>
        <div class="admin-form-group">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" class="admin-input" value="{{ old('title', $product->title) }}">
        </div>
        <div class="admin-form-group">
            <label for="text">Description</label>
            <textarea id="text" name="text" class="admin-textarea">{{ old('text', $product->text) }}</textarea>
        </div>
        <div class="admin-form-group">
            <label for="material">Material string</label>
            <input type="text" id="material" name="material" class="admin-input" value="{{ old('material', $product->material) }}">
        </div>
        <div class="admin-form-group">
            <label for="construction">Construction Type</label>
            <select id="construction" name="construction" class="admin-select">
                <option value="">Select type...</option>
                <option value="fabric" {{ old('construction', $product->construction) === 'fabric' ? 'selected' : '' }}>Fabric to fabric</option>
                <option value="foam" {{ old('construction', $product->construction) === 'foam' ? 'selected' : '' }}>Fabric to foam</option>
                <option value="membrane" {{ old('construction', $product->construction) === 'membrane' ? 'selected' : '' }}>Fabric to membrane</option>
            </select>
        </div>
    </div>
    
    <div>
        <div class="admin-form-group">
            <label for="image_file">Product image</label>
            @if($product->image)
                <img src="{{ \App\Support\PublicImage::url($product->image) }}" alt="{{ $product->alt ?: $product->name }}" style="display:block;width:100%;max-width:360px;aspect-ratio:16/10;object-fit:cover;border-radius:8px;margin-bottom:12px;">
            @endif
            <input type="hidden" name="image" value="{{ old('image', $product->image) }}">
            <input type="file" id="image_file" name="image_file" class="admin-input" accept="image/jpeg,image/png,image/webp">
            <small>JPG, PNG or WebP, maximum 8 MB. Leave empty to keep the current image.</small>
        </div>
        <div class="admin-form-group">
            <label for="alt">Image Alt Text</label>
            <input type="text" id="alt" name="alt" class="admin-input" value="{{ old('alt', $product->alt) }}">
        </div>
        
        <h4 style="margin-top:24px;margin-bottom:12px;font-size:14px;">Considerations (Questions)</h4>
        @php
            $cons = old('considerations', $product->considerations ?? []);
        @endphp
        @for($i = 0; $i < 3; $i++)
            <div class="admin-form-group">
                <input type="text" name="considerations[]" class="admin-input" value="{{ $cons[$i] ?? '' }}" placeholder="Question {{ $i+1 }}">
            </div>
        @endfor

        <div class="admin-form-group" style="display:flex;align-items:center;gap:8px;margin-top:24px;">
            <input type="checkbox" id="is_active" name="is_active" value="1" style="accent-color:var(--admin-accent)" 
                   {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}>
            <label for="is_active" style="margin:0;cursor:pointer">Active (Visible on website)</label>
        </div>
    </div>
</div>

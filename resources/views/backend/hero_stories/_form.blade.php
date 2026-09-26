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
            <label for="label">Tab Label (e.g. Materials with purpose) *</label>
            <input type="text" id="label" name="label" class="admin-input" value="{{ old('label', $story->label) }}" required>
        </div>
        <div class="admin-form-group">
            <label for="eyebrow">Eyebrow text</label>
            <input type="text" id="eyebrow" name="eyebrow" class="admin-input" value="{{ old('eyebrow', $story->eyebrow) }}">
        </div>
        <div class="admin-form-group">
            <label for="title_line1">Title Line 1</label>
            <input type="text" id="title_line1" name="title_line1" class="admin-input" value="{{ old('title_line1', $story->title_line1) }}">
        </div>
        <div class="admin-form-group">
            <label for="title_line2">Title Line 2</label>
            <input type="text" id="title_line2" name="title_line2" class="admin-input" value="{{ old('title_line2', $story->title_line2) }}">
        </div>
        <div class="admin-form-group">
            <label for="accent">Accent Text (Italicised)</label>
            <input type="text" id="accent" name="accent" class="admin-input" value="{{ old('accent', $story->accent) }}">
        </div>
        <div class="admin-form-group">
            <label for="description">Description paragraph</label>
            <textarea id="description" name="description" class="admin-textarea" style="min-height:80px">{{ old('description', $story->description) }}</textarea>
        </div>
    </div>
    
    <div>
        <div class="admin-form-group">
            <label for="image_file">Hero image</label>
            @if($story->image)
                <img src="{{ \App\Support\PublicImage::url($story->image) }}" alt="{{ $story->alt ?: $story->label }}" style="display:block;width:100%;max-width:360px;aspect-ratio:16/10;object-fit:cover;border-radius:8px;margin-bottom:12px;">
            @endif
            <input type="hidden" name="image" value="{{ old('image', $story->image) }}">
            <input type="file" id="image_file" name="image_file" class="admin-input" accept="image/jpeg,image/png,image/webp">
            <small>JPG, PNG or WebP, maximum 8 MB. Leave empty to keep the current image.</small>
        </div>
        <div class="admin-form-group">
            <label for="alt">Image Alt Text</label>
            <input type="text" id="alt" name="alt" class="admin-input" value="{{ old('alt', $story->alt) }}">
        </div>
        
        <h4 style="margin-top:24px;margin-bottom:12px;font-size:14px;">Call to Action</h4>
        <div class="admin-form-group">
            <label for="action_text">Button Text</label>
            <input type="text" id="action_text" name="action_text" class="admin-input" value="{{ old('action_text', $story->action_text) }}">
        </div>
        <div class="admin-form-group">
            <label for="action_href">Button URL/Anchor (e.g. #applications)</label>
            <input type="text" id="action_href" name="action_href" class="admin-input" value="{{ old('action_href', $story->action_href) }}">
        </div>

        <div class="admin-form-group" style="display:flex;align-items:center;gap:8px;margin-top:24px;">
            <input type="checkbox" id="is_dark" name="is_dark" value="1" style="accent-color:var(--admin-accent)" 
                   {{ old('is_dark', $story->is_dark ?? true) ? 'checked' : '' }}>
            <label for="is_dark" style="margin:0;cursor:pointer">Dark theme (white text over image)</label>
        </div>

        <div class="admin-form-group" style="display:flex;align-items:center;gap:8px;margin-top:12px;">
            <input type="checkbox" id="is_active" name="is_active" value="1" style="accent-color:var(--admin-accent)" 
                   {{ old('is_active', $story->is_active ?? true) ? 'checked' : '' }}>
            <label for="is_active" style="margin:0;cursor:pointer">Active (Visible on website)</label>
        </div>
    </div>
</div>

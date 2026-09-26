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
            <input type="text" id="name" name="name" class="admin-input" value="{{ old('name', $service->name) }}" required>
        </div>
        <div class="admin-form-group">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" class="admin-input" value="{{ old('title', $service->title) }}">
        </div>
        <div class="admin-form-group">
            <label for="text">Description</label>
            <textarea id="text" name="text" class="admin-textarea">{{ old('text', $service->text) }}</textarea>
        </div>
    </div>
    
    <div>
        <div class="admin-form-group">
            <label for="image_file">Service image</label>
            @if($service->image)
                <img src="{{ \App\Support\PublicImage::url($service->image) }}" alt="{{ $service->name }}" style="display:block;width:100%;max-width:360px;aspect-ratio:16/10;object-fit:cover;border-radius:8px;margin-bottom:12px;">
            @endif
            <input type="hidden" name="image" value="{{ old('image', $service->image) }}">
            <input type="file" id="image_file" name="image_file" class="admin-input" accept="image/jpeg,image/png,image/webp">
            <small>JPG, PNG or WebP, maximum 8 MB. Leave empty to keep the current image.</small>
        </div>
        
        <h4 style="margin-top:24px;margin-bottom:12px;font-size:14px;">Points</h4>
        @php
            $pts = old('points', $service->points ?? []);
        @endphp
        @for($i = 0; $i < 3; $i++)
            <div class="admin-form-group">
                <input type="text" name="points[]" class="admin-input" value="{{ $pts[$i] ?? '' }}" placeholder="Point {{ $i+1 }}">
            </div>
        @endfor

        <div class="admin-form-group" style="display:flex;align-items:center;gap:8px;margin-top:24px;">
            <input type="checkbox" id="is_active" name="is_active" value="1" style="accent-color:var(--admin-accent)" 
                   {{ old('is_active', $service->is_active ?? true) ? 'checked' : '' }}>
            <label for="is_active" style="margin:0;cursor:pointer">Active (Visible on website)</label>
        </div>
    </div>
</div>

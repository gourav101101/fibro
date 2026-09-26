@extends('backend.layouts.admin')
@section('title', 'Hero Stories')
@section('header', 'Hero Stories')

@section('content')
<div class="admin-table-wrap">
    <div class="admin-table-header">
        <h3>Hero Carousel Stories</h3>
        <a href="{{ route('admin.hero-stories.create') }}" class="btn btn-primary btn-sm">+ New Story</a>
    </div>

    @if($stories->isEmpty())
        <div class="admin-empty">
            <div class="admin-empty-icon">🖼️</div>
            <h3>No stories found</h3>
        </div>
    @else
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Image</th>
                    <th>Label</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($stories as $story)
                    <tr>
                        <td style="width: 60px;">{{ $story->sort_order }}</td>
                        <td style="width: 120px;">
                            @if($story->image)
                                <img src="{{ \App\Support\PublicImage::url($story->image) }}" alt="{{ $story->alt ?: $story->label }}" style="width:100px;height:56px;object-fit:cover;border-radius:4px;">
                            @else
                                <div style="width:100px;height:56px;background:var(--admin-border);border-radius:4px;"></div>
                            @endif
                        </td>
                        <td>{{ $story->label }}<br><small style="color:var(--admin-text-muted)">{{ $story->eyebrow }}</small></td>
                        <td>
                            <span class="badge {{ $story->is_active ? 'badge-sample' : 'badge-read' }}">
                                {{ $story->is_active ? 'Active' : 'Draft' }}
                            </span>
                        </td>
                        <td style="text-align:right;">
                            <div style="display:flex;gap:8px;justify-content:flex-end;">
                                <a href="{{ route('admin.hero-stories.edit', $story) }}" class="btn btn-ghost btn-sm">Edit</a>
                                <form method="POST" action="{{ route('admin.hero-stories.destroy', $story) }}" onsubmit="return confirm('Delete this story?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-ghost btn-sm" style="color:var(--admin-danger)">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection

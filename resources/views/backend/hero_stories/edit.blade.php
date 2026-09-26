@extends('backend.layouts.admin')
@section('title', 'Edit Hero Story')
@section('header', 'Edit Hero Story')

@section('content')
<a href="{{ route('admin.hero-stories.index') }}" class="admin-back">← Back to hero stories</a>

<div class="admin-detail">
    <div class="admin-detail-header">
        <h3>Edit: {{ $hero_story->label }}</h3>
    </div>
    <div class="admin-detail-body">
        <form method="POST" enctype="multipart/form-data" action="{{ route('admin.hero-stories.update', $hero_story) }}">
            @csrf @method('PUT')
            @include('backend.hero_stories._form', ['story' => $hero_story])
            
            <div class="admin-detail-actions">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="{{ route('admin.hero-stories.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

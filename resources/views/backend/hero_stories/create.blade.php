@extends('backend.layouts.admin')
@section('title', 'Create Hero Story')
@section('header', 'New Hero Story')

@section('content')
<a href="{{ route('admin.hero-stories.index') }}" class="admin-back">← Back to hero stories</a>

<div class="admin-detail">
    <div class="admin-detail-header">
        <h3>Create Story</h3>
    </div>
    <div class="admin-detail-body">
        <form method="POST" enctype="multipart/form-data" action="{{ route('admin.hero-stories.store') }}">
            @csrf
            @include('backend.hero_stories._form', ['story' => new \App\Models\HeroStory()])
            
            <div class="admin-detail-actions">
                <button type="submit" class="btn btn-primary">Create Story</button>
                <a href="{{ route('admin.hero-stories.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

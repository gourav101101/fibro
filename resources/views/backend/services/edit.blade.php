@extends('backend.layouts.admin')
@section('title', 'Edit Service')
@section('header', 'Edit Service')

@section('content')
<a href="{{ route('admin.services.index') }}" class="admin-back">← Back to services</a>

<div class="admin-detail">
    <div class="admin-detail-header">
        <h3>Edit: {{ $service->name }}</h3>
    </div>
    <div class="admin-detail-body">
        <form method="POST" enctype="multipart/form-data" action="{{ route('admin.services.update', $service) }}">
            @csrf @method('PUT')
            @include('backend.services._form', ['service' => $service])
            
            <div class="admin-detail-actions">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

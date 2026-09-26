@extends('backend.layouts.admin')
@section('title', 'Create Service')
@section('header', 'New Service')

@section('content')
<a href="{{ route('admin.services.index') }}" class="admin-back">← Back to services</a>

<div class="admin-detail">
    <div class="admin-detail-header">
        <h3>Create Service</h3>
    </div>
    <div class="admin-detail-body">
        <form method="POST" enctype="multipart/form-data" action="{{ route('admin.services.store') }}">
            @csrf
            @include('backend.services._form', ['service' => new \App\Models\Service()])
            
            <div class="admin-detail-actions">
                <button type="submit" class="btn btn-primary">Create Service</button>
                <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

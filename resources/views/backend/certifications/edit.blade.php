@extends('backend.layouts.admin')
@section('title', 'Edit Certification')
@section('header', 'Edit Certification')

@section('content')
<a href="{{ route('admin.certifications.index') }}" class="admin-back">← Back to certifications</a>

<div class="admin-detail">
    <div class="admin-detail-header">
        <h3>Edit: {{ $certification->name }}</h3>
    </div>
    <div class="admin-detail-body">
        <form method="POST" enctype="multipart/form-data" action="{{ route('admin.certifications.update', $certification) }}">
            @csrf @method('PUT')
            @include('backend.certifications._form', ['certification' => $certification])
            
            <div class="admin-detail-actions">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="{{ route('admin.certifications.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

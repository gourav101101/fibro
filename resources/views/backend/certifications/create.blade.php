@extends('backend.layouts.admin')
@section('title', 'Create Certification')
@section('header', 'New Certification')

@section('content')
<a href="{{ route('admin.certifications.index') }}" class="admin-back">← Back to certifications</a>

<div class="admin-detail">
    <div class="admin-detail-header">
        <h3>Create Certification</h3>
    </div>
    <div class="admin-detail-body">
        <form method="POST" enctype="multipart/form-data" action="{{ route('admin.certifications.store') }}">
            @csrf
            @include('backend.certifications._form', ['certification' => new \App\Models\Certification()])
            
            <div class="admin-detail-actions">
                <button type="submit" class="btn btn-primary">Create Certification</button>
                <a href="{{ route('admin.certifications.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

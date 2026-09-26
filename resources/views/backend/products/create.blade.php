@extends('backend.layouts.admin')
@section('title', 'Create Product')
@section('header', 'New Product')

@section('content')
<a href="{{ route('admin.products.index') }}" class="admin-back">← Back to products</a>

<div class="admin-detail">
    <div class="admin-detail-header">
        <h3>Create Product</h3>
    </div>
    <div class="admin-detail-body">
        <form method="POST" enctype="multipart/form-data" action="{{ route('admin.products.store') }}">
            @csrf
            @include('backend.products._form', ['product' => new \App\Models\Product()])
            
            <div class="admin-detail-actions">
                <button type="submit" class="btn btn-primary">Create Product</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

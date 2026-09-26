@extends('backend.layouts.admin')
@section('title', 'Edit Product')
@section('header', 'Edit Product')

@section('content')
<a href="{{ route('admin.products.index') }}" class="admin-back">← Back to products</a>

<div class="admin-detail">
    <div class="admin-detail-header">
        <h3>Edit: {{ $product->name }}</h3>
    </div>
    <div class="admin-detail-body">
        <form method="POST" enctype="multipart/form-data" action="{{ route('admin.products.update', $product) }}">
            @csrf @method('PUT')
            @include('backend.products._form', ['product' => $product])
            
            <div class="admin-detail-actions">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

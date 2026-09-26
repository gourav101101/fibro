@extends('backend.layouts.admin')
@section('title', 'Products')
@section('header', 'Products')

@section('content')
<div class="admin-table-wrap">
    <div class="admin-table-header">
        <h3>All Products</h3>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm">+ New Product</a>
    </div>

    @if($products->isEmpty())
        <div class="admin-empty">
            <div class="admin-empty-icon">📦</div>
            <h3>No products found</h3>
            <p>Create your first product to display on the website.</p>
        </div>
    @else
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Material</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td style="width: 60px;">{{ $product->sort_order }}</td>
                        <td style="width: 80px;">
                            @if($product->image)
                                <img src="{{ \App\Support\PublicImage::url($product->image) }}" alt="{{ $product->alt ?: $product->name }}" style="width:40px;height:40px;object-fit:cover;border-radius:4px;">
                            @else
                                <div style="width:40px;height:40px;background:var(--admin-border);border-radius:4px;"></div>
                            @endif
                        </td>
                        <td>{{ $product->name }}<br><small style="color:var(--admin-text-muted)">/products/{{ $product->slug }}</small></td>
                        <td>{{ $product->material ?: '—' }}</td>
                        <td>
                            <span class="badge {{ $product->is_active ? 'badge-sample' : 'badge-read' }}">
                                {{ $product->is_active ? 'Active' : 'Draft' }}
                            </span>
                        </td>
                        <td style="text-align:right;">
                            <div style="display:flex;gap:8px;justify-content:flex-end;">
                                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-ghost btn-sm">Edit</a>
                                <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Delete this product?')">
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

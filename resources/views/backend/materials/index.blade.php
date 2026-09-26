@extends('backend.layouts.admin')
@section('title', 'Materials')
@section('header', 'Materials')

@section('content')
<div class="admin-table-wrap">
    <div class="admin-table-header">
        <h3>Material Categories</h3>
    </div>

    <table class="admin-table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Category</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($materials as $material)
                <tr>
                    <td style="width: 80px;">
                        @if($material->image)
                            <img src="{{ \App\Support\PublicImage::url($material->image) }}" alt="{{ $material->alt ?: $material->name }}" style="width:40px;height:40px;object-fit:cover;border-radius:4px;">
                        @else
                            <div style="width:40px;height:40px;background:var(--admin-border);border-radius:4px;"></div>
                        @endif
                    </td>
                    <td>{{ $material->name }}<br><small style="color:var(--admin-text-muted)">Key: {{ $material->key }}</small></td>
                    <td>{{ $material->category }}</td>
                    <td style="text-align:right;">
                        <a href="{{ route('admin.materials.edit', $material) }}" class="btn btn-ghost btn-sm">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

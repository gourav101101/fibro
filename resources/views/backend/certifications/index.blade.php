@extends('backend.layouts.admin')
@section('title', 'Certifications')
@section('header', 'Certifications')

@section('content')
<div class="admin-table-wrap">
    <div class="admin-table-header">
        <h3>Certifications & Memberships</h3>
        <a href="{{ route('admin.certifications.create') }}" class="btn btn-primary btn-sm">+ New Certification</a>
    </div>

    @if($certifications->isEmpty())
        <div class="admin-empty">
            <div class="admin-empty-icon">📜</div>
            <h3>No certifications found</h3>
        </div>
    @else
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($certifications as $cert)
                    <tr>
                        <td style="width: 60px;">{{ $cert->sort_order }}</td>
                        <td style="width: 80px;">
                            @if($cert->image)
                                <img src="{{ \App\Support\PublicImage::url($cert->image, 'credentials') }}" alt="{{ $cert->name }}" style="width:64px;height:44px;padding:4px;object-fit:contain;background:#fff;border-radius:4px;">
                            @else
                                <div style="width:40px;height:40px;background:var(--admin-border);border-radius:4px;"></div>
                            @endif
                        </td>
                        <td>{{ $cert->name }}</td>
                        <td>{{ $cert->category }}</td>
                        <td>
                            <span class="badge {{ $cert->is_active ? 'badge-sample' : 'badge-read' }}">
                                {{ $cert->is_active ? 'Active' : 'Draft' }}
                            </span>
                        </td>
                        <td style="text-align:right;">
                            <div style="display:flex;gap:8px;justify-content:flex-end;">
                                <a href="{{ route('admin.certifications.edit', $cert) }}" class="btn btn-ghost btn-sm">Edit</a>
                                <form method="POST" action="{{ route('admin.certifications.destroy', $cert) }}" onsubmit="return confirm('Delete this certification?')">
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

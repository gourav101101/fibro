@extends('backend.layouts.admin')
@section('title', 'Services')
@section('header', 'Services')

@section('content')
<div class="admin-table-wrap">
    <div class="admin-table-header">
        <h3>All Services</h3>
        <a href="{{ route('admin.services.create') }}" class="btn btn-primary btn-sm">+ New Service</a>
    </div>

    @if($services->isEmpty())
        <div class="admin-empty">
            <div class="admin-empty-icon">⚙️</div>
            <h3>No services found</h3>
        </div>
    @else
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($services as $service)
                    <tr>
                        <td style="width: 60px;">{{ $service->sort_order }}</td>
                        <td style="width: 80px;">
                            @if($service->image)
                                <img src="{{ \App\Support\PublicImage::url($service->image) }}" alt="{{ $service->name }}" style="width:40px;height:40px;object-fit:cover;border-radius:4px;">
                            @else
                                <div style="width:40px;height:40px;background:var(--admin-border);border-radius:4px;"></div>
                            @endif
                        </td>
                        <td>{{ $service->name }}<br><small style="color:var(--admin-text-muted)">/services/{{ $service->slug }}</small></td>
                        <td>
                            <span class="badge {{ $service->is_active ? 'badge-sample' : 'badge-read' }}">
                                {{ $service->is_active ? 'Active' : 'Draft' }}
                            </span>
                        </td>
                        <td style="text-align:right;">
                            <div style="display:flex;gap:8px;justify-content:flex-end;">
                                <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-ghost btn-sm">Edit</a>
                                <form method="POST" action="{{ route('admin.services.destroy', $service) }}" onsubmit="return confirm('Delete this service?')">
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

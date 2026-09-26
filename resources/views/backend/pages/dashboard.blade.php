@extends('backend.layouts.admin')
@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')
<div class="admin-stats">
    <div class="admin-stat-card">
        <div class="admin-stat-label">Total Enquiries</div>
        <div class="admin-stat-value">{{ $totalEnquiries }}</div>
        <div class="admin-stat-sub">{{ $thisWeek }} this week</div>
    </div>
    <div class="admin-stat-card">
        <div class="admin-stat-label">Unread</div>
        <div class="admin-stat-value" style="color: var(--admin-warning)">{{ $unreadEnquiries }}</div>
        <div class="admin-stat-sub">Awaiting review</div>
    </div>
    <div class="admin-stat-card">
        <div class="admin-stat-label">Products</div>
        <div class="admin-stat-value">{{ $productCount }}</div>
        <div class="admin-stat-sub">Active applications</div>
    </div>
    <div class="admin-stat-card">
        <div class="admin-stat-label">Services</div>
        <div class="admin-stat-value">{{ $serviceCount }}</div>
        <div class="admin-stat-sub">Active services</div>
    </div>
</div>

<div class="admin-table-wrap">
    <div class="admin-table-header">
        <h3>Recent Enquiries</h3>
        <a href="{{ route('admin.enquiries.index') }}" class="btn btn-secondary btn-sm">View all →</a>
    </div>
    @if($recentEnquiries->isEmpty())
        <div class="admin-empty">
            <div class="admin-empty-icon">📭</div>
            <h3>No enquiries yet</h3>
            <p>Enquiries submitted through the website will appear here.</p>
        </div>
    @else
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Type</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentEnquiries as $enquiry)
                    <tr class="{{ $enquiry->isRead() ? '' : 'unread' }}">
                        <td>{{ $enquiry->name }}</td>
                        <td>{{ $enquiry->email }}</td>
                        <td><span class="badge badge-{{ $enquiry->type }}">{{ ucfirst($enquiry->type) }}</span></td>
                        <td>{{ $enquiry->created_at->format('d M Y, H:i') }}</td>
                        <td>
                            <span class="badge {{ $enquiry->isRead() ? 'badge-read' : 'badge-unread' }}">
                                {{ $enquiry->isRead() ? 'Read' : 'New' }}
                            </span>
                        </td>
                        <td><a href="{{ route('admin.enquiries.show', $enquiry) }}" class="btn btn-ghost btn-sm">View →</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection

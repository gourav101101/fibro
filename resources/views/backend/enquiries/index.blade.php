@extends('backend.layouts.admin')
@section('title', 'Enquiries')
@section('header', 'Enquiries')

@section('content')
<div class="admin-table-wrap">
    <div class="admin-table-header">
        <h3>All Enquiries</h3>
        <form method="GET" action="{{ route('admin.enquiries.index') }}" class="admin-filter-bar">
            <input type="text" name="search" class="admin-input" placeholder="Search name, email, company…"
                   value="{{ request('search') }}">
            <select name="type" class="admin-select" onchange="this.form.submit()">
                <option value="">All types</option>
                <option value="project" {{ request('type') === 'project' ? 'selected' : '' }}>Project</option>
                <option value="sample" {{ request('type') === 'sample' ? 'selected' : '' }}>Sample</option>
            </select>
            <select name="status" class="admin-select" onchange="this.form.submit()">
                <option value="">All status</option>
                <option value="unread" {{ request('status') === 'unread' ? 'selected' : '' }}>Unread</option>
                <option value="read" {{ request('status') === 'read' ? 'selected' : '' }}>Read</option>
            </select>
            <button type="submit" class="btn btn-secondary btn-sm">Filter</button>
            @if(request()->hasAny(['search', 'type', 'status']))
                <a href="{{ route('admin.enquiries.index') }}" class="btn btn-ghost btn-sm">Clear</a>
            @endif
        </form>
    </div>

    @if($enquiries->isEmpty())
        <div class="admin-empty">
            <div class="admin-empty-icon">📭</div>
            <h3>No enquiries found</h3>
            <p>{{ request()->hasAny(['search', 'type', 'status']) ? 'Try adjusting your filters.' : 'Enquiries will appear here when visitors submit them.' }}</p>
        </div>
    @else
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Company</th>
                    <th>Type</th>
                    <th>Material</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($enquiries as $enquiry)
                    <tr class="{{ $enquiry->isRead() ? '' : 'unread' }}">
                        <td>{{ $enquiry->name }}</td>
                        <td><a href="mailto:{{ $enquiry->email }}">{{ $enquiry->email }}</a></td>
                        <td>{{ $enquiry->company ?: '—' }}</td>
                        <td><span class="badge badge-{{ $enquiry->type }}">{{ ucfirst($enquiry->type) }}</span></td>
                        <td>{{ $enquiry->material ?: '—' }}</td>
                        <td style="white-space:nowrap">{{ $enquiry->created_at->format('d M Y') }}<br><span style="color:var(--admin-text-muted);font-size:12px">{{ $enquiry->created_at->format('H:i') }}</span></td>
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

        @if($enquiries->hasPages())
            <div class="admin-pagination">
                @if($enquiries->onFirstPage())
                    <span class="disabled">← Prev</span>
                @else
                    <a href="{{ $enquiries->previousPageUrl() }}">← Prev</a>
                @endif

                @foreach($enquiries->getUrlRange(max(1, $enquiries->currentPage()-2), min($enquiries->lastPage(), $enquiries->currentPage()+2)) as $page => $url)
                    @if($page == $enquiries->currentPage())
                        <span class="active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach

                @if($enquiries->hasMorePages())
                    <a href="{{ $enquiries->nextPageUrl() }}">Next →</a>
                @else
                    <span class="disabled">Next →</span>
                @endif
            </div>
        @endif
    @endif
</div>
@endsection

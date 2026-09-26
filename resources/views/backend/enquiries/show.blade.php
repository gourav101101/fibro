@extends('backend.layouts.admin')
@section('title', 'Enquiry from ' . $enquiry->name)
@section('header', 'Enquiry Details')

@section('content')
<a href="{{ route('admin.enquiries.index') }}" class="admin-back">← Back to enquiries</a>

<div class="admin-detail">
    <div class="admin-detail-header">
        <div>
            <h3>{{ $enquiry->name }}</h3>
            <span style="color:var(--admin-text-muted);font-size:13px">
                Submitted {{ $enquiry->created_at->format('d M Y \a\t H:i') }}
                @if($enquiry->isRead())
                    · Read {{ $enquiry->read_at->diffForHumans() }}
                @endif
            </span>
        </div>
        <div style="display:flex;gap:8px;align-items:center">
            <span class="badge {{ $enquiry->isRead() ? 'badge-read' : 'badge-unread' }}">
                {{ $enquiry->isRead() ? 'Read' : 'New' }}
            </span>
            <span class="badge badge-{{ $enquiry->type }}">{{ ucfirst($enquiry->type) }}</span>
        </div>
    </div>

    <div class="admin-detail-body">
        <dl class="admin-detail-meta">
            <div>
                <dt>Name</dt>
                <dd>{{ $enquiry->name }}</dd>
            </div>
            <div>
                <dt>Email</dt>
                <dd><a href="mailto:{{ $enquiry->email }}">{{ $enquiry->email }}</a></dd>
            </div>
            <div>
                <dt>Company</dt>
                <dd>{{ $enquiry->company ?: '—' }}</dd>
            </div>
            <div>
                <dt>Type</dt>
                <dd>{{ ucfirst($enquiry->type) }} enquiry</dd>
            </div>
            <div>
                <dt>Material / Context</dt>
                <dd>{{ $enquiry->material ?: '—' }}</dd>
            </div>
            <div>
                <dt>Language</dt>
                <dd>{{ ['en' => 'English', 'hi' => 'Hindi', 'fr' => 'French'][$enquiry->locale] ?? $enquiry->locale }}</dd>
            </div>
        </dl>

        <h4 style="margin-bottom:12px;font-size:14px;color:var(--admin-text-muted)">MESSAGE</h4>
        <div class="admin-detail-message">{{ $enquiry->message }}</div>

        <div class="admin-detail-actions">
            <a href="mailto:{{ $enquiry->email }}?subject=Re: Your enquiry to Fibro Laminates&body=%0A%0A——%0AOriginal enquiry:%0A{{ urlencode($enquiry->message) }}" class="btn btn-primary">
                Reply via Email
            </a>

            <form method="POST" action="{{ route('admin.enquiries.toggle-read', $enquiry) }}">
                @csrf @method('PATCH')
                <button type="submit" class="btn btn-secondary">
                    {{ $enquiry->isRead() ? 'Mark as Unread' : 'Mark as Read' }}
                </button>
            </form>

            <form method="POST" action="{{ route('admin.enquiries.destroy', $enquiry) }}"
                  onsubmit="return confirm('Delete this enquiry? This cannot be undone from the admin panel.')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </div>
    </div>
</div>
@endsection

@extends('backend.layouts.admin')
@section('title', 'Pages SEO')
@section('header', 'Pages SEO Metadata')

@section('content')
<div class="admin-table-wrap">
    <div class="admin-table-header">
        <h3>Page SEO Metadata</h3>
    </div>

    @if($pages->isEmpty())
        <div class="admin-empty">
            <div class="admin-empty-icon">📄</div>
            <h3>No pages found</h3>
        </div>
    @else
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Page Key</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($pages as $page)
                    <tr>
                        <td><strong>{{ $page->page_key }}</strong></td>
                        <td>{{ Str::limit($page->title, 40) }}</td>
                        <td>{{ Str::limit($page->description, 60) }}</td>
                        <td style="text-align:right;">
                            <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-ghost btn-sm">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection

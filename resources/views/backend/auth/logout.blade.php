@extends('backend.layouts.admin')

@section('title', 'Logout')
@section('header', 'Logout')

@section('content')
    <p>Are you sure you want to log out?</p>
    <form method="POST" action="{{ route('admin.logout') }}">
        @csrf
        <button type="submit" class="btn btn-primary">Logout</button>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-ghost">Cancel</a>
    </form>
@endsection

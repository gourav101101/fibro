@extends('frontend.layouts.app')
@php($page = ['title' => 'Page not found', 'description' => 'Explore Fibro products or contact our team.', 'path' => request()->getPathInfo(), 'type' => 'error'])
@section('content')
    <main class="container" style="padding-block:80px">
        <p class="eyebrow">FIBRO / 404</p>
        <h1>Let’s find the right page.</h1>
        <p style="margin-block:24px">This page is not available. Explore our products or contact the Fibro team.</p>
        <a class="text-link" href="/">Home</a> · <a class="text-link" href="/products">Products</a> · <a class="text-link" href="/contact">Contact Fibro</a>
    </main>
@endsection

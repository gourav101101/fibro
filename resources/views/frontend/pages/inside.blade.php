@extends('frontend.layouts.app')

@section('content')
    @php
        $generatedView = 'frontend.generated.'.$page['id'];
        if (! view()->exists($generatedView)) {
            $generatedView = ($page['type'] ?? null) === 'product'
                ? 'frontend.generated.product-luggage-fabrics'
                : (($page['type'] ?? null) === 'service'
                    ? 'frontend.generated.service-hot-melt-coating'
                    : 'frontend.generated.404');
        }
    @endphp
    <div id="fibro-app" data-page="{{ $page['id'] }}">@include($generatedView)</div>
    <noscript><p style="padding:24px">For enquiries, email <a href="mailto:fibrolaminates@gmail.com">fibrolaminates@gmail.com</a> or call <a href="tel:+919925239699">+91 99252 39699</a>.</p></noscript>
@endsection
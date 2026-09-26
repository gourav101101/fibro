<!DOCTYPE html>
<html lang="en">
<head>
    @include('frontend.partials.head')
</head>
<body>
    <script>window.__FIBRO_CMS__ = @json($cmsContent ?? [], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);</script>
    @yield('content')
</body>
</html>

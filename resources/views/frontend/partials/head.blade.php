    @php
        $pagePath = $page['path'] ?? '/';
        $rawTitle = $page['seo_title'] ?? $page['title'] ?? 'Fibro Laminates | Technical Textiles, Thoughtfully Engineered';
        $pageTitle = \Illuminate\Support\Str::contains(\Illuminate\Support\Str::lower($rawTitle), 'fibro laminates') ? $rawTitle : $rawTitle.' | Fibro Laminates';
        $pageDescription = $page['seo_description'] ?? $page['description'] ?? 'Explore technical fabrics, hot-melt coating, PUR lamination and digital printing from Fibro Laminates.';
        $pageImage = \App\Support\PublicImage::url($page['seo_image'] ?? $page['image'] ?? 'product-highalt.jpg');
        $canonical = url($pagePath);
        $isError = ($page['type'] ?? '') === 'error';
        $organizationId = url('/').'#organization';
        $websiteId = url('/').'#website';
        $breadcrumbs = [['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => url('/')]];
        if ($pagePath !== '/') {
            $segments = array_values(array_filter(explode('/', trim($pagePath, '/'))));
            if (count($segments) > 1) {
                $parentName = match ($segments[0]) { 'products' => 'Products', 'services' => 'Services', default => ucfirst($segments[0]) };
                $breadcrumbs[] = ['@type' => 'ListItem', 'position' => 2, 'name' => $parentName, 'item' => url('/'.$segments[0])];
            }
            $breadcrumbs[] = ['@type' => 'ListItem', 'position' => count($breadcrumbs) + 1, 'name' => $page['title'] ?? $rawTitle, 'item' => $canonical];
        }
        $structuredData = [
            '@context' => 'https://schema.org',
            '@graph' => [
                ['@type' => 'Organization', '@id' => $organizationId, 'name' => 'Fibro Laminates Pvt Ltd', 'url' => url('/'), 'logo' => ['@type' => 'ImageObject', 'url' => url('/images/fibro-official-logo.png')], 'email' => 'fibrolaminates@gmail.com', 'telephone' => '+91 99252 39699', 'description' => 'Fibro Laminates specializes in hot-melt coating and lamination for technical textile applications.', 'address' => ['@type' => 'PostalAddress', 'streetAddress' => 'Plot No. 6125, Road No. 61, GIDC Sachin', 'addressLocality' => 'Surat', 'addressRegion' => 'Gujarat', 'postalCode' => '394230', 'addressCountry' => 'IN']],
                ['@type' => 'WebSite', '@id' => $websiteId, 'url' => url('/'), 'name' => 'Fibro Laminates', 'publisher' => ['@id' => $organizationId], 'inLanguage' => 'en-IN'],
                ['@type' => 'WebPage', '@id' => $canonical.'#webpage', 'url' => $canonical, 'name' => $pageTitle, 'description' => $pageDescription, 'isPartOf' => ['@id' => $websiteId], 'about' => ['@id' => $organizationId], 'primaryImageOfPage' => ['@type' => 'ImageObject', 'url' => $pageImage], 'inLanguage' => 'en-IN'],
                ['@type' => 'BreadcrumbList', 'itemListElement' => $breadcrumbs],
            ],
        ];
    @endphp
    <meta charset="utf-8">
    <script>window.__FIBRO_BASE_PATH__ = @json(rtrim(request()->getBaseUrl(), '/'));</script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="{{ $isError ? 'noindex' : 'index, follow, max-image-preview:large' }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#fcfaf6">
    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $pageDescription }}">
    <link rel="canonical" href="{{ $canonical }}">
    <meta property="og:site_name" content="Fibro Laminates">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $pageDescription }}">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="en_IN">
    <meta property="og:url" content="{{ $canonical }}">
    <meta property="og:image" content="{{ $pageImage }}">
    <meta property="og:image:alt" content="{{ $page['title'] ?? 'Fibro Laminates technical textiles' }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $pageTitle }}">
    <meta name="twitter:description" content="{{ $pageDescription }}">
    <meta name="twitter:image" content="{{ $pageImage }}">
    <script type="application/ld+json">@json($structuredData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)</script>
    <link rel="icon" href="{{ asset('images/fibro-symbol-refined.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/fibro-symbol-refined.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    @viteReactRefresh
    @vite('resources/js/frontend/app.jsx')

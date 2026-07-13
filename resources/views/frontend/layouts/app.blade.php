<!DOCTYPE html>
<html lang="id" class="h-full antialiased">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="preload" as="image" href="{{ setting_url('logo_light') }}">

    {{-- ====================================================
         SEO: Compute final values with smart fallback chain
         Priority: page-specific section > Seo model > global setting
         ==================================================== --}}
    @php
        $siteName    = strip_tags(setting('site_name', config('app.name')));
        $globalDesc  = strip_tags(setting('tagline', $siteName));

        // Title: @yield('title') → seo.meta_title → site name
        $seoTitle = trim(strip_tags($__env->yieldContent('title')));
        if (empty($seoTitle) && !empty($pageSeo?->meta_title)) {
            $seoTitle = $pageSeo->meta_title;
        }
        if (empty($seoTitle)) {
            $seoTitle = $siteName;
        }

        // Description: @yield('description') → seo.meta_description → tagline
        $seoDesc = trim(strip_tags($__env->yieldContent('description')));
        if (empty($seoDesc) && !empty($pageSeo?->meta_description)) {
            $seoDesc = $pageSeo->meta_description;
        }
        if (empty($seoDesc)) {
            $seoDesc = $globalDesc;
        }

        // OG Image: @yield('og_image') → seo.og_image → site logo
        $ogImage = trim(strip_tags($__env->yieldContent('og_image')));
        if (empty($ogImage)) {
            $ogImage = $pageSeo?->og_image
                ? asset('storage/' . $pageSeo->og_image)
                : setting_url('logo');
        }

        $canonicalUrl = url()->current();
    @endphp

    {{-- Title --}}
    <title>{{ $seoTitle }}</title>

    {{-- Standard Meta --}}
    <meta name="description" content="{{ $seoDesc }}" />
    <meta name="robots"      content="index, follow" />
    <link rel="canonical"    href="{{ $canonicalUrl }}" />

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    {{-- Icons --}}
    <link rel="icon"             href="{{ setting_url('favicon', 'favicon.svg') }}" />
    <link rel="apple-touch-icon" href="{{ setting_url('logo', 'logo.png') }}" />



    {{-- Open Graph (WhatsApp, Facebook, LinkedIn preview) --}}
    <meta property="og:type"        content="website" />
    <meta property="og:site_name"   content="{{ $siteName }}" />
    <meta property="og:title"       content="{{ $seoTitle }}" />
    <meta property="og:description" content="{{ $seoDesc }}" />
    <meta property="og:url"         content="{{ $canonicalUrl }}" />
    @if($ogImage)
    <meta property="og:image"       content="{{ $ogImage }}" />
    <meta property="og:image:width"  content="1200" />
    <meta property="og:image:height" content="630" />
    @endif

    {{-- Twitter / X Cards --}}
    <meta name="twitter:card"        content="summary_large_image" />
    <meta name="twitter:title"       content="{{ $seoTitle }}" />
    <meta name="twitter:description" content="{{ $seoDesc }}" />
    @if($ogImage)
    <meta name="twitter:image"       content="{{ $ogImage }}" />
    @endif

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    {{-- Google Fonts - Poppins --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">

    {{-- Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Extra Head --}}
    @stack('head')
</head>

<body class="min-h-screen bg-white text-gray-900">

    {{-- Navbar --}}
    @include('frontend.partials.navbar')
    @include('frontend.partials.navbar-mobile')


    {{-- MAIN CONTENT --}}
    <main class="relative">
        @yield('content')
    </main>

    {{-- Toast --}}
    @if (session('success'))
    @include('frontend.partials.toast')
    @endif

    {{-- Footer --}}
    @include('frontend.partials.footer')

    {{-- Extra Scripts --}}
    @stack('scripts')

    {{-- WhatsApp Floating --}}
    <div x-data x-init="$nextTick(() => $el.innerHTML = @js(view('frontend.partials.whatsapp-float')->render()))"></div>


</body>

</html>

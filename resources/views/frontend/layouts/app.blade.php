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

        // Keywords: @yield('keywords') → seo.meta_keywords
        $seoKeywords = trim(strip_tags($__env->yieldContent('keywords')));
        if (empty($seoKeywords) && !empty($pageSeo?->meta_keywords)) {
            $seoKeywords = $pageSeo->meta_keywords;
        }

        // OG Image: @yield('og_image') → seo.og_image → site logo
        $ogImage = trim(strip_tags($__env->yieldContent('og_image')));
        if (empty($ogImage)) {
            $ogImage = $pageSeo?->og_image
                ? asset('storage/' . $pageSeo->og_image)
                : setting_url('logo');
        }

        // Force canonical URL to always use HTTPS on production to prevent HTTP/HTTPS duplicate content issues
        $canonicalUrl = url()->current();
        if (app()->environment('production') || str_starts_with(config('app.url'), 'https://')) {
            $canonicalUrl = preg_replace('/^http:/i', 'https:', $canonicalUrl);
        }
    @endphp

    {{-- Title --}}
    <title>{{ $seoTitle }}</title>

    {{-- Standard Meta --}}
    <meta name="description" content="{{ $seoDesc }}" />
    @if(!empty($seoKeywords))
    <meta name="keywords" content="{{ $seoKeywords }}" />
    @endif
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

    {{-- ====================================================
         STRUCTURED DATA (JSON-LD) SCHEMA ORG
         ==================================================== --}}
    @if(request()->routeIs('home'))
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "Organization",
      "name": "{{ $siteName }}",
      "image": "{{ setting_url('logo', asset('logo.png')) }}",
      "@@id": "{{ url('/') }}",
      "url": "{{ url('/') }}",
      "telephone": "{{ setting('whatsapp_number', '') }}",
      "address": {
        "@@type": "PostalAddress",
        "streetAddress": "{{ setting('address', 'Jakarta, Indonesia') }}",
        "addressLocality": "Jakarta",
        "addressRegion": "DKI Jakarta",
        "postalCode": "10000",
        "addressCountry": "ID"
      },
      "areaServed": {
        "@@type": "Country",
        "name": "Indonesia"
      },
      "subOrganization": [
        {
          "@@type": "LocalBusiness",
          "name": "{{ $siteName }} Cabang Semarang",
          "telephone": "{{ setting('whatsapp_number', '') }}",
          "address": {
            "@@type": "PostalAddress",
            "streetAddress": "Semarang, Jawa Tengah, Indonesia",
            "addressLocality": "Semarang",
            "addressRegion": "Jawa Tengah",
            "addressCountry": "ID"
          }
        },
        {
          "@@type": "LocalBusiness",
          "name": "{{ $siteName }} Cabang Surabaya",
          "telephone": "{{ setting('whatsapp_number', '') }}",
          "address": {
            "@@type": "PostalAddress",
            "streetAddress": "Surabaya, Jawa Timur, Indonesia",
            "addressLocality": "Surabaya",
            "addressRegion": "Jawa Timur",
            "addressCountry": "ID"
          }
        }
      ],
      "description": "{{ $globalDesc }}",
      "sameAs": [
        "{{ setting('facebook_url', '#') }}",
        "{{ setting('instagram_url', '#') }}"
      ]
    }
    </script>
    @elseif(request()->routeIs('pages.show') && isset($page))
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "BlogPosting",
      "mainEntityOfPage": {
        "@@type": "WebPage",
        "@@id": "{{ $canonicalUrl }}"
      },
      "headline": "{{ $page->title }}",
      "description": "{{ Str::limit(strip_tags($page->excerpt ?: $page->content), 150) }}",
      "image": "{{ $page->thumbnail ? asset('storage/' . $page->thumbnail) : setting_url('logo', asset('logo.png')) }}",  
      "author": {
        "@@type": "Organization",
        "name": "{{ $siteName }}"
      },  
      "publisher": {
        "@@type": "Organization",
        "name": "{{ $siteName }}",
        "logo": {
          "@@type": "ImageObject",
          "url": "{{ setting_url('logo', asset('logo.png')) }}"
        }
      },
      "datePublished": "{{ \Carbon\Carbon::parse($page->publish_at)->toIso8601String() }}",
      "dateModified": "{{ $page->updated_at->toIso8601String() }}"
    }
    </script>
    @elseif(request()->routeIs('products.show') && isset($product))
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "Product",
      "name": "{{ $product->name }}",
      "image": [
        @if(is_array($product->images) && count($product->images))
          @foreach($product->images as $img)
            "{{ asset('storage/' . $img) }}"{{ !$loop->last ? ',' : '' }}
          @endforeach
        @else
          "{{ setting_url('logo', asset('logo.png')) }}"
        @endif
      ],
      "description": "{{ Str::limit(strip_tags($product->description), 150) }}",
      "sku": "FORKLIFT-{{ $product->id }}",
      "mpn": "FORKLIFT-{{ $product->id }}",
      "brand": {
        "@@type": "Brand",
        "name": "HANGCHA"
      }
    }
    </script>
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

    {{-- Google Analytics & Custom Header Scripts --}}
    {!! setting('custom_header_scripts') !!}
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


    {{-- Custom Footer Scripts --}}
    {!! setting('custom_footer_scripts') !!}
</body>

</html>

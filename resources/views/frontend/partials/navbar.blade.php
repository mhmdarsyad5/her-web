@php
    $pagesActive = request()->routeIs(
        'pages.index',
        'pages.show',
        'faq.index',
        'terms-conditions.index',
        'privacy-policy.index'
    );

    $rawWa = strip_tags(setting('whatsapp_number', '+62 821-1234-5678'));
    $cleanWa = preg_replace('/[^0-9]/', '', $rawWa);
    if (str_starts_with($cleanWa, '0')) {
        $cleanWa = '62' . substr($cleanWa, 1);
    }

    $rawEmail = strip_tags(setting('email', 'info@example.com'));

    $b1 = \Illuminate\Support\Str::afterLast(strip_tags(setting('branch_1_name', 'Jakarta')), ' ');
    $b2 = \Illuminate\Support\Str::afterLast(strip_tags(setting('branch_2_name', 'Bogor')), ' ');
    $b3 = \Illuminate\Support\Str::afterLast(strip_tags(setting('branch_3_name', 'Bandung')), ' ');
@endphp

{{-- TOP BAR (Double-Decker Concept) --}}
<div class="hidden lg:block w-full bg-zinc-950 text-zinc-300 text-[11px] font-medium py-2.5 border-b border-zinc-800/65">
    <div class="mx-auto max-w-7xl px-4 flex justify-between items-center">
        {{-- Left: Phone & Email & Locations --}}
        <div class="flex items-center gap-6">
            <a href="https://wa.me/{{ $cleanWa }}" target="_blank" class="flex items-center gap-1.5 text-zinc-300 hover:text-white transition-colors">
                <x-heroicon-o-phone class="w-3.5 h-3.5 text-primary-900 shrink-0" />
                <span>{{ $rawWa }}</span>
            </a>
            <span class="w-px h-3 bg-zinc-800"></span>
            <a href="mailto:{{ $rawEmail }}" class="flex items-center gap-1.5 text-zinc-300 hover:text-white transition-colors">
                <x-heroicon-o-envelope class="w-3.5 h-3.5 text-primary-900 shrink-0" />
                <span>{{ $rawEmail }}</span>
            </a>
            <span class="w-px h-3 bg-zinc-800"></span>
            <div class="flex items-center gap-1.5 text-zinc-300">
                <x-heroicon-o-map-pin class="w-3.5 h-3.5 text-primary-900 shrink-0" />
                <div class="flex items-center gap-2">
                    <a href="{{ route('contacts.index') }}" class="hover:text-white transition-colors" title="{{ strip_tags(setting('branch_1_name')) }}">{{ $b1 }}</a>
                    <span class="text-zinc-800">•</span>
                    <a href="{{ route('contacts.index') }}" class="hover:text-white transition-colors" title="{{ strip_tags(setting('branch_2_name')) }}">{{ $b2 }}</a>
                    <span class="text-zinc-800">•</span>
                    <a href="{{ route('contacts.index') }}" class="hover:text-white transition-colors" title="{{ strip_tags(setting('branch_3_name')) }}">{{ $b3 }}</a>
                </div>
            </div>
        </div>
        {{-- Right: Social Media --}}
        <div class="flex items-center gap-4 text-zinc-400">
            @if(setting('social_facebook'))
                <a href="{{ strip_tags(setting('social_facebook')) }}" target="_blank" rel="noopener noreferrer" class="hover:text-white transition-colors" title="Facebook">
                    <svg class="h-4 w-4 fill-current" viewBox="0 0 24 24">
                        <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-3 7h-1.924c-.615 0-1.076.252-1.076.885v1.115h3l-.5 3h-2.5v8h-3v-8h-2v-3h2v-2.07c0-2.062 1.343-3.18 3.5-3.18 1.053 0 1.956.08 2.222.11v2.585z" />
                    </svg>
                </a>
            @endif
            @if(setting('social_instagram'))
                <a href="{{ strip_tags(setting('social_instagram')) }}" target="_blank" rel="noopener noreferrer" class="hover:text-white transition-colors" title="Instagram">
                    <svg class="h-4 w-4 fill-current" viewBox="0 0 24 24">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.051.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z" />
                    </svg>
                </a>
            @endif
            @if(setting('social_tiktok'))
                <a href="{{ strip_tags(setting('social_tiktok')) }}" target="_blank" rel="noopener noreferrer" class="hover:text-white transition-colors" title="TikTok">
                    <svg class="h-4 w-4 fill-current" viewBox="0 0 24 24">
                        <path d="M12.53.02C13.84 0 15.14.01 16.44 0c.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.6-1v7.65c0 1.62-.37 3.27-1.21 4.6-1.39 2.23-3.94 3.65-6.6 3.62-3.11-.03-6.07-2.07-7.14-5-1.29-3.48-.11-7.79 2.92-10 1.47-1.07 3.28-1.62 5.12-1.57.02 1.34 0 2.69.01 4.03-1.1-.06-2.25.2-3.15.85-1.2.87-1.85 2.47-1.55 3.96.28 1.36 1.43 2.44 2.81 2.58 1.65.17 3.24-.76 3.79-2.29.26-.71.3-1.49.3-2.24V.02z" />
                    </svg>
                </a>
            @endif
            @if(setting('social_linkedin'))
                <a href="{{ strip_tags(setting('social_linkedin')) }}" target="_blank" rel="noopener noreferrer" class="hover:text-white transition-colors" title="LinkedIn">
                    <svg class="h-4 w-4 fill-current" viewBox="0 0 24 24">
                        <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                    </svg>
                </a>
            @endif
        </div>
    </div>
</div>

<nav x-data="{ mobileOpen: false }" x-cloak class="sticky top-0 z-50 w-full
           bg-white/90
           backdrop-blur-md border-b border-zinc-100 shadow-sm">

    <div class="mx-auto max-w-7xl px-4">
        <div class="flex h-20 min-h-[80px] items-center justify-between">
            {{-- LOGO --}}
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="{{ setting_url('logo_light') }}" alt="{{ strip_tags($siteName ?? 'Website') }} Logo"
                    class="h-10 w-auto" width="160" height="40" fetchpriority="high">
            </a>

            {{-- DESKTOP MENU --}}
            <div class="hidden lg:flex items-center gap-6 text-sm font-medium">

                <a href="{{ route('home') }}"
                    class="nav-link {{ request()->routeIs('home') ? 'nav-link-active' : '' }}">
                    {{ strip_tags(setting('nav_home', 'Beranda')) }}
                </a>

                <a href="{{ route('abouts.index') }}"
                    class="nav-link {{ request()->routeIs('abouts.index') ? 'nav-link-active' : '' }}">
                    {{ strip_tags(setting('nav_about', 'Tentang Kami')) }}
                </a>

                <a href="{{ route('services.index') }}"
                    class="nav-link {{ request()->routeIs('services.index') ? 'nav-link-active' : '' }}">
                    {{ strip_tags(setting('nav_services', 'Layanan')) }}
                </a>

                <a href="{{ route('products.index') }}"
                    class="nav-link {{ request()->routeIs('products.index') ? 'nav-link-active' : '' }}">
                    {{ strip_tags(setting('nav_product', 'Produk')) }}
                </a>

                <a href="{{ route('pages.index') }}"
                    class="nav-link {{ request()->routeIs('pages.index', 'pages.show') ? 'nav-link-active' : '' }}">
                    {{ strip_tags(setting('nav_blog', 'Blog')) }}
                </a>

                <a href="{{ route('contacts.index') }}"
                    class="nav-link {{ request()->routeIs('contacts.index') ? 'nav-link-active' : '' }}">
                    {{ strip_tags(setting('nav_contact', 'Kontak')) }}
                </a>

            </div>



            {{-- RIGHT ACTIONS --}}
            <div class="flex items-center gap-2">

                <a href="{{ route('contacts.index') }}" class="hidden lg:inline-flex items-center gap-2
          rounded-md px-4 py-2 text-sm font-semibold
          bg-primary-900 text-white
          hover:bg-primary-800
          transition">
                    <x-heroicon-o-phone class="w-4 h-4" />
                    {{ strip_tags(setting('nav_contact_cta', 'Hubungi Kami')) }}
                </a>

                {{-- MOBILE BUTTON --}}
                <button @click="mobileOpen = !mobileOpen" class="lg:hidden inline-flex h-9 w-9 items-center justify-center
                           rounded-md border border-zinc-200"
                           aria-label="Menu Utama">

                    <x-heroicon-o-bars-3 x-show="!mobileOpen" class="h-5 w-5" />
                    <x-heroicon-o-x-mark x-show="mobileOpen" class="h-5 w-5" />
                </button>
            </div>
        </div>

        {{-- MOBILE MENU (OVERLAY) --}}
        <div x-show="mobileOpen" x-transition.opacity x-cloak class="lg:hidden absolute top-full left-0 w-full z-40">

            <div class="px-4 pt-4">
                <div class="rounded-2xl border
                   border-zinc-200
                   bg-white
                   shadow-lg
                   divide-y divide-zinc-200
                   overflow-hidden">

                    <a href="{{ route('home') }}"
                        class="mobile-card-link {{ request()->routeIs('home') ? 'active' : '' }}">
                        {{ strip_tags(setting('nav_home', 'Beranda')) }}
                    </a>

                    <a href="{{ route('abouts.index') }}"
                        class="mobile-card-link {{ request()->routeIs('abouts.index') ? 'active' : '' }}">
                        {{ strip_tags(setting('nav_about', 'Tentang Kami')) }}
                    </a>

                    <a href="{{ route('services.index') }}"
                        class="mobile-card-link {{ request()->routeIs('services.*') ? 'active' : '' }}">
                        {{ strip_tags(setting('nav_services', 'Layanan')) }}
                    </a>

                    <a href="{{ route('products.index') }}"
                        class="mobile-card-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                        {{ strip_tags(setting('nav_product', 'Produk')) }}
                    </a>

                    <a href="{{ route('pages.index') }}"
                        class="mobile-card-link {{ request()->routeIs('pages.*', 'faq.index', 'terms-conditions.index', 'privacy-policy.index') ? 'active' : '' }}">
                        {{ strip_tags(setting('nav_blog', 'Blog')) }}
                    </a>



                    <a href="{{ route('contacts.index') }}"
                        class="mobile-card-link {{ request()->routeIs('contacts.index') ? 'active' : '' }}">
                        {{ strip_tags(setting('nav_contact', 'Kontak')) }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>
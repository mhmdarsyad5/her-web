@php
    $pagesActive = request()->routeIs(
        'pages.index',
        'pages.show',
        'faq.index',
        'terms-conditions.index',
        'privacy-policy.index'
    );
@endphp

<nav x-data="{ mobileOpen: false }" x-cloak class="sticky top-0 z-50 w-full
           bg-white/80
           backdrop-blur supports-[backdrop-filter]:bg-white/60">

    <div class="mx-auto max-w-7xl px-4">
        <div class="flex h-16 min-h-[64px] items-center justify-between">
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
                    <x-heroicon-o-arrow-top-right-on-square class="w-4 h-4" />
                    {{ strip_tags(setting('nav_contact_cta', 'Hubungi Kami')) }}
                </a>

                {{-- MOBILE BUTTON --}}
                <button @click="mobileOpen = !mobileOpen" class="lg:hidden inline-flex h-9 w-9 items-center justify-center
                           rounded-md border border-zinc-200">

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
@php
$menus = [
[
'key' => 'home',
'name' => strip_tags(setting('nav_home', 'Beranda')),
'icon' => 'heroicon-o-home',
'route' => 'home',
'active' => request()->routeIs('home'),
],
[
'key' => 'about',
'name' => strip_tags(setting('nav_about', 'Tentang')),
'icon' => 'heroicon-o-information-circle',
'route' => 'abouts.index',
'active' => request()->routeIs('abouts.index'),
],
[
'key' => 'services',
'name' => strip_tags(setting('nav_services', 'Layanan')),
'icon' => 'heroicon-o-wrench',
'route' => 'services.index',
'active' => request()->routeIs('services.*'),
],
[
'key' => 'products',
'name' => strip_tags(setting('nav_product', 'Produk')),
'icon' => 'heroicon-o-shopping-bag',
'route' => 'products.index',
'active' => request()->routeIs('products.*'),
],
[
'key' => 'contact',
'name' => strip_tags(setting('nav_contact', 'Kontak')),
'icon' => 'heroicon-o-phone',
'route' => 'contacts.index',
'active' => request()->routeIs('contacts.index'),
],
];
@endphp

<nav
    class="fixed bottom-4 left-1/2 -translate-x-1/2 z-50 md:hidden
           w-[92%] max-w-md
           bg-white/90 backdrop-blur-xl
           border border-zinc-200/50
           shadow-2xl
           rounded-3xl py-3 px-4 flex justify-around items-center">

    @foreach ($menus as $item)
    <a href="{{ route($item['route']) }}"
        class="relative flex-1 min-w-0 flex flex-col items-center gap-1 py-1.5 px-1 rounded-xl transition-all duration-300
              {{ $item['active']
                  ? 'text-primary-700 bg-primary-100/50'
                  : 'text-zinc-600 hover:text-primary-700' }}">

        {{-- ICON --}}
        @if($item['key'] === 'products')
            <svg viewBox="0 0 24 24" class="h-5 w-5 transition-all duration-300 {{ $item['active'] ? 'text-primary-700' : 'text-zinc-600 group-hover:scale-110' }}" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <!-- Mast & Fork -->
                <path d="M19 5v14M19 14h3M19 18h3" />
                <!-- Forklift Cabin & Chassis -->
                <path d="M3 18h3M15 18h4" />
                <path d="M6 18V11h9v7H6z" />
                <path d="M9 11V6h3l3 5" />
                <path d="M9 11v-1.5a1 1 0 011-1h1.5" />
                <path d="M3 18v-4a2 2 0 012-2h1" />
                <!-- Wheels -->
                <circle cx="9" cy="18" r="2" />
                <circle cx="15" cy="18" r="2" />
            </svg>
        @else
            <x-dynamic-component
                :component="$item['icon']"
                class="h-5 w-5 transition-all duration-300
                       {{ $item['active'] ? '' : 'group-hover:scale-110' }}" />
        @endif

        {{-- LABEL --}}
        <span class="text-[10px] font-medium transition-all duration-300 truncate w-full text-center">
            {{ $item['name'] }}
        </span>

        {{-- ACTIVE INDICATOR (optional subtle dot) --}}
        @if($item['active'])
        <span class="absolute -top-1 w-1.5 h-1.5 rounded-full bg-primary-600"></span>
        @endif
    </a>
    @endforeach

</nav>

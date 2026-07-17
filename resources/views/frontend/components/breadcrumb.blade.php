@props(['items' => null, 'title' => null])

@php
$breadcrumbs = [];

/*
|--------------------------------------------------------------------------
| PRIORITAS
|--------------------------------------------------------------------------
| 1. Jika items dikirim → pakai items
| 2. Jika title dikirim → Home / Title
| 3. Fallback → auto dari URL (tanpa duplikat slug terakhir)
*/

if ($items && is_array($items)) {
$breadcrumbs = $items;

} elseif ($title) {
$breadcrumbs[] = [
'label' => strip_tags($title),
'url' => null
];

} else {
$segments = request()->segments();

foreach ($segments as $index => $segment) {
$label = ucfirst(str_replace('-', ' ', $segment));

// Cegah duplikasi slug terakhir (detail page)
if ($index === count($segments) - 1 && request()->routeIs('pages.show')) {
continue;
}

$url = '/' . implode('/', array_slice($segments, 0, $index + 1));

$breadcrumbs[] = [
'label' => $label,
'url' => $url
];
}
}
@endphp

<section class="py-2.5 sm:py-3 bg-neutral-50/50 border-b border-zinc-200/40">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <nav class="flex flex-wrap items-center text-xs sm:text-sm text-neutral-600 gap-1">

            {{-- HOME --}}
            <a href="{{ route('home') }}"
                class="font-medium hover:text-neutral-900 transition">
                {{ strip_tags(setting('breadcrumb_home', 'Beranda')) }}
            </a>

            @foreach ($breadcrumbs as $crumb)
            <span class="text-neutral-400">/</span>

            @if ($loop->last || empty($crumb['url']))
            <span class="font-semibold text-neutral-900">
                {{ $crumb['label'] }}
            </span>
            @else
            <a href="{{ $crumb['url'] }}"
                class="font-medium hover:text-neutral-900 transition">
                {{ $crumb['label'] }}
            </a>
            @endif
            @endforeach

        </nav>
    </div>
</section>

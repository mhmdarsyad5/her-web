@extends('frontend.layouts.app')

@section(
'title',
strip_tags($title) . ' - ' . strip_tags(setting('site_name', 'mulaidigital.com'))
)

@section('content')

@include('frontend.components.breadcrumb')

<section class="pt-1 pb-12 sm:pt-2 sm:pb-16 bg-zinc-50">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        {{-- ================= HEADER ================= --}}
        <div class="mb-6 text-center max-w-2xl mx-auto fade-slide opacity-0 translate-y-4">

            @if(setting('product_badge_active', true) && setting('product_badge'))
                <span class="inline-flex items-center rounded-full
                               bg-zinc-150 border border-zinc-200/40
                               px-3.5 py-1
                               text-xs font-semibold tracking-wide
                               text-zinc-900">
                    {{ strip_tags(setting('product_badge')) }}
                </span>
            @endif

            <h1 class="mt-4 text-2xl sm:text-3.5xl lg:text-4xl
                       font-extrabold tracking-tight leading-tight
                       text-zinc-950">
                {!! setting('product_title', 'Produk Kami') !!}
            </h1>

            <p class="mt-3 text-sm sm:text-base
                       leading-relaxed
                       text-zinc-650">
                {!! setting(
                'product_subtitle',
                'Koleksi produk unggulan kami dengan kualitas terbaik dan harga kompetitif.'
                ) !!}
            </p>
        </div>

        {{-- ================= SEARCH ================= --}}
        <div class="mb-8 flex justify-center fade-slide opacity-0 translate-y-4">
            <div class="relative w-full max-w-md">
                <input
                    type="text"
                    id="searchInput"
                    placeholder="{{ strip_tags(setting('product_search_placeholder', 'Cari produk...')) }}"
                    class="w-full rounded-xl border
                           border-zinc-300
                           bg-white
                           px-4 py-3 pl-10
                           text-sm sm:text-base
                           text-zinc-900
                           placeholder:text-zinc-400
                           focus:outline-none
                           focus:ring-2 focus:ring-primary-500/30
                           transition">

                <x-heroicon-o-magnifying-glass
                    class="absolute left-3 top-3.5 h-5 w-5
                           text-zinc-500" />
            </div>
        </div>

        {{-- ================= GRID ================= --}}
        <div
            id="productGrid"
            class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3
                   gap-4 sm:gap-6 lg:gap-8
                   fade-slide opacity-0 translate-y-4">

            @forelse ($products as $product)
            <article class="group flex flex-col h-full overflow-hidden rounded-2xl border
                                border-zinc-200/70
                                bg-white
                                shadow-sm
                                transition-all duration-300
                                hover:-translate-y-1 hover:shadow-lg hover:border-primary-900/30">

                {{-- Image Section --}}
                <a href="{{ route('products.show', $product->slug) }}"
                    class="relative block overflow-hidden rounded-t-2xl bg-zinc-50 border-b border-zinc-100 flex items-center justify-center aspect-square w-full">
                    <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}"
                        class="h-full w-full object-cover">

                    <div
                        class="absolute inset-0 bg-gradient-to-t from-black/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                    </div>
                </a>

                {{-- Info Section --}}
                <div class="flex flex-col flex-1 p-4 sm:p-5 relative">
                    <div class="flex-1">
                        <a href="{{ route('products.show', $product->slug) }}">
                            <h3
                                class="text-sm sm:text-base font-bold text-zinc-955 line-clamp-2 transition-colors group-hover:text-primary-900">
                                {{ $product->name }}
                            </h3>
                        </a>

                        {{-- Tagline --}}
                        @if($product->tagline)
                            <p class="mt-2 text-xs sm:text-sm text-zinc-600 font-semibold leading-relaxed">
                                {{ $product->tagline }}
                            </p>
                        @endif
                    </div>

                    {{-- Specifications (Vertical Premium List with Icons) --}}
                    <div
                        class="mt-4 space-y-2 bg-zinc-50/80 p-2.5 rounded-xl border border-zinc-100/80">
                        {{-- Energy Spec --}}
                        <div class="flex items-center justify-between text-xs min-w-0">
                            <div class="flex items-center gap-2 text-zinc-500">
                                <svg class="h-4 w-4 text-zinc-400 flex-shrink-0" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                                </svg>
                                <span class="font-semibold text-zinc-500">Tipe Energi</span>
                            </div>
                            <span
                                class="font-bold text-zinc-800 text-right ml-2">{{ $product->energy_type ?: '-' }}</span>
                        </div>

                        {{-- Height Spec --}}
                        <div
                            class="flex items-center justify-between text-xs min-w-0 border-t border-zinc-200/40 pt-2.5">
                            <div class="flex items-center gap-2 text-zinc-500">
                                <svg class="h-4 w-4 text-zinc-400 flex-shrink-0" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9M12 5.25v13.5M3 3h18M3 21h18" />
                                </svg>
                                <span class="font-semibold text-zinc-500">Tinggi Angkat</span>
                            </div>
                            <span
                                class="font-bold text-zinc-800 text-right ml-2">{{ $product->lift_height ?: '-' }}</span>
                        </div>

                        {{-- Capacity Spec --}}
                        <div
                            class="flex items-center justify-between text-xs min-w-0 border-t border-zinc-200/40 pt-2.5">
                            <div class="flex items-center gap-2 text-zinc-500">
                                <svg class="h-4 w-4 text-zinc-400 flex-shrink-0" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 6h18M5 6v10a2 2 0 002 2h10a2 2 0 002-2V6M9 6V4a2 2 0 012-2h2a2 2 0 012 2v2" />
                                </svg>
                                <span class="font-semibold text-zinc-500">Kapasitas Beban</span>
                            </div>
                            <span
                                class="font-bold text-zinc-800 text-right ml-2">{{ $product->load_capacity ?: '-' }}</span>
                        </div>
                    </div>

                    {{-- Actions (Matching mockup exactly) --}}
                    <div class="mt-6 flex flex-col gap-2 pt-4 border-t border-zinc-100/80">
                        @php
                            $waNumber = preg_replace('/[^0-9]/', '', setting('whatsapp_number', '6281234567890'));
                            $productMessage = rawurlencode("Halo, saya tertarik untuk menyewa unit " . $product->name . ".");
                            $waUrl = "https://wa.me/{$waNumber}?text={$productMessage}";
                        @endphp

                        {{-- WhatsApp Button --}}
                        <a href="{{ $waUrl }}" target="_blank"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-green-600 hover:bg-green-700 text-white py-2.5 px-4 text-sm font-semibold transition-all duration-200">
                            <svg class="h-4 w-4 fill-current flex-shrink-0" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.746.953 3.71 1.455 5.703 1.456h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                            </svg>
                            Sewa Unit ini
                        </a>

                        {{-- Detail Button (Uses primary color from setting) --}}
                        @php
                            $primaryColor = setting('primary_color', '#ff7f00');
                        @endphp
                        <a href="{{ route('products.show', $product->slug) }}"
                            style="background-color: {{ $primaryColor }};"
                            class="inline-flex items-center justify-center gap-2 rounded-xl text-white py-2.5 px-4 text-sm font-semibold transition-all duration-200 hover:opacity-90">
                            Lihat Detail Unit
                        </a>
                    </div>
                </div>
            </article>

            @empty
            <div class="col-span-full text-center py-20">
                <p class="text-sm text-zinc-600">
                    Produk tidak ditemukan.
                </p>
            </div>
            @endforelse
        </div>

        {{-- ================= PAGINATION ================= --}}
        <div id="paginationWrapper"
            class="mt-14 fade-slide opacity-0 translate-y-4">
            {{ $products->links('pagination::tailwind') }}
        </div>

    </div>
</section>

@endsection

{{-- ================= FADE ANIMATION ================= --}}
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const elements = document.querySelectorAll(".fade-slide");

        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.remove("opacity-0", "translate-y-4");
                    entry.target.classList.add("opacity-100", "translate-y-0");
                    entry.target.style.transition =
                        "all 0.7s cubic-bezier(0.4, 0, 0.2, 1)";
                }
            });
        }, {
            threshold: 0.1
        });

        elements.forEach(el => observer.observe(el));
    });
</script>

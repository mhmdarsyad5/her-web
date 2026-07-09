@extends('frontend.layouts.app')

@section(
'title',
strip_tags($title) . ' - ' . strip_tags(setting('site_name', 'Herro Equipment Rentals'))
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

        {{-- ================= SEGMENT FILTER BAR ================= --}}
        <div class="mb-10 flex justify-center fade-slide opacity-0 translate-y-4">
            <div class="flex items-center gap-3 overflow-x-auto pb-4 pt-1 w-full max-w-6xl scrollbar-none justify-start lg:justify-center px-1">
                <button type="button" data-segment="all" class="segment-btn active flex-shrink-0 px-5 py-3 rounded-2xl border border-zinc-200 text-xs sm:text-sm font-semibold text-zinc-700 bg-white shadow-sm hover:border-zinc-300 hover:text-zinc-900 active:scale-95 transition-all duration-200 cursor-pointer">
                    Semua Produk
                </button>
                <button type="button" data-segment="lithium" class="segment-btn flex-shrink-0 px-5 py-3 rounded-2xl border border-zinc-200 text-xs sm:text-sm font-semibold text-zinc-700 bg-white shadow-sm hover:border-zinc-300 hover:text-zinc-900 active:scale-95 transition-all duration-200 cursor-pointer">
                    Lithium-Ion Forklift
                </button>
                <button type="button" data-segment="electric" class="segment-btn flex-shrink-0 px-5 py-3 rounded-2xl border border-zinc-200 text-xs sm:text-sm font-semibold text-zinc-700 bg-white shadow-sm hover:border-zinc-300 hover:text-zinc-900 active:scale-95 transition-all duration-200 cursor-pointer">
                    Forklift Elektrik
                </button>
                <button type="button" data-segment="diesel" class="segment-btn flex-shrink-0 px-5 py-3 rounded-2xl border border-zinc-200 text-xs sm:text-sm font-semibold text-zinc-700 bg-white shadow-sm hover:border-zinc-300 hover:text-zinc-900 active:scale-95 transition-all duration-200 cursor-pointer">
                    Forklift Diesel
                </button>
                <button type="button" data-segment="pallet-truck" class="segment-btn flex-shrink-0 px-5 py-3 rounded-2xl border border-zinc-200 text-xs sm:text-sm font-semibold text-zinc-700 bg-white shadow-sm hover:border-zinc-300 hover:text-zinc-900 active:scale-95 transition-all duration-200 cursor-pointer">
                    Pallet Truck
                </button>
                <button type="button" data-segment="pallet-stacker" class="segment-btn flex-shrink-0 px-5 py-3 rounded-2xl border border-zinc-200 text-xs sm:text-sm font-semibold text-zinc-700 bg-white shadow-sm hover:border-zinc-300 hover:text-zinc-900 active:scale-95 transition-all duration-200 cursor-pointer">
                    Pallet Stacker
                </button>
                <button type="button" data-segment="warehouse" class="segment-btn flex-shrink-0 px-5 py-3 rounded-2xl border border-zinc-200 text-xs sm:text-sm font-semibold text-zinc-700 bg-white shadow-sm hover:border-zinc-300 hover:text-zinc-900 active:scale-95 transition-all duration-200 cursor-pointer">
                    Warehouse & AGV
                </button>
            </div>
        </div>

        {{-- ================= GRID ================= --}}
        <div
            id="productGrid"
            class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3
                   gap-6 lg:gap-8
                   fade-slide opacity-0 translate-y-4">

            @include('frontend.pages.products.partials.products-list')
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

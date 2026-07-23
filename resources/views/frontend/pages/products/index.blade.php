@extends('frontend.layouts.app')

@section(
'title',
strip_tags($title) . ' - ' . strip_tags(setting('site_name', 'Herro Equipment Rentals'))
)

@section('description', 'Temukan berbagai pilihan alat berat berkualitas tinggi untuk disewa, seperti forklift HANGCHA, genset, dan alat berat lainnya di Herro Equipment Rentals.')

@section('content')

<style>
    .segment-btn {
        display: inline-flex;
        align-items: center;
    }
    .segment-btn.active {
        background-color: var(--primary-color, #F5A21C) !important;
        color: #ffffff !important;
        border-color: var(--primary-color, #F5A21C) !important;
        box-shadow: 0 3px 10px 0 rgba(245, 162, 28, 0.2) !important;
        transform: scale(1.03);
        font-weight: 700;
    }
    .segment-count {
        background-color: #f4f4f5;
        color: #71717a;
        border-radius: 9999px;
        padding: 0.05rem 0.25rem;
        font-size: 9px;
        font-weight: 750;
        margin-left: 0.25rem;
        transition: all 0.2s ease-in-out;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 1.15rem;
        height: 1.15rem;
    }
    .segment-btn:hover .segment-count {
        background-color: #e4e4e7;
        color: #18181b;
    }
    .segment-btn.active .segment-count {
        background-color: rgba(255, 255, 255, 0.2) !important;
        color: #ffffff !important;
    }
</style>

@include('frontend.components.breadcrumb')

<section id="productsSection" class="pt-1 pb-12 sm:pt-2 sm:pb-16 bg-zinc-50">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        {{-- ================= HEADER ================= --}}
        <div class="mb-4 text-center max-w-2xl mx-auto fade-slide opacity-0 translate-y-4">

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
        <div class="mb-5 flex justify-center fade-slide opacity-0 translate-y-4">
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
        @php
            $productTypes = \App\Models\ProductType::where('is_active', true)->orderBy('sort_order')->get();
            $allCount = \App\Models\Product::where('is_active', true)->count();
            $counts = \App\Models\Product::where('is_active', true)
                ->select('product_type', \DB::raw('count(*) as total'))
                ->groupBy('product_type')
                ->pluck('total', 'product_type')
                ->toArray();
        @endphp
        <div class="mb-6 flex justify-center fade-slide opacity-0 translate-y-4">
            <div class="flex flex-wrap items-center justify-center gap-1.5 sm:gap-2.5 pb-2 pt-1 w-full max-w-6xl px-1">
                 <button type="button" data-segment="all" class="segment-btn active px-2.5 py-1 sm:px-3.5 sm:py-1.5 rounded-lg sm:rounded-xl border border-zinc-200 text-[10px] sm:text-xs font-semibold text-zinc-700 bg-white shadow-sm hover:border-zinc-300 hover:text-zinc-900 active:scale-95 transition-all duration-200 cursor-pointer">
                    Semua Produk <span class="segment-count">{{ $allCount }}</span>
                </button>
                @foreach($productTypes as $type)
                    @php
                        $count = $counts[$type->slug] ?? 0;
                    @endphp
                    <button type="button" data-segment="{{ $type->slug }}" class="segment-btn px-2.5 py-1 sm:px-3.5 sm:py-1.5 rounded-lg sm:rounded-xl border border-zinc-200 text-[10px] sm:text-xs font-semibold text-zinc-700 bg-white shadow-sm hover:border-zinc-300 hover:text-zinc-900 active:scale-95 transition-all duration-200 cursor-pointer">
                        {{ $type->name }} <span class="segment-count">{{ $count }}</span>
                    </button>
                @endforeach
            </div>
        </div>

        {{-- ================= GRID ================= --}}
        <div
            id="productGrid"
            class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5
                   gap-4 lg:gap-6
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

@extends('frontend.layouts.app')

@section(
'title',
strip_tags($title) . ' - ' . strip_tags(setting('site_name', 'mulaidigital.com'))
)

@section('content')

@include('frontend.components.breadcrumb')

<section class="py-16 sm:py-20 bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        {{-- ================= HEADER ================= --}}
        <div class="mb-14 text-center max-w-2xl mx-auto fade-slide opacity-0 translate-y-4">

            <span class="inline-flex items-center rounded-full
                           bg-primary-100
                           px-3 py-1
                           text-xs font-medium tracking-wide
                           text-primary-800">
                {!! setting('product_badge', 'Produk') !!}
            </span>

            <h1 class="mt-4 text-2xl sm:text-3xl font-bold tracking-tight
                       text-zinc-900">
                {!! setting('product_title', 'Produk Kami') !!}
            </h1>

            <p class="mt-3 text-sm sm:text-base
                       text-zinc-600">
                {!! setting(
                'product_subtitle',
                'Koleksi produk unggulan kami dengan kualitas terbaik dan harga kompetitif.'
                ) !!}
            </p>
        </div>

        {{-- ================= SEARCH ================= --}}
        <div class="mb-12 flex justify-center fade-slide opacity-0 translate-y-4">
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
            <article class="group flex flex-col overflow-hidden rounded-2xl border
                            border-zinc-200
                            bg-white
                            transition-all duration-300
                            hover:-translate-y-1 hover:shadow-lg
                            hover:border-primary-300">

                <a href="{{ route('products.show', $product->slug) }}"
                    class="relative block overflow-hidden rounded-t-2xl">
                    <img
                        src="{{ asset('storage/' . $product->thumbnail) }}"
                        alt="{{ $product->name }}"
                        class="h-40 sm:h-52 w-full object-cover
                               transition-transform duration-500 ease-out
                               group-hover:scale-110">
                </a>

                <div class="flex flex-col flex-1 p-5 sm:p-6">
                    <a href="{{ route('products.show', $product->slug) }}">
                        <h2 class="text-base sm:text-lg font-semibold
                                   text-zinc-900
                                   line-clamp-2">
                            {{ $product->name }}
                        </h2>
                    </a>

                    <p class="mt-3 text-sm
                               text-zinc-600
                               line-clamp-3">
                        {{ Str::limit(strip_tags($product->description), 140) }}
                    </p>

                    
                    {{-- HARGA --}}
                    <!-- <div class="mt-4 font-semibold">
                        @if ($product->sale_price)
                        <div class="flex flex-col sm:flex-row sm:items-baseline gap-1 sm:gap-2">
                            <span class="text-sm sm:text-base
                         text-primary-700
                         leading-tight">
                                Rp{{ number_format($product->sale_price) }}
                            </span>

                            <span class="text-xs sm:text-sm
                         line-through
                         text-zinc-400">
                                Rp{{ number_format($product->price) }}
                            </span>
                        </div>
                        @else
                        <span class="text-sm sm:text-base
                     text-zinc-900
                     leading-tight">
                            Rp{{ number_format($product->price) }}
                        </span>
                        @endif
                    </div> -->

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

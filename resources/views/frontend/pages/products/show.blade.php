@extends('frontend.layouts.app')

@section(
'title',
strip_tags($title) . ' - ' . strip_tags(setting('site_name', 'Herro Equipment Rentals'))
)

@section('content')

{{-- Swiper CDN for product detail slide page --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

{{-- ================= READING PROGRESS ================= --}}
<div
    id="readingProgress"
    class="fixed top-0 left-0 z-50 h-[3px] w-0 bg-primary-900 transition-all duration-300">
</div>

@include('frontend.components.breadcrumb', [
    'items' => [
        ['label' => 'Produk', 'url' => route('products.index')],
        ['label' => $product->name, 'url' => null]
    ]
])

<section class="pt-3 pb-12 sm:pt-5 sm:pb-16 bg-zinc-50 select-none">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-start">

            {{-- ================= IMAGES ================= --}}
            <div class="space-y-4 fade-slide opacity-0 translate-y-4">
                @if(is_array($product->images) && count($product->images))
                    @if(count($product->images) > 1)
                        {{-- Swiper Container --}}
                        <div class="swiper productDetailSwiper overflow-hidden rounded-[2rem] border border-zinc-200/80 shadow-xl aspect-square bg-zinc-50 relative group">
                            <div class="swiper-wrapper">
                                @foreach($product->images as $img)
                                    <div class="swiper-slide w-full h-full aspect-square flex items-center justify-center">
                                        <img
                                            src="{{ asset('storage/' . $img) }}"
                                            alt="{{ $product->name }}"
                                            loading="eager"
                                            class="w-full h-full object-cover">
                                    </div>
                                @endforeach
                            </div>
                            
                            {{-- Swiper Navigation Buttons --}}
                            <div class="swiper-button-next !text-white !h-9 !w-9 after:!text-[10px] bg-zinc-950/40 backdrop-blur-sm rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <div class="swiper-button-prev !text-white !h-9 !w-9 after:!text-[10px] bg-zinc-950/40 backdrop-blur-sm rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            
                            {{-- Swiper Pagination --}}
                            <div class="swiper-pagination !bottom-4"></div>
                        </div>
                    @else
                        {{-- Single Image --}}
                        <div class="overflow-hidden rounded-[2rem] border border-zinc-200/80 shadow-xl aspect-square bg-zinc-50">
                            <img
                                src="{{ asset('storage/' . $product->images[0]) }}"
                                alt="{{ $product->name }}"
                                class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                        </div>
                    @endif
                @endif
            </div>

            {{-- ================= INFO ================= --}}
            <div class="fade-slide opacity-0 translate-y-4">

                {{-- TAGLINE --}}
                @if($product->tagline)
                    <p class="text-xs sm:text-sm font-bold tracking-wider text-primary-900 uppercase">
                        {{ $product->tagline }}
                    </p>
                @endif

                {{-- TITLE --}}
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-zinc-955 mt-2 leading-tight">
                    {{ $product->name }}
                </h1>

                {{-- DESCRIPTION --}}
                @if($product->description)
                <article
                    id="productContent"
                    class="mt-6 prose prose-neutral max-w-none text-zinc-650 text-sm sm:text-base leading-relaxed">
                    {!! $product->description !!}
                </article>
                @endif

                {{-- SPECIFICATIONS GRID --}}
                <div class="mt-8 pt-6 border-t border-zinc-100">
                    <h3 class="text-xs font-bold tracking-wider text-zinc-400 uppercase">Spesifikasi Unit</h3>
                    <div class="mt-4 grid grid-cols-1 sm:grid-cols-3 gap-4">
                        
                        {{-- Energy Type --}}
                        <div class="flex items-center gap-3 bg-zinc-50 border border-zinc-200/60 rounded-2xl p-4 transition-all duration-300 hover:border-primary-400/50 hover:shadow-md hover:shadow-primary-900/5">
                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-primary-100/65 text-primary-900">
                                <x-heroicon-o-bolt class="h-5 w-5" />
                            </div>
                            <div class="min-w-0">
                                <p class="text-[10px] font-semibold text-zinc-400 uppercase tracking-wider">Tipe Energi</p>
                                <p class="text-xs sm:text-sm font-bold text-zinc-800 mt-0.5 truncate">{{ $product->energy_type ?: '-' }}</p>
                            </div>
                        </div>

                        {{-- Lift Height --}}
                        <div class="flex items-center gap-3 bg-zinc-50 border border-zinc-200/60 rounded-2xl p-4 transition-all duration-300 hover:border-primary-400/50 hover:shadow-md hover:shadow-primary-900/5">
                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-primary-100/65 text-primary-900">
                                <x-heroicon-o-arrows-up-down class="h-5 w-5" />
                            </div>
                            <div class="min-w-0">
                                <p class="text-[10px] font-semibold text-zinc-400 uppercase tracking-wider">Tinggi Angkat</p>
                                <p class="text-xs sm:text-sm font-bold text-zinc-800 mt-0.5 truncate">{{ $product->lift_height ?: '-' }}</p>
                            </div>
                        </div>

                        {{-- Load Capacity --}}
                        <div class="flex items-center gap-3 bg-zinc-50 border border-zinc-200/60 rounded-2xl p-4 transition-all duration-300 hover:border-primary-400/50 hover:shadow-md hover:shadow-primary-900/5">
                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-primary-100/65 text-primary-900">
                                <x-heroicon-o-archive-box class="h-5 w-5" />
                            </div>
                            <div class="min-w-0">
                                <p class="text-[10px] font-semibold text-zinc-400 uppercase tracking-wider">Kapasitas Beban</p>
                                <p class="text-xs sm:text-sm font-bold text-zinc-800 mt-0.5 truncate">{{ $product->load_capacity ?: '-' }}</p>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- ACTION BUTTON --}}
                <div class="mt-8 pt-6 border-t border-zinc-100">
                    @php
                        $waNumber = preg_replace('/[^0-9]/', '', setting('whatsapp_number', '6281234567890'));
                        $productMessage = rawurlencode("Halo Herro Equipment Rentals, saya tertarik untuk menyewa unit: " . $product->name . ".");
                        $waUrl = "https://wa.me/{$waNumber}?text={$productMessage}";
                    @endphp
                    <a href="{{ $waUrl }}" target="_blank"
                        class="relative group inline-flex items-center justify-center gap-3 w-full sm:w-auto rounded-2xl bg-green-600 text-white font-bold px-8 py-4 shadow-lg shadow-green-600/20 hover:bg-green-700 hover:shadow-xl hover:shadow-green-600/30 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 text-sm sm:text-base">
                        
                        {{-- Glow Backing --}}
                        <span class="absolute inset-0 rounded-2xl bg-green-500/10 blur-md opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                        
                        <svg class="h-5 w-5 fill-current flex-shrink-0" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.746.953 3.71 1.455 5.703 1.456h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                        </svg>
                        
                        <span class="relative z-10">{{ strip_tags(setting('product_cta', 'Hubungi via WhatsApp')) }}</span>
                    </a>
                </div>

                {{-- SHARE --}}
                <div class="mt-6 flex items-center gap-3 pt-4 border-t border-zinc-100">
                    <span class="text-xs font-semibold uppercase tracking-wider text-zinc-400">
                        {{ strip_tags(setting('product_share_label', 'Bagikan')) }} :
                    </span>

                    <a
                        href="https://wa.me/?text={{ urlencode($product->name . ' — ' . url()->current()) }}"
                        target="_blank"
                        class="share-inline-btn hover:text-green-600 hover:border-green-300">
                        <x-heroicon-o-chat-bubble-left-right class="w-4 h-4" />
                    </a>

                    <button
                        onclick="copyLink()"
                        class="share-inline-btn hover:text-primary-900 hover:border-primary-300">
                        <x-heroicon-o-link class="w-4 h-4" />
                    </button>
                </div>

            </div>
        </div>

        {{-- ================= FULL SPECIFICATIONS TABLE ================= --}}
        @if(!empty($product->specifications) && count($product->specifications) > 0)
        <div class="mt-12 bg-white rounded-3xl border border-zinc-200/80 p-6 sm:p-8 shadow-sm fade-slide opacity-0 translate-y-4">
            <h3 class="text-lg font-bold text-zinc-955 mb-6">Spesifikasi Lengkap</h3>
            <div class="overflow-hidden rounded-2xl border border-zinc-100">
                <table class="w-full text-sm text-left text-zinc-600">
                    <tbody class="divide-y divide-zinc-100">
                        @foreach($product->specifications as $spec)
                        <tr class="hover:bg-zinc-50/50 transition-colors">
                            <td class="py-3.5 px-5 font-semibold text-zinc-900 bg-zinc-50/50 w-1/3 border-r border-zinc-100">
                                {{ $spec['key'] }}
                            </td>
                            <td class="py-3.5 px-5 text-zinc-700 font-medium">
                                {{ $spec['value'] }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        {{-- ================= RELATED PRODUCTS ================= --}}
        @if($relatedProducts->count())
        <section class="mt-20 pt-16 border-t border-zinc-200/80">

            <div class="mb-8 flex items-end justify-between fade-slide opacity-0 translate-y-4">
                <div>
                    <h2 class="text-xl sm:text-2xl font-bold tracking-tight text-zinc-955">
                        Produk Terkait
                    </h2>
                    <p class="text-xs text-zinc-400 mt-1">Pilihan alat material handling lainnya</p>
                </div>

                <a
                    href="{{ route('products.index') }}"
                    class="text-sm font-bold text-primary-900 hover:text-primary-750 transition-colors">
                    Lihat Semua →
                </a>
            </div>

            {{-- Swiper Container --}}
            <div class="swiper relatedProductsSwiper overflow-hidden fade-slide opacity-0 translate-y-4 pb-8">
                <div class="swiper-wrapper">
                    @foreach($relatedProducts as $item)
                    <div class="swiper-slide h-auto">
                        <article class="group flex flex-col h-full rounded-2xl border border-zinc-200/70
                                        overflow-hidden bg-white
                                        hover:shadow-lg hover:border-primary-400/50
                                        transition-all duration-300">

                            <a href="{{ route('products.show', $item->slug) }}" class="block aspect-square w-full overflow-hidden bg-zinc-50 border-b border-zinc-100 flex items-center justify-center">
                                <img
                                    src="{{ asset('storage/' . ($item->thumbnail ?? '')) }}"
                                    alt="{{ $item->name }}"
                                    class="h-full w-full object-cover
                                           transition-transform duration-500
                                           group-hover:scale-105">
                            </a>

                            <div class="p-4 sm:p-5 flex flex-col flex-1">
                                <div class="flex-1">
                                    <a href="{{ route('products.show', $item->slug) }}">
                                        <h3 class="text-xs sm:text-sm font-bold text-zinc-955 line-clamp-2 transition-colors group-hover:text-primary-900 leading-snug">
                                            {{ $item->name }}
                                        </h3>
                                    </a>

                                    @if($item->tagline)
                                        <p class="mt-1.5 text-[10px] sm:text-xs text-zinc-500 font-semibold leading-relaxed">
                                            {{ $item->tagline }}
                                        </p>
                                    @endif
                                </div>
                                
                                <div class="mt-4 pt-3 border-t border-zinc-100">
                                    <a href="{{ route('products.show', $item->slug) }}" class="inline-flex items-center justify-center w-full rounded-xl bg-zinc-50 border border-zinc-200 text-zinc-800 py-2 text-[10px] sm:text-xs font-semibold transition-all duration-200 hover:bg-zinc-100">
                                        Detail Unit
                                    </a>
                                </div>
                            </div>
                        </article>
                    </div>
                    @endforeach
                </div>
                
                <!-- {{-- Swiper Pagination --}}
                <div class="swiper-pagination !bottom-0"></div> -->
            </div>

        </section>
        @endif

    </div>
</section>

{{-- ================= SCRIPT ================= --}}
<script>
    function copyLink() {
        navigator.clipboard.writeText(window.location.href)
            .then(() => {
                alert('Link berhasil disalin!');
            });
    }

    window.addEventListener("scroll", () => {
        const content = document.getElementById("productContent");
        const bar = document.getElementById("readingProgress");

        if (!content || !bar) return;

        const contentTop = content.offsetTop;
        const contentHeight = content.offsetHeight;
        const scrollPosition = window.scrollY + window.innerHeight;
        const windowHeight = window.innerHeight;

        let progress = 0;
        if (scrollPosition > contentTop) {
            progress = Math.min(
                ((scrollPosition - contentTop) / (contentHeight + windowHeight - 100)) * 100,
                100
            );
        }

        bar.style.width = progress + "%";
    });

    // Initialize Swiper
    document.addEventListener("DOMContentLoaded", () => {
        if (typeof Swiper !== 'undefined') {
            // Main product image swiper
            new Swiper('.productDetailSwiper', {
                loop: true,
                autoplay: {
                    delay: 4000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.productDetailSwiper .swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.productDetailSwiper .swiper-button-next',
                    prevEl: '.productDetailSwiper .swiper-button-prev',
                },
            });

            // Related products swiper
            new Swiper('.relatedProductsSwiper', {
                slidesPerView: 1.5,
                spaceBetween: 16,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.relatedProductsSwiper .swiper-pagination',
                    clickable: true,
                },
                breakpoints: {
                    640: {
                        slidesPerView: 2.2,
                        spaceBetween: 16,
                    },
                    768: {
                        slidesPerView: 3,
                        spaceBetween: 20,
                    },
                    1024: {
                        slidesPerView: 4,
                        spaceBetween: 24,
                    }
                }
            });
        }

        // Fade-slide animation
        const elements = document.querySelectorAll(".fade-slide");
        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.remove("opacity-0", "translate-y-4");
                    entry.target.classList.add("opacity-100", "translate-y-0");
                    entry.target.style.transition = "all 0.6s cubic-bezier(0.4, 0, 0.2, 1)";
                }
            });
        }, { threshold: 0.1, rootMargin: "0px 0px -20px 0px" });
        elements.forEach(el => observer.observe(el));
    });
</script>

{{-- ================= STYLE ================= --}}
<style>
    .share-inline-btn {
        @apply inline-flex items-center justify-center w-9 h-9 rounded-xl border border-zinc-200 text-zinc-500 hover:bg-zinc-100 transition;
    }
</style>

@endsection

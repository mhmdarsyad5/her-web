<section
    class="pt-1 pb-8 sm:pt-2 sm:pb-10 lg:pt-3 lg:pb-12 bg-gradient-to-b from-white via-zinc-50/30 to-white relative overflow-hidden">

    {{-- Glowing side light --}}
    <div class="absolute top-1/3 left-0 w-80 h-80 bg-primary-900/5 rounded-full blur-[100px] pointer-events-none"></div>

    <div class="mx-auto max-w-7xl px-6 sm:px-12 lg:px-20 relative z-10">

        {{-- ================= HEADER ================= --}}
        <div class="mb-2 sm:mb-3 lg:mb-4">

            {{-- BADGE --}}
            @if(setting('product_badge'))
                <div class="mb-6">
                    <span class="inline-flex items-center rounded-full
                                   bg-zinc-100 border border-zinc-200/40
                                   px-3.5 py-1
                                   text-xs font-semibold tracking-wide
                                   text-zinc-900">
                        {{ strip_tags(setting('product_badge')) }}
                    </span>
                </div>
            @endif

            {{-- TITLE + CTA --}}
            <div class="flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">
                <div class="max-w-2xl">
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl
                               font-extrabold tracking-tight leading-tight
                               text-zinc-950">
                        {{ strip_tags(setting('product_title', 'Produk Kami')) }}
                    </h2>

                    <p class="mt-4 text-sm sm:text-base lg:text-lg
                               leading-relaxed
                               text-zinc-600">
                        {{ strip_tags(
    setting(
        'product_subtitle',
        'Koleksi produk unggulan kami dengan kualitas terbaik dan harga kompetitif.'
    )
) }}
                    </p>
                </div>

                <a href="{{ route('products.index') }}" class="group inline-flex items-center gap-1.5
                          text-sm sm:text-base font-bold
                          text-primary-900
                          hover:text-primary-800
                          transition-colors">
                    {{ strip_tags(setting('product_view_all', 'Lihat semua')) }}
                    <x-heroicon-m-arrow-right class="h-4 w-4 transition-transform group-hover:translate-x-1" />
                </a>
            </div>
        </div>

        {{-- ================= PRODUCTS SLIDER ================= --}}
        <div class="relative fade-slide opacity-0 translate-y-4">
            <div class="swiper productSwiper !pt-4 !pb-14">
                <div class="swiper-wrapper">
                    @forelse ($products as $product)
                        <div class="swiper-slide flex">
                            <article class="group flex flex-col w-full overflow-hidden rounded-2xl border
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
                                <div class="flex flex-col flex-1 p-3 sm:p-5 relative">
                                    <div class="flex-1">
                                        <a href="{{ route('products.show', $product->slug) }}">
                                            <h3
                                                class="text-xs sm:text-base font-bold text-zinc-955 line-clamp-2 transition-colors group-hover:text-primary-900">
                                                {{ $product->name }}
                                            </h3>
                                        </a>

                                        {{-- Tagline --}}
                                        @if($product->tagline)
                                            <p class="mt-1 text-[10px] sm:text-sm text-zinc-600 font-semibold leading-relaxed">
                                                {{ $product->tagline }}
                                            </p>
                                        @endif
                                    </div>

                                    {{-- Specifications (Vertical Premium List with Icons) --}}
                                    <div
                                        class="mt-3 sm:mt-4 space-y-1.5 sm:space-y-2 bg-zinc-50/80 p-2 sm:p-2.5 rounded-lg sm:rounded-xl border border-zinc-100/80">
                                        {{-- Energy Spec --}}
                                        <div class="flex items-center justify-between text-[10px] sm:text-xs min-w-0">
                                            <div class="flex items-center gap-1.5 text-zinc-500">
                                                <svg class="h-3.5 w-3.5 sm:h-4 sm:w-4 text-zinc-400 flex-shrink-0" fill="none"
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
                                            class="flex items-center justify-between text-[10px] sm:text-xs min-w-0 border-t border-zinc-200/40 pt-2 sm:pt-2.5">
                                            <div class="flex items-center gap-1.5 text-zinc-500">
                                                <svg class="h-3.5 w-3.5 sm:h-4 sm:w-4 text-zinc-400 flex-shrink-0" fill="none"
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
                                            class="flex items-center justify-between text-[10px] sm:text-xs min-w-0 border-t border-zinc-200/40 pt-2 sm:pt-2.5">
                                            <div class="flex items-center gap-1.5 text-zinc-500">
                                                <svg class="h-3.5 w-3.5 sm:h-4 sm:w-4 text-zinc-400 flex-shrink-0" fill="none"
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
                                    <div class="mt-4 sm:mt-6 flex flex-col gap-1.5 sm:gap-2 pt-3 sm:pt-4 border-t border-zinc-100/80">
                                        @php
                                            $waNumber = preg_replace('/[^0-9]/', '', setting('whatsapp_number', '6281234567890'));
                                            $productMessage = rawurlencode("Halo, saya tertarik untuk menyewa unit " . $product->name . ".");
                                            $waUrl = "https://wa.me/{$waNumber}?text={$productMessage}";
                                        @endphp

                                        {{-- WhatsApp Button --}}
                                        <a href="{{ $waUrl }}" target="_blank"
                                            class="inline-flex items-center justify-center gap-1 sm:gap-1.5 rounded-lg sm:rounded-xl bg-green-600 hover:bg-green-700 text-white py-1.5 sm:py-2.5 px-2.5 sm:px-4 text-[10px] sm:text-sm font-bold transition-all duration-200">
                                            <svg class="h-3 w-3 sm:h-3.5 sm:w-3.5 fill-current flex-shrink-0" viewBox="0 0 24 24"
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
                                            class="inline-flex items-center justify-center gap-1 sm:gap-1.5 rounded-lg sm:rounded-xl text-white py-1.5 sm:py-2.5 px-2.5 sm:px-4 text-[10px] sm:text-sm font-bold transition-all duration-200 hover:opacity-90">
                                            Lihat Detail Unit
                                        </a>
                                    </div>
                                </div>
                            </article>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-20 w-full">
                            <p class="text-sm text-zinc-600">
                                Produk tidak ditemukan.
                            </p>
                        </div>
                    @endforelse
                </div>

                {{-- Custom Styling for Swiper Pagination --}}
                <style>
                    .productSwiper .swiper-pagination-bullet {
                        width: 8px;
                        height: 8px;
                        border-radius: 9999px;
                        background: #d4d4d8;
                        /* zinc-300 */
                        opacity: 0.8;
                        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                    }

                    .productSwiper .swiper-pagination-bullet-active {
                        background:
                            {{ setting('primary_color', '#ff7f00') }}
                            !important;
                        opacity: 1;
                        width: 24px;
                        /* Pill effect */
                        border-radius: 4px;
                    }

                    /* Force equal height for all swiper slides */
                    .productSwiper .swiper-slide {
                        height: auto !important;
                        display: flex;
                    }
                </style>

                {{-- Pagination dots & Custom navigation --}}
                @if($products->count() > 0)
                    <div
                        class="absolute bottom-0 left-0 right-0 flex items-center justify-between pointer-events-none z-20">
                        {{-- Dot Pagination --}}
                        <div class="product-pagination !static !w-auto pointer-events-auto"></div>

                        {{-- Arrows (Only show dynamic slide count controls) --}}
                        <div class="flex items-center gap-2 pointer-events-auto">
                            <button type="button"
                                class="product-prev flex h-10 w-10 items-center justify-center rounded-xl border border-zinc-200 bg-white text-zinc-600 hover:bg-zinc-50 hover:text-zinc-800 active:scale-95 transition-all">
                                <x-heroicon-o-chevron-left class="h-5 w-5" />
                            </button>
                            <button type="button"
                                class="product-next flex h-10 w-10 items-center justify-center rounded-xl border border-zinc-200 bg-white text-zinc-600 hover:bg-zinc-50 hover:text-zinc-800 active:scale-95 transition-all">
                                <x-heroicon-o-chevron-right class="h-5 w-5" />
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

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
<section class="py-16 sm:py-20 lg:py-24 bg-white">
    <div class="mx-auto max-w-7xl px-6 sm:px-12 lg:px-20">

        {{-- ================= HEADER ================= --}}
        <div class="mb-12 lg:mb-16">

            {{-- BADGE --}}
            <div class="mb-6">
                <span class="inline-flex items-center rounded-full
                               bg-primary-100
                               px-3 py-1.5
                               text-xs font-medium tracking-wide
                               text-primary-800">
                    {{ strip_tags(setting('product_badge', 'Produk Kami')) }}
                </span>
            </div>

            {{-- TITLE + CTA --}}
            <div class="flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">
                <div class="max-w-2xl">
                    <h2 class="text-xl sm:text-2xl lg:text-3xl
                               font-semibold tracking-tight leading-tight
                               text-zinc-900">
                        {{ strip_tags(setting('product_title', 'Produk Kami')) }}
                    </h2>

                    <p class="mt-4 text-sm sm:text-base
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

                <a href="{{ route('products.index') }}" {{-- Sesuaikan route jika berbeda --}} class="inline-flex items-center gap-2
                          text-sm sm:text-base font-medium
                          text-primary-700
                          hover:text-primary-900
                          transition-colors">
                    {{ strip_tags(setting('product_view_all', 'Lihat semua')) }}
                    <span aria-hidden="true">→</span>
                </a>
            </div>
        </div>

        {{-- ================= PRODUCTS GRID ================= --}}
        <div id="productGrid" class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3
                    gap-4 sm:gap-6 lg:gap-8
                    fade-slide opacity-0 translate-y-4">

            @forelse ($products as $product)
                <article class="group flex flex-col overflow-hidden rounded-2xl border
                                border-zinc-200
                                bg-white
                                transition-all duration-300
                                hover:shadow-lg hover:-translate-y-1">

                    <a href="{{ route('products.show', $product->slug) }}"
                        class="relative block overflow-hidden rounded-t-2xl">
                        <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}" class="h-40 sm:h-52 w-full object-cover
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
                            <div class="flex items-baseline gap-2">
                                <span class="text-base text-primary-700">
                                    Rp{{ number_format($product->sale_price) }}
                                </span>
                                <span class="text-sm line-through text-zinc-400">
                                    Rp{{ number_format($product->price) }}
                                </span>
                            </div>
                            @else
                            <span class="text-base text-zinc-900">
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
    </div>
</section>

{{-- ================= FADE ANIMATION (tetap sama) ================= --}}
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
@extends('frontend.layouts.app')

@section(
'title',
strip_tags($title) . ' - ' . strip_tags(setting('site_name', 'mulaidigital.com'))
)

@section('content')

{{-- ================= READING PROGRESS ================= --}}
<div
    id="readingProgress"
    class="fixed top-0 left-0 z-50 h-[3px] w-0 bg-primary-900 transition-all duration-300">
</div>

@include('frontend.components.breadcrumb')

<section class="py-16 sm:py-20 bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

            {{-- ================= IMAGES ================= --}}
            <div class="space-y-4">
                @if(is_array($product->images) && count($product->images))
                <div class="overflow-hidden rounded-2xl border border-zinc-200 shadow-md">
                    <div class="relative aspect-square sm:aspect-[4/5] lg:aspect-[3/4]">
                        <img
                            src="{{ asset('storage/' . $product->images[0]) }}"
                            alt="{{ $product->name }}"
                            class="absolute inset-0 h-full w-full object-cover
                   transition-transform duration-500
                   hover:scale-105">
                    </div>
                </div>

                @if(count($product->images) > 1)
                <div class="grid grid-cols-4 gap-3">
                    @foreach(array_slice($product->images, 1) as $img)
                    <div class="overflow-hidden rounded-xl border border-zinc-200">
                        <img
                            src="{{ asset('storage/' . $img) }}"
                            class="h-24 w-full object-cover transition-transform duration-300 hover:scale-110">
                    </div>
                    @endforeach
                </div>
                @endif
                @endif
            </div>

            {{-- ================= INFO ================= --}}
            <div>

                {{-- TITLE --}}
                <h1 class="text-2xl sm:text-3xl font-bold text-zinc-900">
                    {{ $product->name }}
                </h1>

                {{-- PRICE --}}
                <!-- <div class="mt-4 text-xl font-semibold">
                    @if($product->sale_price)
                    <span class="text-primary-700">
                        Rp{{ number_format($product->sale_price) }}
                    </span>
                    <span class="ml-3 text-base line-through text-zinc-400">
                        Rp{{ number_format($product->price) }}
                    </span>
                    @else
                    <span class="text-zinc-900">
                        Rp{{ number_format($product->price) }}
                    </span>
                    @endif
                </div> -->

                {{-- DESCRIPTION --}}
                @if($product->description)
                <article
                    id="productContent"
                    class="mt-6 prose prose-neutral max-w-none text-zinc-700">
                    {!! $product->description !!}
                </article>
                @endif

                {{-- ACTION --}}
                <div class="mt-8 flex flex-wrap gap-3">
                    <a
                        href="https://wa.me/{{ strip_tags(setting('whatsapp_number')) }}?text={{ urlencode('Halo, saya tertarik dengan produk: ' . $product->name) }}"
                        target="_blank"
                        class="inline-flex items-center gap-2 rounded-xl
                               bg-primary-900
                               px-6 py-3 text-sm font-semibold text-white
                               hover:bg-primary-800
                               shadow-sm
                               focus:outline-none focus:ring-2 focus:ring-primary-500/50
                               transition">
                        <x-heroicon-o-check-badge class="w-5 h-5" />
                        {{ strip_tags(setting('product_cta', 'Pesan via WhatsApp')) }}
                    </a>
                </div>

                {{-- SHARE --}}
                <div class="mt-8 flex items-center gap-3">
                    <span class="text-sm text-zinc-500">
                        {{ strip_tags(setting('product_share_label', 'Bagikan')) }} :
                    </span>

                    <a
                        href="https://wa.me/?text={{ urlencode($product->name . ' — ' . url()->current()) }}"
                        target="_blank"
                        class="share-inline-btn">
                        <x-heroicon-o-chat-bubble-bottom-center-text class="w-5 h-5" />
                    </a>

                    <button
                        onclick="copyLink()"
                        class="share-inline-btn">
                        <x-heroicon-o-clipboard-document-check class="w-5 h-5" />
                    </button>
                </div>

            </div>
        </div>

        {{-- ================= RELATED PRODUCTS ================= --}}
        @if($relatedProducts->count())
        <section class="mt-20 pt-20 border-t border-zinc-200">

            <div class="mb-10 flex items-center justify-between">
                <h2 class="text-xl sm:text-2xl font-bold text-zinc-900">
                    Produk Terkait
                </h2>

                <a
                    href="{{ route('products.index') }}"
                    class="text-sm font-medium text-primary-700
                           hover:text-primary-900 transition-colors">
                    Lihat Semua →
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $item)
                <article class="group rounded-2xl border border-zinc-200
                                overflow-hidden bg-white
                                hover:shadow-lg hover:border-primary-300
                                transition-all duration-300">

                    <a href="{{ route('products.show', $item->slug) }}">
                        <img
                            src="{{ asset('storage/' . ($item->thumbnail ?? '')) }}"
                            alt="{{ $item->name }}"
                            class="h-40 w-full object-cover
                                   transition-transform duration-500
                                   group-hover:scale-110">
                    </a>

                    <div class="p-4">
                        <h3 class="text-sm font-semibold text-zinc-900 line-clamp-2">
                            {{ $item->name }}
                        </h3>

                        <p class="mt-2 text-sm text-zinc-600 line-clamp-2">
                            {{ \Illuminate\Support\Str::limit(strip_tags($item->description), 80) }}
                        </p>
                    </div>
                </article>
                @endforeach
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
</script>

{{-- ================= STYLE ================= --}}
<style>
    .share-inline-btn {
        @apply inline-flex items-center justify-center w-10 h-10 rounded-lg border border-zinc-200 text-zinc-600 hover:bg-zinc-100 transition;
    }
</style>

@endsection

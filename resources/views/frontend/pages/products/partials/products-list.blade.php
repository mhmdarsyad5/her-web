{{-- LOADING --}}
@if ($loading ?? false)
@include('frontend.pages.products.partials.skeleton')

{{-- EMPTY --}}
@elseif ($products->isEmpty())
@include('frontend.pages.products.partials.empty')

{{-- DATA --}}
@else
@foreach ($products as $product)
<article
    class="group flex flex-col overflow-hidden rounded-2xl border
            border-neutral-200
            bg-white
            transition-all duration-300
            hover:-translate-y-1 hover:shadow-md">

    {{-- THUMBNAIL --}}
    <a
        href="{{ route('products.show', $product->slug) }}"
        class="relative block overflow-hidden">

        <img
            src="{{ asset('storage/' . $product->thumbnail) }}"
            alt="{{ $product->name }}"
            class="h-52 w-full object-cover
                    transition-transform duration-300
                    group-hover:scale-105">
    </a>

    {{-- CONTENT --}}
    <div class="flex flex-col flex-1 p-5 sm:p-6">

        <a href="{{ route('products.show', $product->slug) }}">
            <h2
                class="text-base sm:text-lg font-semibold
                        text-neutral-900
                        line-clamp-2">
                {{ $product->name }}
            </h2>
        </a>

        <p
            class="mt-3 text-sm
                    text-neutral-600
                    line-clamp-3">
            {{ Str::limit(strip_tags($product->description), 140) }}
        </p>

        <div class="mt-4 font-semibold text-neutral-900">
            @if ($product->sale_price)
            <span>Rp{{ number_format($product->sale_price) }}</span>
            <span class="ml-2 text-sm line-through text-neutral-400">
                Rp{{ number_format($product->price) }}
            </span>
            @else
            Rp{{ number_format($product->price) }}
            @endif
        </div>
    </div>
</article>
@endforeach
@endif

{{-- LOADING SKELETON --}}
@if ($loading ?? false)
@include('frontend.pages.pages.partials.skeleton')

@elseif ($pages->isEmpty())
@include('frontend.pages.pages.partials.empty')

@else
@foreach ($pages as $page)
<article
    class="group flex flex-col overflow-hidden rounded-2xl border border-zinc-200 bg-white transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:border-primary-900/30 shadow-sm">

    {{-- THUMBNAIL --}}
    <a href="{{ route('pages.show', $page->slug) }}"
        class="relative block overflow-hidden">

        @if($page->category)
        <span class="absolute top-3 left-3 z-10 inline-flex items-center rounded bg-primary-900 px-2.5 py-0.5 text-[10px] font-bold text-white shadow-sm tracking-wider uppercase">
            {{ $page->category->name }}
        </span>
        @endif

        <img
            src="{{ asset('storage/' . $page->thumbnail) }}"
            alt="{{ $page->title }}"
            class="h-36 sm:h-48 md:h-52 lg:h-56 w-full object-cover transition-transform duration-500 group-hover:scale-105">
    </a>

    {{-- CONTENT --}}
    <div class="flex flex-col flex-1 p-4 sm:p-5">

        <a href="{{ route('pages.show', $page->slug) }}">
            <h2 class="text-base sm:text-lg font-bold leading-snug text-zinc-900 transition-colors group-hover:text-primary-900 line-clamp-2 mb-1.5">
                {{ $page->title }}
            </h2>
        </a>

        <p class="mt-1 text-xs sm:text-sm leading-relaxed text-zinc-500 mb-3">
            {{ $page->excerpt ? $page->excerpt : Str::limit(strip_tags($page->content), 120) }}
        </p>
        
        <div class="mt-auto pt-3 border-t border-zinc-100">
            <a href="{{ route('pages.show', $page->slug) }}" class="flex items-center justify-between text-[11px] sm:text-xs font-bold text-zinc-400 hover:text-primary-900 group-hover:text-primary-900 transition-colors">
                <span>Baca Selengkapnya</span>
                <x-heroicon-o-chevron-right class="h-3.5 w-3.5 transform transition-transform group-hover:translate-x-0.5" />
            </a>
        </div>

    </div>
</article>
@endforeach
@endif

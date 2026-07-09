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

        @if($page->publish_at)
        <span
            class="absolute top-3 right-3 z-10 inline-flex items-center rounded-md px-2 py-0.5 text-[10px] font-medium backdrop-blur bg-white/90 text-zinc-700 border border-zinc-200/70 shadow-sm">
            {{ \Carbon\Carbon::parse($page->publish_at)->translatedFormat('d M Y') }}
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

        <p class="mt-1 text-xs sm:text-sm leading-relaxed text-zinc-500 line-clamp-3 mb-3">
            {{ $page->excerpt ? Str::limit($page->excerpt, 100) : Str::limit(strip_tags($page->content), 100) }}
        </p>
        
        <div class="mt-auto pt-3 border-t border-zinc-100 flex flex-col gap-3">
            @if($page->tags->count() > 0)
            <div class="flex flex-wrap gap-1.5">
                @foreach($page->tags as $tag)
                <span class="text-[9px] sm:text-[10px] font-semibold text-zinc-500 bg-zinc-50 px-2 py-0.5 rounded border border-zinc-200/40">
                    #{{ $tag->name }}
                </span>
                @endforeach
            </div>
            @endif

            <a href="{{ route('pages.show', $page->slug) }}" class="flex items-center justify-between text-[11px] sm:text-xs font-bold text-zinc-400 hover:text-primary-900 group-hover:text-primary-900 transition-colors pt-2.5 border-t border-zinc-100/60">
                <span>Baca Selengkapnya</span>
                <x-heroicon-o-chevron-right class="h-3.5 w-3.5 transform transition-transform group-hover:translate-x-0.5" />
            </a>
        </div>

    </div>
</article>
@endforeach
@endif

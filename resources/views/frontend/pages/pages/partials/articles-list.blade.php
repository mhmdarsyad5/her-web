{{-- LOADING SKELETON --}}
@if ($loading ?? false)
@include('frontend.pages.pages.partials.skeleton')

@elseif ($pages->isEmpty())
@include('frontend.pages.pages.partials.empty')

@else
@foreach ($pages as $page)
<article
    class="
                group flex flex-col overflow-hidden
                rounded-2xl border
                border-neutral-200
                bg-white
                transition-all duration-300
                hover:-translate-y-1 hover:shadow-md
                focus-within:ring-2 focus-within:ring-neutral-400/40
            ">

    {{-- THUMBNAIL --}}
    <a href="{{ route('pages.show', $page->slug) }}"
        class="relative block overflow-hidden">

        @if($page->category)
        <span class="absolute top-3 left-3 z-10 inline-flex items-center rounded bg-primary-500 px-2 py-1 text-[10px] sm:text-[11px] font-bold text-white shadow-sm tracking-wider uppercase">
            {{ $page->category->name }}
        </span>
        @endif

        @if($page->publish_at)
        <span
            class="
                            absolute top-3 right-3 z-10
                            inline-flex items-center
                            rounded-md
                            px-2.5 py-1
                            text-[11px] sm:text-xs
                            font-medium
                            backdrop-blur
                            bg-white/90
                            text-zinc-700
                            border border-zinc-200/70
                            shadow-sm
                        ">
            {{ \Carbon\Carbon::parse($page->publish_at)->translatedFormat('d M Y') }}
        </span>
        @endif

        <img
            src="{{ asset('storage/' . $page->thumbnail) }}"
            alt="{{ $page->title }}"
            class="
                        h-52 w-full object-cover
                        transition-transform duration-300
                        group-hover:scale-105
                    ">
    </a>

    {{-- CONTENT --}}
    <div class="flex flex-col flex-1 p-5 sm:p-6">

        <a href="{{ route('pages.show', $page->slug) }}">
            <h2
                class="
                            text-base sm:text-lg
                            font-semibold leading-snug
                            text-neutral-900
                            transition-colors
                            group-hover:text-neutral-700
                            line-clamp-2
                        ">
                {{ $page->title }}
            </h2>
        </a>

        <p
            class="
                        mt-3
                        text-sm leading-relaxed
                        text-neutral-600
                        line-clamp-3
                        mb-4
                    ">
            {{ Str::limit(strip_tags($page->content), 120) }}
        </p>
        
        <div class="mt-auto pt-4 border-t border-zinc-100 flex flex-wrap gap-2">
            @foreach($page->tags as $tag)
            <span class="text-[10px] sm:text-xs font-medium text-zinc-500 bg-zinc-100 px-2 py-1 rounded">
                #{{ $tag->name }}
            </span>
            @endforeach
        </div>

    </div>
</article>
@endforeach
@endif

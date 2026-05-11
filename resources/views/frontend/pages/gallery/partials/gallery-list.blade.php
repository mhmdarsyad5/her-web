{{-- LOADING SKELETON --}}
@if ($loading ?? false)
@include('frontend.pages.gallery.partials.skeleton')

{{-- EMPTY STATE --}}
@elseif ($galleries->isEmpty())
@include('frontend.pages.gallery.partials.empty')

@else

@foreach ($galleries as $gallery)
<article
    class="
        group overflow-hidden rounded-2xl border
        border-neutral-200
        bg-white
        transition-all duration-300
        hover:-translate-y-1 hover:shadow-md
    ">

    {{-- THUMBNAIL --}}
    <a
        href="{{ route('galleries.show', $gallery) }}"
        class="relative block aspect-[4/3] overflow-hidden
               bg-neutral-100">

        <img
            src="{{ asset('storage/' . $gallery->thumbnail) }}"
            alt="{{ $gallery->title }}"
            loading="lazy"
            class="
                h-full w-full object-cover
                transition-transform duration-500
                group-hover:scale-105
            ">
    </a>

    {{-- CONTENT --}}
    <div class="p-5 sm:p-6 flex flex-col h-full">

        {{-- TITLE --}}
        <a href="{{ route('galleries.show', $gallery) }}">
            <h2
                class="
                    text-sm sm:text-base lg:text-lg
                    font-semibold leading-snug
                    text-neutral-900
                    line-clamp-2
                    transition-colors
                    group-hover:text-neutral-700
                ">
                {{ $gallery->title }}
            </h2>
        </a>

        {{-- DESCRIPTION --}}
        @if ($gallery->description)
        <p
            class="
                mt-2 text-sm
                text-neutral-600
                leading-relaxed
                line-clamp-3
            ">
            {{ Str::limit($gallery->description, 120) }}
        </p>
        @endif

        {{-- TAGS --}}
        {{-- ================= TAGS ================= --}}
        @php
        $tags = $gallery->tags;

        if (is_string($tags)) {
        $tags = json_decode($tags, true) ?? [];
        }

        if (!is_array($tags)) {
        $tags = [];
        }
        @endphp

        @if (!empty($tags))
        <div class="mt-4 flex flex-wrap gap-2">
            @foreach ($tags as $tag)
            <span
                class="
                inline-flex items-center
                rounded-md border
                border-neutral-200
                px-2 py-0.5
                text-xs font-medium
                text-neutral-700
                bg-neutral-50
            ">
                {{ $tag }}
            </span>
            @endforeach
        </div>
        @endif

    </div>

</article>
@endforeach

@endif

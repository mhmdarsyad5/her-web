@extends('frontend.layouts.app')

@section('title', 'Galleries - ' . strip_tags(setting('site_name', 'mulaidigital.com')))

@section('content')

@include('frontend.components.breadcrumb', [
'items' => [
[
'label' => 'Gallery',
'url' => route('galleries.index'),
],
[
'label' => $gallery->title,
'url' => null,
],
],
])

<section class="py-16 sm:py-24 bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        {{-- ================= MAIN CONTENT ================= --}}
        <div class="max-w-4xl mx-auto">

            {{-- TITLE --}}
            <h1 class="text-3xl font-bold tracking-tight text-zinc-900 mb-4">
                {{ $gallery->title }}
            </h1>

            {{-- DESCRIPTION --}}
            @if ($gallery->description)
            <p class="text-zinc-600 mb-8 text-base leading-relaxed">
                {{ $gallery->description }}
            </p>
            @endif

            {{-- COVER THUMBNAIL --}}
            @if ($gallery->thumbnail)
            <div class="mb-10 overflow-hidden rounded-2xl border border-zinc-200 shadow-lg">
                <img
                    src="{{ asset('storage/' . $gallery->thumbnail) }}"
                    alt="{{ $gallery->title }}"
                    class="w-full h-auto object-cover transition-transform duration-700 hover:scale-105">
            </div>
            @endif


            {{-- ================= GALLERY IMAGES ================= --}}
            @if ($gallery->images && count($gallery->images))
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 lg:gap-6">

                @foreach ($gallery->images as $image)
                <a href="{{ asset('storage/' . $image) }}"
                    class="group overflow-hidden rounded-xl border border-zinc-200
                          bg-white
                          hover:border-primary-300
                          hover:shadow-lg
                          transition-all duration-500"
                    data-lightbox="gallery">

                    <img
                        src="{{ asset('storage/' . $image) }}"
                        alt="{{ $gallery->title }}"
                        class="w-full h-48 object-cover
                               transition-transform duration-700
                               group-hover:scale-110">
                </a>
                @endforeach

            </div>
            @endif


            {{-- BACK BUTTON --}}
            <div class="mt-14 mb-10">
                <a
                    href="{{ route('galleries.index') }}"
                    class="inline-flex items-center gap-2 text-sm font-medium
                           text-primary-700
                           hover:text-primary-900
                           transition-colors">
                    ← {{ strip_tags(setting('gallery_back_label', 'Kembali ke Galeri')) }}
                </a>
            </div>

        </div>

        {{-- ================= RELATED GALLERIES ================= --}}
        @if(isset($relatedGalleries) && $relatedGalleries->count())
        <div class="max-w-6xl mx-auto mt-20 pt-20 border-t border-zinc-200">

            <div class="mb-10 flex items-center justify-between">
                <h2 class="text-2xl font-bold tracking-tight text-zinc-900">
                    Galeri Terkait
                </h2>

                <a href="{{ route('galleries.index') }}"
                    class="text-sm font-medium text-primary-700
                          hover:text-primary-900 transition-colors">
                    Lihat Semua →
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                @foreach ($relatedGalleries as $item)
                <a href="{{ route('galleries.show', $item->id) }}"
                    class="group rounded-xl border border-zinc-200
                          bg-white overflow-hidden
                          hover:border-primary-300
                          hover:shadow-lg
                          transition-all duration-300">

                    @if ($item->thumbnail)
                    <div class="overflow-hidden">
                        <img
                            src="{{ asset('storage/' . $item->thumbnail) }}"
                            alt="{{ $item->title }}"
                            class="w-full h-40 object-cover
                                   transition-transform duration-700
                                   group-hover:scale-110">
                    </div>
                    @endif

                    <div class="p-5">
                        <h3 class="text-base font-semibold text-zinc-900
                                   group-hover:text-primary-700
                                   transition-colors line-clamp-2">
                            {{ $item->title }}
                        </h3>

                        @if ($item->description)
                        <p class="mt-2 text-sm text-zinc-600 line-clamp-2">
                            {{ Str::limit($item->description, 80) }}
                        </p>
                        @endif
                    </div>
                </a>
                @endforeach

            </div>
        </div>
        @endif

    </div>
</section>

@endsection

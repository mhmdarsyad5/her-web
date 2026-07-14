@extends('frontend.layouts.app')

@section('title', $seoTitle)
@section('description', $metaDescription)
@section('keywords', $metaKeywords)

@section('content')

@include('frontend.components.breadcrumb', [
    'items' => [
        ['label' => 'Blog', 'url' => route('pages.index')],
        ['label' => 'Tag: #' . $tag->name, 'url' => null]
    ]
])

<section class="pt-1 pb-12 sm:pt-2 sm:pb-16 bg-zinc-50">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        {{-- ================= HEADER ================= --}}
        <div class="mb-10 text-center max-w-2xl mx-auto fade-slide opacity-0 translate-y-4" style="animation: fadeUp 0.6s ease-out forwards;">
            <span class="inline-flex items-center rounded-full bg-zinc-150 border border-zinc-200/40 px-3.5 py-1 text-xs font-semibold tracking-wide text-zinc-900">
                Tag Artikel
            </span>
            <h1 class="mt-3 text-3xl sm:text-4xl font-extrabold tracking-tight text-zinc-900">
                #{{ $tag->name }}
            </h1>
            <p class="mt-2.5 text-sm sm:text-base text-zinc-500">
                Menampilkan kumpulan artikel dan panduan terbaru yang berkaitan dengan topik #{{ $tag->name }}.
            </p>
        </div>

        {{-- ================= GRID ================= --}}
        @if($pages->isEmpty())
            <div class="flex flex-col items-center justify-center py-12">
                @include('frontend.pages.pages.partials.empty')
            </div>
        @else
            <div id="articlesGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-8 fade-slide opacity-0 translate-y-4" style="animation: fadeUp 0.6s ease-out forwards; animation-delay: 0.15s;">
                @include('frontend.pages.pages.partials.articles-list')
            </div>

            {{-- ================= PAGINATION ================= --}}
            @if($pages->hasPages())
                <div class="mt-14 flex justify-center fade-slide opacity-0 translate-y-4" style="animation: fadeUp 0.6s ease-out forwards; animation-delay: 0.3s;">
                    {{ $pages->links('pagination::tailwind') }}
                </div>
            @endif
        @endif

    </div>
</section>

@endsection

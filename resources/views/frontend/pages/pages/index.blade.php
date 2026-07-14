@extends('frontend.layouts.app')

@section(
'title',
strip_tags($title) . ' - ' . strip_tags(setting('site_name', 'Herro Equipment Rentals'))
)

@section('description', 'Baca artikel terbaru, tips operasional alat berat, panduan industri, dan berita terbaru dari Herro Equipment Rentals.')

@section('content')

{{-- Breadcrumb --}}
@include('frontend.components.breadcrumb')

<section class="pt-1 pb-12 sm:pt-2 sm:pb-16 bg-zinc-50">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        {{-- ================= HEADER ================= --}}
        <div class="mb-6 text-center max-w-2xl mx-auto fade-slide opacity-0 translate-y-4">

            {{-- BADGE --}}
            @if(setting('blog_badge'))
                <span class="inline-flex items-center rounded-full
                               bg-zinc-150 border border-zinc-200/40
                               px-3.5 py-1
                               text-xs font-semibold tracking-wide
                               text-zinc-900">
                    {{ strip_tags(setting('blog_badge')) }}
                </span>
            @endif

            <h1 class="mt-3
                       text-3xl sm:text-4xl
                       font-extrabold tracking-tight
                       text-zinc-900">
                {!! setting('blog_title', 'Blog Terbaru') !!}
            </h1>

            {{-- SUBTITLE --}}
            <p class="mt-2.5
                       text-sm sm:text-base
                       text-zinc-650">
                {!! setting(
                'blog_subtitle',
                'Update terbaru tentang teknologi, inovasi digital, dan perjalanan startup.'
                ) !!}
            </p>
        </div>

        {{-- ================= CATEGORY PILLS ================= --}}
        @if($categories->count() > 0)
        <div class="mb-6 flex justify-center fade-slide opacity-0 translate-y-4">
            <div class="flex items-center gap-2 overflow-x-auto pb-3 w-full max-w-4xl px-4 no-scrollbar" style="scrollbar-width: none;">
                <button type="button" class="category-pill active flex-shrink-0 px-5 py-1.5 rounded-full text-xs font-semibold border whitespace-nowrap transition-colors" data-slug="all">
                    Semua Artikel <span class="category-count">{{ $categories->sum('pages_count') }}</span>
                </button>
                @foreach($categories as $cat)
                <button type="button" class="category-pill flex-shrink-0 px-5 py-1.5 rounded-full text-xs font-semibold border whitespace-nowrap transition-colors" data-slug="{{ $cat->slug }}">
                    {{ ucwords($cat->name) }} <span class="category-count">{{ $cat->pages_count }}</span>
                </button>
                @endforeach
            </div>
        </div>

        <style>
            .no-scrollbar::-webkit-scrollbar {
                display: none;
            }
            .category-pill {
                background-color: #ffffff;
                color: #52525b;
                border-color: #e4e4e7;
                display: inline-flex;
                align-items: center;
            }
            .category-pill:hover {
                background-color: #f4f4f5;
                color: #18181b;
                border-color: #d4d4d8;
            }
            .category-pill.active {
                background-color: #18181b !important;
                color: #ffffff !important;
                border-color: #18181b !important;
                box-shadow: none !important;
            }
            .category-count {
                background-color: #f4f4f5;
                color: #71717a;
                border-radius: 9999px;
                padding: 0.125rem 0.375rem;
                font-size: 10px;
                font-weight: 700;
                margin-left: 0.375rem;
                transition: all 0.2s ease-in-out;
            }
            .category-pill:hover .category-count {
                background-color: #e4e4e7;
                color: #18181b;
            }
            .category-pill.active .category-count {
                background-color: rgba(255, 255, 255, 0.15) !important;
                color: #ffffff !important;
            }
        </style>
        @endif

        {{-- ================= SEARCH ================= --}}
        <div class="mb-8 flex justify-center fade-slide opacity-0 translate-y-4">
            <div class="relative w-full max-w-md">
                <input
                    type="text"
                    id="searchInput"
                    placeholder="{{ strip_tags(setting('blog_search_placeholder', 'Cari artikel...')) }}"
                    class="w-full rounded-xl border
                           border-zinc-300
                           bg-white
                           px-4 py-3 pl-10
                           text-sm sm:text-base
                           text-zinc-900
                           placeholder:text-zinc-400
                           focus:outline-none
                           focus:ring-2 focus:ring-primary-500/30
                           transition">

                <x-heroicon-o-magnifying-glass
                    class="absolute left-3 top-3.5 h-5 w-5
                           text-zinc-500" />
            </div>
        </div>

        {{-- ================= GRID ================= --}}
        <div
            id="articlesGrid"
            class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3
                   gap-4 sm:gap-6 lg:gap-8
                   fade-slide opacity-0 translate-y-4">

            @include('frontend.pages.pages.partials.articles-list')
        </div>

        {{-- ================= PAGINATION ================= --}}
        @if($pages->hasPages())
        @php
            $currentPage = $pages->currentPage();
            $lastPage = $pages->lastPage();
            $startPage = max(1, $currentPage - 2);
            $endPage = min($lastPage, $currentPage + 2);
        @endphp
        <div class="mt-14 fade-slide opacity-0 translate-y-4">
            <div class="flex flex-col items-center gap-4">
                <nav class="inline-flex items-center flex-wrap gap-2 rounded-full border border-zinc-200 bg-white px-2 py-1 shadow-sm" aria-label="Pagination">
                    <a href="{{ $pages->url(1) }}"
                        class="inline-flex items-center rounded-full px-3 py-2 text-sm font-medium text-zinc-600 transition hover:bg-zinc-100 hover:text-zinc-900">
                        First
                    </a>

                    <a href="{{ $pages->previousPageUrl() ?? '#' }}"
                        class="inline-flex items-center rounded-full px-3 py-2 text-sm font-medium {{ $pages->onFirstPage() ? 'cursor-not-allowed text-zinc-400' : 'text-zinc-600 hover:bg-zinc-100 hover:text-zinc-900' }}"
                        aria-disabled="{{ $pages->onFirstPage() ? 'true' : 'false' }}">
                        Prev
                    </a>

                    @if($startPage > 1)
                        <span class="inline-flex h-10 min-w-[2.5rem] items-center justify-center rounded-full px-3 text-sm text-zinc-500">…</span>
                    @endif

                    @for($page = $startPage; $page <= $endPage; $page++)
                        <a href="{{ $pages->url($page) }}"
                            class="inline-flex h-10 min-w-[2.5rem] items-center justify-center rounded-full px-3 text-sm font-medium transition {{ $page === $currentPage ? 'bg-primary-900 text-white shadow' : 'text-zinc-600 hover:bg-zinc-100 hover:text-zinc-900' }}">
                            {{ $page }}
                        </a>
                    @endfor

                    @if($endPage < $lastPage)
                        <span class="inline-flex h-10 min-w-[2.5rem] items-center justify-center rounded-full px-3 text-sm text-zinc-500">…</span>
                        <a href="{{ $pages->url($lastPage) }}"
                            class="inline-flex h-10 min-w-[2.5rem] items-center justify-center rounded-full px-3 text-sm font-medium text-zinc-600 hover:bg-zinc-100 hover:text-zinc-900">
                            {{ $lastPage }}
                        </a>
                    @endif

                    <a href="{{ $pages->nextPageUrl() ?? '#' }}"
                        class="inline-flex items-center rounded-full px-3 py-2 text-sm font-medium {{ !$pages->hasMorePages() ? 'cursor-not-allowed text-zinc-400' : 'text-zinc-600 hover:bg-zinc-100 hover:text-zinc-900' }}"
                        aria-disabled="{{ !$pages->hasMorePages() ? 'true' : 'false' }}">
                        Next
                    </a>
                </nav>

                <form action="{{ request()->url() }}" method="GET" class="flex flex-wrap items-center gap-2">
                    @foreach(request()->except('page') as $name => $value)
                        @if(is_array($value))
                            @foreach($value as $item)
                                <input type="hidden" name="{{ $name }}[]" value="{{ $item }}">
                            @endforeach
                        @else
                            <input type="hidden" name="{{ $name }}" value="{{ $value }}">
                        @endif
                    @endforeach

                    <!-- <label for="gotoPage" class="text-sm font-medium text-zinc-700">Go to page</label>
                    <input
                        id="gotoPage"
                        type="number"
                        name="page"
                        min="1"
                        max="{{ $lastPage }}"
                        value="{{ $currentPage }}"
                        class="w-20 rounded-full border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/20"
                    />
                    <button type="submit"
                        class="inline-flex items-center justify-center rounded-full bg-primary-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-primary-800">
                        Go
                    </button> -->
                </form>
            </div>
        </div>
        @endif

    </div>
</section>

@endsection

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

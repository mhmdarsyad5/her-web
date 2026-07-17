@extends('frontend.layouts.app')

@section('title', ($page->seo_title ?: strip_tags($title)) . ' - ' . strip_tags(setting('site_name', config('app.name'))))

@section('description', $page->meta_description ?: ($page->excerpt ? strip_tags($page->excerpt) : Str::limit(strip_tags($page->content), 155)))

@if(!empty($page->meta_keywords))
@section('keywords', $page->meta_keywords)
@endif

@if($page->thumbnail)
@section('og_image', asset('storage/' . $page->thumbnail))
@endif

@push('head')
<meta property="og:type"       content="article" />
@if($page->publish_at)
<meta property="article:published_time" content="{{ \Carbon\Carbon::parse($page->publish_at)->toIso8601String() }}" />
@endif
<style>
    #articleContent {
        color: #3f3f46; /* text-zinc-700 */
        font-size: 0.95rem; /* compact and readable */
        line-height: 1.7; 
    }

    #articleContent p {
        margin-bottom: 1.25rem;
        text-align: justify;
        color: #4b5563; /* text-zinc-650 */
    }

    #articleContent h2 {
        font-size: 1.5rem; /* smaller, tidier */
        font-weight: 800; /* extrabold */
        color: #09090b; /* text-zinc-950 */
        margin-top: 2rem;
        margin-bottom: 0.875rem;
        line-height: 1.3;
        letter-spacing: -0.02em;
    }

    #articleContent h3 {
        font-size: 1.25rem;
        font-weight: 700; /* bold */
        color: #18181b; /* text-zinc-900 */
        margin-top: 1.75rem;
        margin-bottom: 0.75rem;
        line-height: 1.35;
    }

    #articleContent a {
        color: #F5A21C; /* brand primary color */
        font-weight: 600;
        text-decoration: underline;
        text-decoration-color: rgba(245, 162, 28, 0.3);
        text-underline-offset: 3px;
        transition: all 0.2s ease-in-out;
    }

    #articleContent a:hover {
        color: #d97706; /* slightly darker amber on hover */
        text-decoration-color: rgba(217, 119, 6, 0.8);
    }

    #articleContent blockquote {
        border-left: 4px solid #F5A21C;
        background-color: rgba(245, 162, 28, 0.04);
        border-top-right-radius: 0.5rem;
        border-bottom-right-radius: 0.5rem;
        padding: 1rem 1.25rem;
        margin: 1.5rem 0;
        font-style: italic;
        color: #4b5563;
    }

    #articleContent ul {
        list-style-type: disc;
        margin: 1.25rem 0;
        padding-left: 1.25rem;
    }

    #articleContent ol {
        list-style-type: decimal;
        margin: 1.25rem 0;
        padding-left: 1.25rem;
    }

    #articleContent li {
        margin-bottom: 0.625rem;
        line-height: 1.7;
        color: #4b5563;
    }

    #articleContent img {
        border-radius: 0.75rem;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.07);
        margin: 1.5rem auto;
        display: block;
        max-width: 100%;
        height: auto;
    }

    #articleContent strong {
        color: #09090b;
        font-weight: 700;
    }

    #articleContent code {
        background-color: #f4f4f5;
        color: #27272a;
        padding: 0.125rem 0.25rem;
        border-radius: 0.25rem;
        font-size: 0.875em;
        font-family: monospace;
    }

    /* BACA JUGA (RELATED ARTICLES) STYLING */
    #articleContent .baca-juga-box {
        border-left: 4px solid #1e3a8a !important; /* deep news-blue line */
        background-color: transparent !important;
        border-top-right-radius: 0 !important;
        border-bottom-right-radius: 0 !important;
        padding: 0.25rem 0 0.25rem 1.25rem !important;
        margin: 1.75rem 0 !important;
        font-style: normal !important;
    }

    #articleContent .baca-juga-box strong,
    #articleContent .baca-juga-box b {
        display: block;
        font-size: 0.9rem;
        font-weight: 700;
        color: #18181b;
        margin-bottom: 0.25rem;
    }

    #articleContent .baca-juga-box a {
        font-size: 1.05rem;
        font-weight: 700;
        color: #1e3a8a !important; /* deep news-blue link */
        text-decoration: none !important;
        transition: color 0.15s ease-in-out;
    }

    #articleContent .baca-juga-box a:hover {
        color: #2563eb !important; /* bright blue on hover */
        text-decoration: underline !important;
    }

    /* Inline TOC hanya tampil di mobile/tablet — desktop sudah ada sidebar TOC */
    @media (min-width: 1024px) {
        #inline-toc { display: none !important; }
    }

    /* Force top offset for sticky mobile TOC bar to work on VPS (fixes missing top-20 utility) */
    #mobile-toc-bar {
        top: 80px !important;
    }
    #mobile-toc-bar > div {
        background-color: rgba(255, 255, 255, 0.8) !important;
        backdrop-filter: blur(12px) !important;
        -webkit-backdrop-filter: blur(12px) !important;
    }
</style>
@endpush

@section('content')



@include('frontend.components.breadcrumb', [
    'items' => [
        ['label' => 'Blog', 'url' => route('pages.index')],
        ['label' => $page->title, 'url' => null]
    ]
])

{{-- ================= MOBILE STICKY TOC BAR (mobile/tablet only) ================= --}}
<div id="mobile-toc-bar" class="lg:hidden sticky top-20 z-40 hidden">
    <div class="bg-white/90 backdrop-blur-md border-b border-zinc-200/80 shadow-sm">
        <div class="mx-auto max-w-7xl px-4 sm:px-6">
            <button
                id="mobile-toc-trigger"
                type="button"
                class="w-full flex items-center justify-between py-3 gap-3"
                onclick="toggleMobileToc()"
                aria-expanded="false"
                aria-controls="mobile-toc-panel"
            >
                <span class="flex items-center gap-2 min-w-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 flex-shrink-0 text-zinc-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-1.125 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                    </svg>
                    <span id="mobile-toc-label" class="text-sm font-medium text-zinc-700 truncate">Daftar Isi</span>
                </span>
                <svg id="mobile-toc-chevron" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 flex-shrink-0 text-zinc-400 transition-transform duration-300">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                </svg>
            </button>
        </div>
    </div>
    {{-- Dropdown Panel --}}
    <div id="mobile-toc-panel" class="hidden overflow-hidden bg-white border-b border-zinc-200/80 shadow-lg">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 py-2 max-h-[55vh] overflow-y-auto">
            <ul id="mobile-toc-list" class="py-1 space-y-0.5"></ul>
        </div>
    </div>
</div>

<section class="pt-3 pb-10 sm:pt-5 sm:pb-14 bg-zinc-50">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            {{-- LEFT COLUMN: CONTENT --}}
            <div class="lg:col-span-8 bg-white p-5 sm:p-8 rounded-2xl border border-zinc-200/80 shadow-sm">

                {{-- TITLE --}}
                <h1 class="text-2xl sm:text-3.5xl font-extrabold tracking-tight text-zinc-900 leading-tight">
                    {{ $page->title }}
                </h1>

                {{-- META --}}
                <div class="mt-3.5 flex flex-wrap items-center gap-4 text-xs font-medium text-zinc-500 pb-4 border-b border-zinc-100">
                    @if($page->category)
                    <span class="inline-flex items-center rounded-full bg-primary-50 px-2.5 py-0.5 text-xs font-semibold text-primary-800 uppercase tracking-wider">
                        {{ $page->category->name }}
                    </span>
                    @endif
                    
                    @if($page->publish_at)
                    <span class="flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-zinc-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        {{ \Carbon\Carbon::parse($page->publish_at)->translatedFormat('d M, Y') }}
                    </span>
                    @endif
                </div>

                {{-- THUMBNAIL --}}
                @if ($page->thumbnail)
                <div class="mt-6 overflow-hidden rounded-xl border border-zinc-200/60 shadow-sm">
                    <img
                        src="{{ asset('storage/' . $page->thumbnail) }}"
                        alt="{{ $page->title }}"
                        class="w-full object-cover transition-transform duration-500 hover:scale-105">
                </div>
                @endif


                {{-- ================= INLINE TABLE OF CONTENTS ================= --}}
                <div id="inline-toc" class="mt-6 hidden">
                    <div class="rounded-xl border border-zinc-200 bg-zinc-50 overflow-hidden">
                        <button
                            id="inline-toc-toggle"
                            type="button"
                            class="w-full flex items-center justify-between px-5 py-3.5 text-left hover:bg-zinc-100/70 transition-colors duration-200"
                            onclick="toggleInlineToc()"
                            aria-expanded="true"
                            aria-controls="inline-toc-body"
                        >
                            <span class="flex items-center gap-2.5">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 text-primary-900 flex-shrink-0">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-1.125 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                </svg>
                                <span class="text-sm font-bold text-zinc-800 uppercase tracking-wider">Daftar Isi</span>
                            </span>
                            <svg id="inline-toc-chevron" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-zinc-400 transition-transform duration-300">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>
                        <div id="inline-toc-body" class="border-t border-zinc-200/70">
                            <ol id="inline-toc-list" class="px-5 pt-3 pb-5 space-y-1 text-sm"></ol>
                        </div>
                    </div>
                </div>

                {{-- CONTENT --}}
                <article
                    id="articleContent"
                    class="mt-8 max-w-none">
                    {!! $page->content !!}
                </article>

                {{-- TAGS --}}
                @if($page->tags->count() > 0)
                <div class="mt-8 flex flex-wrap gap-2 pt-6 border-t border-zinc-100">
                    @foreach($page->tags as $tag)
                    <a href="{{ route('pages.tag', $tag->slug) }}" class="inline-flex items-center rounded-md bg-zinc-100 px-2.5 py-1 text-xs font-medium text-zinc-600 transition hover:bg-zinc-200 hover:text-primary-900 shadow-sm border border-zinc-200/40">
                        #{{ $tag->name }}
                    </a>
                    @endforeach
                </div>
                @endif

                {{-- ================= SHARE ================= --}}
                <div class="mt-8 border-t border-zinc-200 pt-6">
                    <div class="flex flex-wrap items-center gap-3 share-flex-buttons">
                        <span class="text-xs font-medium text-zinc-400 uppercase tracking-wider">
                            {{ strip_tags(setting('blog_share_label', 'Bagikan')) }}
                        </span>

                        {{-- WhatsApp --}}
                        <a
                            href="https://wa.me/?text={{ urlencode($page->title . ' — ' . url()->current()) }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="share-btn share-btn-wa"
                            title="Bagikan ke WhatsApp">
                            <svg viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.076-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"/>
                            </svg>
                            <span>WhatsApp</span>
                        </a>

                        {{-- Facebook --}}
                        <a
                            href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="share-btn share-btn-fb"
                            title="Bagikan ke Facebook">
                            <svg viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                            <span>Facebook</span>
                        </a>

                        {{-- X (Twitter) --}}
                        <a
                            href="https://twitter.com/intent/tweet?text={{ urlencode($page->title) }}&url={{ urlencode(url()->current()) }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="share-btn share-btn-x"
                            title="Bagikan ke X">
                            <svg viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                            </svg>
                            <span>Twitter</span>
                        </a>

                        {{-- Copy Link --}}
                        <button
                            onclick="shareCopyLink()"
                            class="share-btn share-btn-copy"
                            title="Salin link">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                                <rect width="14" height="14" x="8" y="8" rx="2" ry="2"/>
                                <path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/>
                            </svg>
                            <span>Salin Link</span>
                        </button>
                    </div>
                </div>

                {{-- BACK TO BLOG --}}
                <div class="mt-8 pt-4">
                    <a
                        href="{{ route('pages.index') }}"
                        class="inline-flex items-center gap-2
                               text-sm font-medium
                               text-primary-700
                               hover:text-primary-900
                               transition-colors">
                        ← {{ strip_tags(setting('blog_back_label', 'Kembali ke Blog')) }}
                    </a>
                </div>

            </div>
            {{-- RIGHT COLUMN: SIDEBAR --}}
            <aside class="lg:col-span-4">
                <div class="sticky top-28 space-y-6">
                    {{-- DAFTAR ISI (TABLE OF CONTENTS) CARD --}}
                    <div id="toc-card" class="bg-white p-5 sm:p-6 rounded-2xl border border-zinc-200/80 shadow-sm hidden lg:block">
                        <h3 class="text-sm font-bold text-zinc-950 mb-4 pb-2.5 border-b border-zinc-100 uppercase tracking-wider flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 text-primary-900">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-1.125 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                            </svg>
                            Daftar Isi
                        </h3>
                        <nav id="toc-list-container">
                            <ul id="toc-list" class="space-y-2 text-xs sm:text-sm font-medium">
                                {{-- Generated by JS --}}
                            </ul>
                        </nav>
                    </div>

                    @php
                        $recentPosts = \App\Models\Page::where('status', 'published')
                            ->where('id', '!=', $page->id)
                            ->latest('publish_at')
                            ->limit(5)
                            ->get();
                    @endphp
                    @if($recentPosts->count() > 0)
                    <div class="bg-white p-5 sm:p-6 rounded-2xl border border-zinc-200/80 shadow-sm">
                        <h3 class="text-sm font-bold text-zinc-950 mb-4 pb-2.5 border-b border-zinc-100 uppercase tracking-wider">
                            Baca Juga
                        </h3>
                        <div class="space-y-4">
                            @foreach($recentPosts as $post)
                            <a href="{{ route('pages.show', $post->slug) }}" class="group flex gap-3 items-start">
                                <div class="h-14 w-14 sm:h-16 sm:w-16 flex-shrink-0 overflow-hidden rounded-lg border border-zinc-200/60 bg-zinc-50">
                                    <img src="{{ $post->thumbnail ? asset('storage/' . $post->thumbnail) : asset('default-thumbnail.png') }}"
                                         alt="{{ $post->title }}"
                                         class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-xs sm:text-sm font-semibold text-zinc-800 group-hover:text-primary-900 transition-colors line-clamp-2 leading-snug">
                                        {{ $post->title }}
                                    </h4>
                                    <span class="text-[10px] sm:text-xs text-zinc-400 mt-1 block">
                                        {{ \Carbon\Carbon::parse($post->publish_at)->translatedFormat('d M, Y') }}
                                    </span>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </aside>

        </div>

        {{-- ================= RELATED ARTICLES ================= --}}
        @if(isset($relatedPages) && $relatedPages->count() > 0)
        <section class="mt-20 pt-20 border-t border-zinc-200">

            <div class="max-w-6xl mx-auto">

                <div class="mb-10 flex items-center justify-between">
                    <h2 class="text-xl sm:text-2xl
                               font-bold tracking-tight
                               text-zinc-900">
                        {{ strip_tags(setting('blog_related_title', 'Artikel Terkait')) }}
                    </h2>

                    <a
                        href="{{ route('pages.index') }}"
                        class="text-sm font-medium
                               text-primary-700
                               hover:text-primary-900
                               transition-colors">
                        {{ strip_tags(setting('blog_view_all', 'Lihat Semua')) }} →
                    </a>
                </div>

                <div class="flex gap-6 overflow-x-auto pb-6
                            snap-x snap-mandatory
                            sm:grid sm:grid-cols-2
                            lg:grid-cols-3
                            sm:overflow-visible">

                    @foreach ($relatedPages as $item)
                    <article class="group snap-center shrink-0 w-[85%] sm:w-auto
                                    flex flex-col overflow-hidden
                                    rounded-2xl border
                                    border-zinc-200
                                    bg-white
                                    transition-all duration-300
                                    hover:-translate-y-1 hover:shadow-lg
                                    hover:border-primary-300">

                        @if ($item->thumbnail)
                        <a href="{{ route('pages.show', $item->slug) }}" class="relative block overflow-hidden">
                            @if($item->category)
                            <span class="absolute top-3 left-3 z-10 inline-flex items-center rounded bg-primary-500 px-2 py-1 text-[10px] font-bold text-white shadow-sm uppercase tracking-widest">
                                {{ $item->category->name }}
                            </span>
                            @endif
                            <img
                                src="{{ asset('storage/' . $item->thumbnail) }}"
                                alt="{{ $item->title }}"
                                class="h-40 w-full object-cover
                                       transition-transform duration-500
                                       group-hover:scale-110">
                        </a>
                        @endif

                        <div class="flex flex-col flex-1 p-5">
                            <a href="{{ route('pages.show', $item->slug) }}">
                                <h3 class="text-sm sm:text-base
                                           font-semibold leading-snug
                                           text-zinc-900
                                           line-clamp-2
                                           transition-colors
                                           group-hover:text-primary-700">
                                    {{ $item->title }}
                                </h3>
                            </a>

                            <p class="mt-2 text-sm
                                       text-zinc-600
                                       line-clamp-3">
                                {{ Str::limit(strip_tags($item->content), 120) }}
                            </p>
                        </div>
                    </article>
                    @endforeach

                </div>
            </div>
        </section>
        @endif

    </div>
</section>

{{-- ================= SCRIPT ================= --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const article = document.getElementById('articleContent');
        if (article) {
            const items = article.querySelectorAll('blockquote, p');
            items.forEach(item => {
                const text = item.textContent.trim();
                if (text.startsWith('Baca juga') || text.startsWith('Baca Juga')) {
                    item.classList.add('baca-juga-box');
                }
            });
        }
    });

    function shareCopyLink() {
        navigator.clipboard.writeText(window.location.href).then(() => {
            showShareToast('Link berhasil disalin!');
        }).catch(() => {
            showShareToast('Gagal menyalin link', 'error');
        });
    }



    function showShareToast(message, type = 'success') {
        const existing = document.getElementById('shareToast');
        if (existing) existing.remove();

        const toast = document.createElement('div');
        toast.id = 'shareToast';
        toast.innerHTML = `
            <div style="
                position: fixed;
                bottom: 1.75rem;
                left: 50%;
                transform: translateX(-50%);
                z-index: 9999;
                display: flex;
                align-items: center;
                gap: 0.5rem;
                padding: 0.625rem 1rem;
                border-radius: 0.75rem;
                font-size: 0.8125rem;
                font-weight: 500;
                color: ${type === 'success' ? '#166534' : '#991b1b'};
                background: ${type === 'success' ? '#dcfce7' : '#fee2e2'};
                border: 1px solid ${type === 'success' ? '#bbf7d0' : '#fecaca'};
                box-shadow: 0 8px 24px rgba(0,0,0,0.12);
                opacity: 0;
                animation: shareToastIn 0.3s ease forwards;
            ">
                <svg style="flex-shrink:0;width:14px;height:14px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    ${type === 'success'
                        ? '<polyline points="20 6 9 17 4 12"/>'
                        : '<line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>'}
                </svg>
                <span>${message}</span>
            </div>
        `;
        document.body.appendChild(toast);
        setTimeout(() => {
            toast.style.animation = 'shareToastOut 0.3s ease forwards';
            setTimeout(() => toast.remove(), 300);
        }, 2500);
    }



    /* ============================================================
       GLOBAL TOC HELPERS — harus di luar DOMContentLoaded
       agar onclick="toggleMobileToc()" di HTML bisa memanggil
       ============================================================ */
    function scrollToHeading(heading) {
        const stickyNav    = document.querySelector('nav.sticky');
        const mobileTocBar = document.getElementById('mobile-toc-bar');
        const navH  = stickyNav    ? stickyNav.offsetHeight    : 64;
        const tocH  = (mobileTocBar && !mobileTocBar.classList.contains('hidden'))
                    ? mobileTocBar.offsetHeight : 0;
        window.scrollTo({
            top: heading.getBoundingClientRect().top + window.scrollY - navH - tocH - 16,
            behavior: 'smooth'
        });
    }

    function toggleMobileToc() {
        const panel   = document.getElementById('mobile-toc-panel');
        const chevron = document.getElementById('mobile-toc-chevron');
        const trigger = document.getElementById('mobile-toc-trigger');
        if (!panel) return;
        const isOpen = !panel.classList.contains('hidden');
        if (isOpen) {
            panel.classList.add('hidden');
            chevron.style.transform = '';
            trigger.setAttribute('aria-expanded', 'false');
        } else {
            panel.classList.remove('hidden');
            chevron.style.transform = 'rotate(180deg)';
            trigger.setAttribute('aria-expanded', 'true');
            // Scroll active item into view
            setTimeout(() => {
                const active = panel.querySelector('a[data-active="true"]');
                if (active) active.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
            }, 60);
        }
    }

    function closeMobileToc() {
        const panel   = document.getElementById('mobile-toc-panel');
        const chevron = document.getElementById('mobile-toc-chevron');
        const trigger = document.getElementById('mobile-toc-trigger');
        if (!panel || panel.classList.contains('hidden')) return;
        panel.classList.add('hidden');
        if (chevron) chevron.style.transform = '';
        if (trigger) trigger.setAttribute('aria-expanded', 'false');
    }

    /* Close panel when clicking outside mobile TOC bar */
    document.addEventListener('click', function (e) {
        const bar = document.getElementById('mobile-toc-bar');
        if (bar && !bar.classList.contains('hidden') && !bar.contains(e.target)) {
            closeMobileToc();
        }
    });

    function toggleInlineToc() {
        const body    = document.getElementById('inline-toc-body');
        const chevron = document.getElementById('inline-toc-chevron');
        const toggle  = document.getElementById('inline-toc-toggle');
        if (!body) return;
        const isOpen = !body.classList.contains('hidden');
        if (isOpen) {
            body.classList.add('hidden');
            chevron.style.transform = 'rotate(-90deg)';
            toggle.setAttribute('aria-expanded', 'false');
        } else {
            body.classList.remove('hidden');
            chevron.style.transform = '';
            toggle.setAttribute('aria-expanded', 'true');
        }
    }

    /* Strip leading number prefix from heading text
       Handles: "1. ", "2) ", "10. " — prevents double numbering in TOC */
    function stripLeadingNumber(text) {
        return text.replace(/^\s*\d+[\.)\]]\s+/, '').trim();
    }

    /* ============================================================
       TABLE OF CONTENTS GENERATOR & SCROLLSPY
       ============================================================ */
    document.addEventListener('DOMContentLoaded', function () {
        const article        = document.getElementById('articleContent');
        const tocCard        = document.getElementById('toc-card');
        const tocList        = document.getElementById('toc-list');
        const mobileTocBar   = document.getElementById('mobile-toc-bar');
        const mobileTocList  = document.getElementById('mobile-toc-list');
        const mobileTocLabel = document.getElementById('mobile-toc-label');

        if (!article || !tocCard || !tocList) return;

        const headings = article.querySelectorAll('h2, h3');

        if (headings.length === 0) {
            tocCard.style.display = 'none';
            return;
        }

        const primaryColor = @js(setting('primary_color', '#F5A21C'));

        /* Build TOC items for desktop AND mobile */
        let desktopH2Counter = 0;
        headings.forEach((heading, index) => {
            let id = heading.id;
            if (!id) {
                id = heading.textContent
                    .toLowerCase()
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/(^-|-$)/g, '');
                if (document.getElementById(id)) id = `${id}-${index}`;
                heading.id = id;
            }

            const isH3      = heading.tagName === 'H3';
            const cleanText = stripLeadingNumber(heading.textContent);

            /* -- Desktop TOC (numbered) -- */
            const li = document.createElement('li');
            const a  = document.createElement('a');
            a.href = `#${id}`;
            a.dataset.target = id;

            if (isH3) {
                li.className            = 'pl-4 py-0.5';
                li.dataset.headingLevel = 'h3';
                a.className = 'flex items-center gap-2 text-zinc-500 hover:text-primary-900 transition-colors leading-snug text-xs';
                a.innerHTML = `<span class="w-1.5 h-1.5 rounded-full bg-zinc-300 flex-shrink-0"></span><span>${cleanText}</span>`;
            } else {
                desktopH2Counter++;
                li.className            = 'py-1';
                li.dataset.headingLevel = 'h2';
                a.className = 'flex items-start gap-2 text-zinc-500 hover:text-primary-900 transition-colors leading-snug';
                a.innerHTML = `<span class="flex-shrink-0 font-bold tabular-nums text-xs" style="color:${primaryColor};min-width:1.25rem">${desktopH2Counter}.</span><span class="font-semibold text-[13px]">${cleanText}</span>`;
            }

            a.addEventListener('click', e => {
                e.preventDefault();
                scrollToHeading(heading);
                history.pushState(null, null, `#${id}`);
                // Force scrollspy update after smooth-scroll animation settles
                setTimeout(() => window.dispatchEvent(new Event('scroll')), 700);
            });
            li.appendChild(a);
            tocList.appendChild(li);

            /* -- Mobile TOC -- */
            if (mobileTocList) {
                const mLi = document.createElement('li');
                const mA  = document.createElement('a');
                mA.href = `#${id}`;
                mA.dataset.mobileTarget = id;

                if (isH3) {
                    mLi.className = 'pl-4';
                    mA.className = 'flex items-center gap-2.5 w-full px-3 py-2.5 rounded-xl text-sm text-zinc-500 transition-all duration-200';
                    mA.innerHTML = `<span class="w-1.5 h-1.5 rounded-full bg-zinc-300 flex-shrink-0"></span><span>${cleanText}</span>`;
                } else {
                    mLi.className = '';
                    mA.className = 'flex items-center w-full px-3 py-2.5 rounded-xl text-sm font-semibold text-zinc-700 transition-all duration-200';
                    mA.textContent = cleanText;
                }

                mA.addEventListener('click', e => {
                    e.preventDefault();
                    closeMobileToc();
                    setTimeout(() => {
                        scrollToHeading(heading);
                        history.pushState(null, null, `#${id}`);
                        // Force scrollspy update after smooth-scroll animation settles
                        setTimeout(() => window.dispatchEvent(new Event('scroll')), 700);
                    }, 60);
                });

                mLi.appendChild(mA);
                mobileTocList.appendChild(mLi);
            }
        });

        /* Show inline TOC only when article has enough headings */
        const inlineToc     = document.getElementById('inline-toc');
        const inlineTocList = document.getElementById('inline-toc-list');
        if (inlineToc && inlineTocList && headings.length >= 2) {
            let h2Counter = 0;
            headings.forEach((heading, index) => {
                const id        = heading.id; // already set above
                const isH3      = heading.tagName === 'H3';
                const cleanText = stripLeadingNumber(heading.textContent);
                const iLi  = document.createElement('li');
                const iA   = document.createElement('a');
                iA.href = `#${id}`;

                if (isH3) {
                    iLi.className = 'pl-6';
                    iA.className = 'flex items-center gap-3 py-1.5 text-zinc-500 hover:text-primary-900 transition-colors leading-snug w-full';
                    iA.innerHTML = `<span class="w-1.5 h-1.5 rounded-full bg-zinc-300 flex-shrink-0"></span><span>${cleanText}</span>`;
                } else {
                    h2Counter++;
                    iLi.className = 'border-b border-zinc-100 last:border-b-0';
                    iA.className = 'flex items-start gap-3 py-2 text-zinc-700 font-medium hover:text-primary-900 transition-colors leading-snug w-full';
                    iA.innerHTML = `<span class="flex-shrink-0 font-bold tabular-nums" style="color:${primaryColor};min-width:1.5rem">${h2Counter}.</span><span>${cleanText}</span>`;
                }

                iA.addEventListener('click', e => {
                    e.preventDefault();
                    const targetHeading = document.getElementById(id);
                    if (targetHeading) {
                        scrollToHeading(targetHeading);
                        history.pushState(null, null, `#${id}`);
                        setTimeout(() => window.dispatchEvent(new Event('scroll')), 700);
                    }
                });

                iLi.appendChild(iA);
                inlineTocList.appendChild(iLi);
            });
            inlineToc.classList.remove('hidden');
        }

        /* Show / hide mobile TOC bar based on article position */
        function updateMobileTocVisibility() {
            if (!mobileTocBar) return;
            const rect = article.getBoundingClientRect();
            if (rect.top < 64 && rect.bottom > 120) {
                mobileTocBar.classList.remove('hidden');
            } else {
                mobileTocBar.classList.add('hidden');
                closeMobileToc();
            }
        }

        /* Scrollspy */
        const tocLinks       = tocList.querySelectorAll('a');
        const mobileTocLinks = mobileTocList ? mobileTocList.querySelectorAll('a') : [];

        function scrollspy() {
            let activeId   = null;
            let activeText = 'Daftar Isi';

            // Dynamic buffer = navbar height + mobile TOC bar height + padding
            // Must match the offset used in scrollToHeading() so headings land inside the buffer
            const stickyNav    = document.querySelector('nav.sticky');
            const scrollBuffer = (stickyNav ? stickyNav.offsetHeight : 64)
                               + ((mobileTocBar && !mobileTocBar.classList.contains('hidden')) ? mobileTocBar.offsetHeight : 0)
                               + 24;

            headings.forEach(h => {
                if (h.getBoundingClientRect().top <= scrollBuffer) {
                    activeId   = h.id;
                    activeText = stripLeadingNumber(h.textContent);
                }
            });

            if ((window.innerHeight + window.scrollY) >= document.documentElement.scrollHeight - 50 && headings.length) {
                const last = headings[headings.length - 1];
                activeId   = last.id;
                activeText = stripLeadingNumber(last.textContent);
            }

            /* Desktop active state */
            tocLinks.forEach(link => {
                const dot      = link.querySelector('span.rounded-full');
                const isActive = link.dataset.target === activeId;
                if (isActive) {
                    link.style.color      = primaryColor;
                    link.style.fontWeight = '700';
                    if (dot) dot.style.backgroundColor = primaryColor;
                } else {
                    link.style.color      = '';
                    link.style.fontWeight = '';
                    if (dot) dot.style.backgroundColor = '';
                }
            });

            /* Mobile label */
            if (mobileTocLabel) {
                mobileTocLabel.textContent = activeId ? activeText : 'Daftar Isi';
            }

            /* Mobile active state */
            mobileTocLinks.forEach(link => {
                const isActive = link.dataset.mobileTarget === activeId;
                link.dataset.active = isActive ? 'true' : 'false';
                const dot = link.querySelector('span.rounded-full');
                if (isActive) {
                    link.style.backgroundColor = primaryColor;
                    link.style.color = '#fff';
                    link.style.fontWeight = '600';
                    if (dot) dot.style.backgroundColor = 'rgba(255,255,255,0.7)';
                } else {
                    link.style.backgroundColor = '';
                    link.style.color = '';
                    link.style.fontWeight = '';
                    if (dot) dot.style.backgroundColor = '';
                }
            });

            updateMobileTocVisibility();
        }

        window.addEventListener('scroll', scrollspy, { passive: true });
        scrollspy();
    });
</script>

{{-- ================= STYLE ================= --}}
<style>
    .share-flex-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 10px !important;
    }

    .share-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.4375rem 0.875rem;
        border-radius: 0.5rem;
        font-size: 0.75rem;
        font-weight: 600;
        border: 1.5px solid transparent;
        transition: all 0.2s ease;
        cursor: pointer;
    }
    .share-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.12);
    }

    .share-btn-wa   { background: #25D366; color: #fff; }
    .share-btn-wa:hover { background: #1fb855; }

    .share-btn-fb   { background: #1877F2; color: #fff; }
    .share-btn-fb:hover { background: #166fe8; }

    .share-btn-x    { background: #000; color: #fff; }
    .share-btn-x:hover { background: #1a1a1a; }

    .share-btn-ig   { background: linear-gradient(135deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888); color: #fff; border-color: transparent; }
    .share-btn-ig:hover { opacity: 0.9; }

    .share-btn-copy { background: #fff; color: #52525b; border-color: #d4d4d8; }
    .share-btn-copy:hover { background: #f4f4f5; border-color: #a1a1aa; }

    @keyframes shareToastIn {
        from { opacity: 0; transform: translateX(-50%) translateY(8px); }
        to   { opacity: 1; transform: translateX(-50%) translateY(0); }
    }
    @keyframes shareToastOut {
        from { opacity: 1; transform: translateX(-50%) translateY(0); }
        to   { opacity: 0; transform: translateX(-50%) translateY(8px); }
    }
</style>

@endsection

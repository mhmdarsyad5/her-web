@extends('frontend.layouts.app')

@section('title', strip_tags($title) . ' - ' . strip_tags(setting('site_name', config('app.name'))))

@section('description', $page->excerpt ? strip_tags($page->excerpt) : Str::limit(strip_tags($page->content), 155))

@push('head')
@if($page->thumbnail)
<meta property="og:image"      content="{{ asset('storage/' . $page->thumbnail) }}" />
<meta property="og:type"       content="article" />
<meta name="twitter:image"     content="{{ asset('storage/' . $page->thumbnail) }}" />
@endif
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
        margin-bottom: 0.375rem;
        line-height: 1.6;
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
</style>
@endpush

@section('content')

{{-- ================= READING PROGRESS BAR ================= --}}
<div
    id="readingProgress"
    class="fixed top-0 left-0 z-50 h-[3px] w-0 bg-primary-900 transition-all duration-300">
</div>

@include('frontend.components.breadcrumb', [
    'items' => [
        ['label' => 'Blog', 'url' => route('pages.index')],
        ['label' => $page->title, 'url' => null]
    ]
])

<section class="pt-3 pb-10 sm:pt-5 sm:pb-14 bg-zinc-50">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

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
                    <span class="inline-flex items-center rounded-md bg-zinc-100 px-2.5 py-1 text-xs font-medium text-zinc-600 transition hover:bg-zinc-200 shadow-sm border border-zinc-200/40">
                        #{{ $tag->name }}
                    </span>
                    @endforeach
                </div>
                @endif

                {{-- ================= SHARE ================= --}}
                <div class="mt-8 border-t border-zinc-200 pt-6">
                    <div class="flex flex-wrap items-center gap-3">
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
                            <span>X</span>
                        </a>

                        {{-- Instagram --}}
                        <a
                            href="https://www.instagram.com/stories/compose?text={{ urlencode($page->title . ' — ' . url()->current()) }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="share-btn share-btn-ig"
                            title="Bagikan ke Instagram">
                            <svg viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z"/>
                            </svg>
                            <span>Instagram</span>
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
            <aside class="lg:col-span-4 space-y-6">
                @php
                    $recentPosts = \App\Models\Page::where('is_published', true)
                        ->where('id', '!=', $page->id)
                        ->latest('publish_at')
                        ->limit(5)
                        ->get();
                @endphp
                @if($recentPosts->count() > 0)
                <div class="bg-white p-5 sm:p-6 rounded-2xl border border-zinc-200/80 shadow-sm">
                    <h3 class="text-sm font-bold text-zinc-950 mb-4 pb-2.5 border-b border-zinc-100 uppercase tracking-wider">
                        Recent Posts
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

    /* Reading Progress Bar */
    window.addEventListener("scroll", () => {
        const article = document.getElementById("articleContent");
        const bar = document.getElementById("readingProgress");

        if (!article || !bar) return;

        const articleTop = article.offsetTop;
        const articleHeight = article.offsetHeight;
        const scrollPosition = window.scrollY + window.innerHeight;

        let progress = 0;
        if (scrollPosition > articleTop) {
            progress = Math.min(
                ((scrollPosition - articleTop) / (articleHeight + window.innerHeight - 100)) * 100,
                100
            );
        }

        bar.style.width = progress + "%";
    });
</script>

{{-- ================= STYLE ================= --}}
<style>
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

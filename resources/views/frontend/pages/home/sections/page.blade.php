<section class="py-8 sm:py-10 lg:py-12 bg-gradient-to-b from-white via-zinc-50/20 to-white relative overflow-hidden">

    {{-- Glowing side light --}}
    <div class="absolute bottom-1/3 left-0 w-80 h-80 bg-primary-900/5 rounded-full blur-[100px] pointer-events-none"></div>

    <div class="mx-auto max-w-7xl px-6 sm:px-12 lg:px-20 relative z-10">

        {{-- ================= HEADER ================= --}}
        <div class="mb-10">

            {{-- BADGE --}}
            @if(setting('blog_badge'))
                <div class="mb-6">
                    <span class="inline-flex items-center rounded-full
                                   bg-zinc-100 border border-zinc-200/40
                                   px-3.5 py-1
                                   text-xs font-semibold tracking-wide
                                   text-zinc-900">
                        {{ strip_tags(setting('blog_badge')) }}
                    </span>
                </div>
            @endif

            {{-- TITLE + CTA --}}
            <div class="flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">
                <div class="max-w-2xl">
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl
                               font-extrabold tracking-tight leading-tight
                               text-zinc-950">
                        {{ strip_tags(setting('blog_title', 'Blog Terbaru')) }}
                    </h2>

                    <p class="mt-4 text-sm sm:text-base lg:text-lg
                               leading-relaxed
                               text-zinc-600">
                        {{ strip_tags(
                            setting(
                                'blog_subtitle',
                                'Update terbaru tentang teknologi, inovasi digital, dan perjalanan startup.'
                            )
                        ) }}
                    </p>
                </div>

                <a href="{{ route('pages.index') }}"
                    class="group inline-flex items-center gap-1.5
                          text-sm sm:text-base font-bold
                          text-primary-900
                          hover:text-primary-800
                          transition-colors">
                    {{ strip_tags(setting('blog_cta', 'Lihat semua')) }}
                    <x-heroicon-m-arrow-right class="h-4 w-4 transition-transform group-hover:translate-x-1" />
                </a>
            </div>
        </div>

        {{-- ================= ARTICLES ================= --}}
        <div class="flex gap-6 overflow-x-auto pb-6
                      snap-x snap-mandatory
                      sm:grid sm:grid-cols-2
                      lg:grid-cols-3
                      sm:gap-8
                      sm:overflow-visible">

            @forelse ($pages as $page)
            @php
            $excerpt = $page->excerpt
                ? $page->excerpt
                : \Illuminate\Support\Str::limit(strip_tags($page->content), 140);
            @endphp

            <article class="group flex flex-col snap-center shrink-0 w-[85%] sm:w-auto
                            rounded-2xl border
                            border-zinc-200/70
                            bg-white
                            overflow-hidden
                            transition-all duration-300
                            hover:border-primary-400/50
                            hover:shadow-xl hover:shadow-primary-900/5 hover:-translate-y-1.5">

                {{-- THUMBNAIL --}}
                <div class="aspect-video bg-zinc-100 overflow-hidden relative flex-shrink-0">
                    <img
                        src="{{ asset('storage/' . $page->thumbnail) }}"
                        onerror="this.src='{{ asset('assets-default/placeholder.jpg') }}'"
                        alt="{{ $page->title }}"
                        loading="lazy"
                        class="h-full w-full object-cover
                               transition-transform duration-700 ease-out
                               group-hover:scale-105">
                    
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                </div>

                {{-- CONTENT --}}
                <div class="flex flex-col flex-1 p-4 sm:p-5 relative">
                    <a href="{{ route('pages.show', $page->slug) }}" class="block">
                        <h3 class="text-base sm:text-lg font-bold leading-snug text-zinc-950 transition-colors group-hover:text-primary-900 line-clamp-2 mb-1.5">
                            {{ $page->title }}
                        </h3>
                    </a>

                    <p class="mt-1 text-xs sm:text-sm leading-relaxed text-zinc-500 mb-3">
                        {{ $excerpt }}
                    </p>

                    <div class="mt-auto pt-3 border-t border-zinc-100">
                        <a href="{{ route('pages.show', $page->slug) }}" class="flex items-center justify-between text-[11px] sm:text-xs font-bold text-zinc-400 hover:text-primary-900 group-hover:text-primary-900 transition-colors">
                            <span>Baca Selengkapnya</span>
                            <x-heroicon-o-chevron-right class="h-3.5 w-3.5 transform transition-transform group-hover:translate-x-0.5" />
                        </a>
                    </div>
                </div>
            </article>
            @empty
            <div class="col-span-full text-center py-20">
                <p class="text-sm text-zinc-600">
                    Belum ada artikel blog.
                </p>
            </div>
            @endforelse
        </div>
    </div>
</section>

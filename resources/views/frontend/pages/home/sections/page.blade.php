<section class="py-16 sm:py-20 lg:py-24 bg-white">
    <div class="mx-auto max-w-7xl px-6 sm:px-12 lg:px-20">

        {{-- ================= HEADER ================= --}}
        <div class="mb-12 lg:mb-16">

            {{-- BADGE --}}
            <div class="mb-6">
                <span class="inline-flex items-center rounded-full
                               bg-primary-100
                               px-3 py-1.5
                               text-xs font-medium tracking-wide
                               text-primary-800">
                    {{ strip_tags(setting('blog_badge', 'Blog')) }}
                </span>
            </div>

            {{-- TITLE + CTA --}}
            <div class="flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">
                <div class="max-w-2xl">
                    <h2 class="text-xl sm:text-2xl lg:text-3xl
                               font-semibold tracking-tight leading-tight
                               text-zinc-900">
                        {{ strip_tags(setting('blog_title', 'Blog Terbaru')) }}
                    </h2>

                    <p class="mt-4 text-sm sm:text-base
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
                    class="inline-flex items-center gap-2
                          text-sm sm:text-base font-medium
                          text-primary-700
                          hover:text-primary-900
                          transition-colors">
                    {{ strip_tags(setting('blog_cta', 'Lihat semua')) }}
                    <span aria-hidden="true">→</span>
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
            $excerpt = \Illuminate\Support\Str::limit(
            strip_tags($page->content),
            140
            );
            @endphp

            <article class="group snap-center shrink-0 w-[85%] sm:w-auto
                            rounded-2xl border
                            border-zinc-200
                            bg-white
                            overflow-hidden
                            transition-all duration-300
                            hover:border-primary-300
                            hover:shadow-lg hover:-translate-y-1">

                {{-- THUMBNAIL --}}
                <div class="aspect-video bg-zinc-100 overflow-hidden">
                    <img
                        src="{{ asset('storage/' . $page->thumbnail) }}"
                        onerror="this.src='{{ asset('assets-default/placeholder.jpg') }}'"
                        alt="{{ $page->title }}"
                        loading="lazy"
                        class="h-full w-full object-cover
                               transition-transform duration-500 ease-out
                               group-hover:scale-110">
                </div>

                {{-- CONTENT --}}
                <div class="p-6 sm:p-7">
                    <a href="{{ route('pages.show', $page->slug) }}" class="block">
                        <h3 class="text-base lg:text-lg
                                   font-medium tracking-tight
                                   text-zinc-900
                                   line-clamp-2
                                   transition-colors
                                   group-hover:text-primary-700">
                            {{ $page->title }}
                        </h3>
                    </a>

                    <p class="mt-3 text-sm leading-relaxed
                               text-zinc-600
                               line-clamp-3">
                        {{ $excerpt }}
                    </p>
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

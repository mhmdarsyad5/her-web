<section id="hero"
    class="relative overflow-hidden
           bg-zinc-50">

    <div class="swiper heroSwiper select-none">
        <div class="swiper-wrapper">

            @foreach ($heroes as $hero)
            @php
            $images = is_array($hero->images)
            ? $hero->images
            : json_decode($hero->images ?? '[]', true);

            $heroImage = $images[0] ?? $hero->image;
            @endphp

            <div class="swiper-slide">
                <div class="grid min-h-[90vh] grid-cols-1 md:grid-cols-2">

                    {{-- LEFT CONTENT --}}
                    <div
                        class="relative z-10 flex flex-col justify-center
                               px-6 sm:px-12 lg:px-20
                               py-16 md:py-0
                               text-center md:text-left
                               bg-white/80
                               backdrop-blur">

                        {{-- TITLE --}}
                        <h1
                            class="fade-up
                                   text-2xl sm:text-3xl lg:text-4xl xl:text-5xl
                                   font-bold tracking-tight leading-tight
                                   text-zinc-900">
                            {{ $hero->title }}
                        </h1>

                        {{-- DESCRIPTION --}}
                        @if ($hero->description)
                        <p
                            class="fade-up mt-4 max-w-xl
                                   text-sm sm:text-base
                                   leading-relaxed
                                   text-zinc-600
                                   mx-auto md:mx-0"
                            style="animation-delay:.1s">
                            {{ $hero->description }}
                        </p>
                        @endif

                        {{-- BUTTON CTA --}}
                        @if ($hero->button_text)
                        <div class="fade-up mt-8 flex justify-center md:justify-start" style="animation-delay:.2s">
                            <a href="{{ $hero->button_url ?? '#' }}"
                                class="group inline-flex items-center gap-2
              rounded-md px-6 py-3
              text-sm font-medium
              bg-primary-900 text-white               <!-- Light mode: gelap seperti zinc-900 -->
              hover:bg-primary-800 <!-- Dark mode: terang seperti zinc-100 -->
              transition-colors duration-200">

                                {{ $hero->button_text }}

                                <x-heroicon-o-arrow-right
                                    class="h-4 w-4 transition-transform group-hover:translate-x-1" />
                            </a>
                        </div>
                        @endif
                    </div>

                    {{-- RIGHT IMAGE --}}
                    <div class="relative h-[55vh] md:h-full w-full">
                        <img
                            src="{{ asset('storage/' . $heroImage) }}"
                            alt="{{ $hero->title }}"
                            loading="eager"
                            decoding="async"
                            class="absolute inset-0 h-full w-full object-cover" />

                        {{-- OVERLAY --}}
                        <div class="absolute inset-0
                                    bg-gradient-to-tr from-black/20 via-transparent to-white/10">
                        </div>
                    </div>

                </div>
            </div>
            @endforeach

        </div>

        {{-- NAVIGATION (DESKTOP ONLY) --}}
        <div
            class="absolute inset-y-0 inset-x-0 z-20
                   hidden lg:flex
                   items-center justify-between
                   px-8
                   pointer-events-none">

            {{-- PREV --}}
            <button
                type="button"
                class="hero-prev group
                       pointer-events-auto
                       flex h-10 w-10 items-center justify-center
                       rounded-full
                       bg-white/80
                       backdrop-blur
                       shadow
                       border border-zinc-200
                       hover:bg-white
                       transition">

                <x-heroicon-o-chevron-left
                    class="h-5 w-5 text-zinc-700
                           transition-transform group-hover:-translate-x-0.5" />
            </button>

            {{-- NEXT --}}
            <button
                type="button"
                class="hero-next group
                       pointer-events-auto
                       flex h-10 w-10 items-center justify-center
                       rounded-full
                       bg-white/80
                       backdrop-blur
                       shadow
                       border border-zinc-200
                       hover:bg-white
                       transition">

                <x-heroicon-o-chevron-right
                    class="h-5 w-5 text-zinc-700
                           transition-transform group-hover:translate-x-0.5" />
            </button>

        </div>

        {{-- PAGINATION --}}
        <div class="absolute bottom-6 inset-x-0 z-50 flex justify-center">
            <div class="swiper-pagination !static"></div>
        </div>
    </div>

</section>

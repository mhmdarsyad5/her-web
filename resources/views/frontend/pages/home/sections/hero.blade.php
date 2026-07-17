@php
    $firstHero = $heroes->first();

    // Dynamic text from first hero record in DB with fallback to mockup hardcode
    $title = $firstHero?->title ?? 'Rental Forklift & Warehouse Equipment';
    $desc = $firstHero?->description ?? 'Herro Equipment Rentals hadir sebagai solusi total logistik internal melalui penyediaan HANGCHA forklift & Warehouse Equipment tangguh untuk gudang Anda dengan jaminan anti downtime.';
    $btnText = $firstHero?->button_text ?? 'Kontak Kami';
    $btnUrl = $firstHero?->button_url ?? '#contactmessage';
    $secBtnText = $firstHero?->secondary_button_text ?? 'Layanan Kami';
    $secBtnUrl = $firstHero?->secondary_button_url ?? '#dssSection';

    // Retrieve multiple images array
    $images = $firstHero?->image ?? [];
    if (is_string($images)) {
        $images = json_decode($images, true) ?: (empty($images) ? [] : [$images]);
    }

    // Fallback: If no images on first record, collect images from all hero records
    if (empty($images)) {
        $images = $heroes->map(function ($h) {
            $img = $h->image;
            if (is_array($img)) {
                return $img[0] ?? null;
            }
            $dec = json_decode($img ?? '', true);
            return is_array($dec) ? ($dec[0] ?? null) : $img;
        })->filter()->values()->toArray();
    }

    // Chunk the images into groups of 3 for the dynamic background grid slides
    $imageChunks = collect($images)->chunk(3);
@endphp

<section id="hero" class="py-6 bg-white select-none">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        {{-- CURVED HERO CONTAINER (Aspect ratio locked to 2.13/1 on desktop, compact padding on mobile) --}}
        <div
            class="hero-ratio-container relative overflow-hidden rounded-[2rem] md:rounded-[2.5rem] bg-zinc-950 w-full flex items-center justify-center py-10 sm:py-14 md:py-0 px-4 sm:px-12 md:px-16 lg:px-20"
            style="aspect-ratio: auto;">
            
            <style>
                @media (min-width: 768px) {
                    .hero-ratio-container {
                        aspect-ratio: 2.13 / 1 !important;
                    }
                }
            </style>
            
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const container = document.querySelector('.hero-ratio-container');
                    if (container) {
                        const setRatio = () => {
                            if (window.innerWidth >= 768) {
                                container.style.aspectRatio = '2.13 / 1';
                            } else {
                                container.style.aspectRatio = 'auto';
                            }
                        };
                        setRatio();
                        window.addEventListener('resize', setRatio);
                    }
                });
            </script>

            {{-- BACKGROUND SWIPER SLIDER WRAPPER (Chunked into dynamic 3-column grids) --}}
            <div class="absolute inset-0 z-0 pointer-events-none">
                <div class="swiper heroSwiper h-full w-full">
                    <div class="swiper-wrapper">
                        @foreach ($imageChunks as $chunk)
                            <div class="swiper-slide h-full w-full">
                                <div class="grid h-full w-full gap-[3px]" style="grid-template-columns: repeat({{ $chunk->count() }}, minmax(0, 1fr));">
                                    @foreach ($chunk as $img)
                                        <div class="h-full w-full overflow-hidden">
                                            <img src="{{ asset('storage/' . $img) }}" alt="Background Slide Item" loading="eager"
                                                decoding="async"
                                                class="h-full w-full object-cover object-center brightness-[0.80] contrast-[1.02]" />
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- SOFT DARK OVERLAY (Slight dark background for readability) --}}
            <div class="absolute inset-0 z-10 pointer-events-none bg-black/55"></div>

            {{-- STATIC OVERLAY CONTENT --}}
            <div
                class="relative z-20 w-full max-w-4xl lg:max-w-5xl xl:max-w-6xl 2xl:max-w-7xl flex flex-col items-center text-center space-y-3 sm:space-y-4 lg:space-y-5 py-4 md:py-6 mx-auto">

            {{-- SUBTLE BADGE --}}
            <span
                class="hero-badge inline-flex items-center gap-2 rounded-full bg-white/10 border border-white/15 px-3.5 py-1.5 text-[10px] sm:text-sm font-semibold text-zinc-200 shadow-sm backdrop-blur-sm">
                <x-heroicon-s-shield-check class="h-4 w-4 sm:h-5 sm:w-5 text-emerald-400 flex-shrink-0" />
                HANGCHA Authorized Rental Indonesia
            </span>

            {{-- TITLE --}}
            @php
                $primaryColor = setting('primary_color', '#F5A21C');
                $highlightSpan = '<span class="relative inline-block px-2.5 py-0.5 mx-1 rounded-lg text-white font-bold" style="background-color: ' . $primaryColor . '; transform: rotate(-0.5deg); text-shadow: none;">' . 'Tanpa Downtime' . '</span>';
                $highlightSpanLower = '<span class="relative inline-block px-2.5 py-0.5 mx-1 rounded-lg text-white font-bold" style="background-color: ' . $primaryColor . '; transform: rotate(-0.5deg); text-shadow: none;">' . 'tanpa downtime' . '</span>';

                $highlightedTitle = str_replace(
                    ['Tanpa Downtime', 'tanpa downtime'],
                    [$highlightSpan, $highlightSpanLower],
                    e($title)
                );
            @endphp
            <h1 class="font-display text-lg sm:text-2xl md:text-3xl lg:text-4xl xl:text-5xl font-bold tracking-tight text-white leading-[1.2]"
                style="text-shadow: 0 2px 8px rgba(0,0,0,0.5);">
                {!! $highlightedTitle !!}
            </h1>

            {{-- DESCRIPTION --}}
            @if ($desc)
                <p class="hero-desc text-[11px] sm:text-sm md:text-base text-zinc-200 leading-relaxed font-normal max-w-3xl lg:max-w-4xl 2xl:max-w-6xl"
                    style="text-shadow: 0 1px 4px rgba(0,0,0,0.5);">
                    {{ $desc }}
                </p>
            @endif

            {{-- KEY POINT LISTS (Horizontal on desktop, clean vertical list on mobile) --}}
            @php
                $points = $firstHero?->key_points ?? [
                    'Layanan Rental Forklift Terpercaya & Profesional',
                    'Jaminan Unit Prima & Dukungan Teknisi Siaga',
                    'Pilihan Kapasitas Lengkap (1.5 - 16 Ton)'
                ];
            @endphp
            @if(!empty($points))
                <div class="flex flex-col sm:flex-row flex-wrap items-center justify-center gap-y-1.5 sm:gap-y-2 gap-x-6 pt-0.5 w-full max-w-4xl lg:max-w-5xl 2xl:max-w-6xl">
                    @foreach($points as $point)
                        @if(filled($point))
                            <div class="hero-point flex items-center gap-2 text-[10px] sm:text-xs md:text-sm font-bold text-zinc-100 whitespace-nowrap"
                                style="text-shadow: 0 1px 4px rgba(0,0,0,0.5);">
                                <x-heroicon-s-check-circle class="h-3 w-3 sm:h-4 sm:w-4 flex-shrink-0" style="color: {{ $primaryColor }};" />
                                {{ $point }}
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif

            {{-- BUTTONS CTA --}}
            <div class="flex flex-row flex-wrap gap-2.5 sm:gap-3 items-center justify-center w-full pt-1">
                @if ($btnText)
                    <a href="{{ $btnUrl }}" class="hero-btn group inline-flex items-center gap-2
                                                           rounded-xl px-5 py-2.5 sm:px-7 sm:py-3.5
                                                           text-xs sm:text-base font-bold
                                                           text-white
                                                           shadow-md shadow-zinc-950/20
                                                           hover:brightness-95 hover:-translate-y-0.5
                                                           active:translate-y-0
                                                           transition-all duration-200"
                         style="background-color: {{ setting('primary_color', '#F5A21C') }};">
                        {{ $btnText }}
                        <x-heroicon-o-arrow-right
                            class="h-4 w-4 transition-transform group-hover:translate-x-1" />
                    </a>
                @endif

                @if ($secBtnText)
                    <a href="{{ $secBtnUrl }}" class="hero-btn group inline-flex items-center gap-2
                                rounded-xl px-5 py-2.5 sm:px-7 sm:py-3.5
                                text-xs sm:text-base font-bold
                                bg-white shadow-md
                                hover:brightness-95 hover:-translate-y-0.5
                                active:translate-y-0
                                transition-all duration-200"
                        style="color: {{ setting('primary_color', '#F5A21C') }};">
                        {{ $secBtnText }}
                        <x-heroicon-o-arrow-right
                            class="h-4 w-4 transition-transform group-hover:translate-x-1"
                            style="color: {{ setting('primary_color', '#F5A21C') }};" />
                    </a>
                @endif
            </div>

        </div>
    </div>

    {{-- PAGINATION --}}
    <div class="absolute bottom-6 inset-x-0 z-30 flex justify-center pointer-events-none">
        <div class="swiper-pagination !static pointer-events-auto"></div>
    </div>

</section>
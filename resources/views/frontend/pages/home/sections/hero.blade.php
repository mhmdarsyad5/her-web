@php
    $firstHero = $heroes->first();

    // Dynamic text from first hero record in DB with fallback to mockup hardcode
    $title = $firstHero?->title ?? 'Rental Forklift & Warehouse Equipment';
    $desc = $firstHero?->description ?? 'Herro Equipment Rentals hadir sebagai solusi total logistik internal melalui penyediaan HANGCHA forklift & Warehouse Equipment tangguh untuk gudang Anda dengan jaminan anti downtime.';
    $btnText = $firstHero?->button_text ?? 'Kontak Kami';
    $btnUrl = $firstHero?->button_url ?? '#contactmessage';

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
@endphp

<section id="hero" class="py-6 bg-white select-none">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        {{-- CURVED HERO CONTAINER --}}
        <div
            class="relative overflow-hidden rounded-[2rem] md:rounded-[2.5rem] bg-zinc-950 w-full md:aspect-[16/9] flex items-start justify-center shadow-lg shadow-zinc-950/10 py-8 sm:py-12 md:py-0">

            {{-- BACKGROUND SWIPER SLIDER WRAPPER --}}
            <div class="absolute inset-0 z-0 pointer-events-none">
                <div class="swiper heroSwiper h-full w-full">
                    <div class="swiper-wrapper">
                        @foreach ($images as $img)
                            <div class="swiper-slide h-full w-full">
                                <img src="{{ asset('storage/' . $img) }}" alt="Background Slide" loading="eager"
                                    decoding="async"
                                    class="h-full w-full object-cover object-center brightness-[0.50] contrast-[1.05]" />
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- DARK GRADIENT OVERLAY --}}
            <div class="absolute inset-0 z-10 pointer-events-none"
                style="background: radial-gradient(circle, rgba(9,9,11,0.65) 0%, rgba(9,9,11,0.3) 65%, rgba(9,9,11,0.1) 100%);">
            </div>

            {{-- STATIC OVERLAY CONTENT --}}
            <div
                class="relative z-20 flex flex-col items-center justify-start text-center max-w-6xl px-4 sm:px-6 md:px-12 pt-4 sm:pt-24 md:pt-28 lg:pt-32 pb-4 sm:pb-8">

                {{-- SUBTLE BADGE --}}
                <span
                    class="mb-4 sm:mb-5 inline-flex items-center gap-1.5 rounded-full bg-zinc-950/40 border border-white/20 px-3 py-1 sm:px-4 sm:py-1.5 lg:px-5 lg:py-2 text-[9px] sm:text-xs lg:text-sm font-medium text-zinc-200 shadow-sm">
                    <span class="relative flex h-1.5 w-1.5 sm:h-2 sm:w-2 lg:h-2.5 lg:w-2.5">
                        <span
                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                        <span
                            class="relative inline-flex rounded-full h-1.5 w-1.5 sm:h-2 sm:w-2 lg:h-2.5 lg:w-2.5 bg-green-500"></span>
                    </span>
                    HANGCHA Authorized Rental Indonesia
                </span>

                {{-- TITLE --}}
                @php
                    $primaryColor = setting('primary_color', '#F5A21C');
                    $highlightSpan = '<span class="relative inline-block px-3.5 py-0.5 mx-1 rounded-xl text-white font-black" style="background-color: ' . $primaryColor . '; text-shadow: none; transform: rotate(-0.5deg);">' . 'Tanpa Downtime' . '</span>';
                    $highlightSpanLower = '<span class="relative inline-block px-3.5 py-0.5 mx-1 rounded-xl text-white font-black" style="background-color: ' . $primaryColor . '; text-shadow: none; transform: rotate(-0.5deg);">' . 'tanpa downtime' . '</span>';

                    $highlightedTitle = str_replace(
                        ['Tanpa Downtime', 'tanpa downtime'],
                        [$highlightSpan, $highlightSpanLower],
                        e($title)
                    );
                @endphp
                <h1 class="text-xl sm:text-3xl md:text-4xl lg:text-5xl font-black tracking-normal text-white leading-[1.35] max-w-6xl"
                    style="text-shadow: 0 4px 16px rgba(0,0,0,0.95), 0 2px 4px rgba(0,0,0,0.85);">
                    {!! $highlightedTitle !!}
                </h1>

                {{-- DESCRIPTION --}}
                @if ($desc)
                    <p class="mt-4 sm:mt-6 text-[11px] sm:text-base md:text-lg lg:text-xl text-zinc-200 leading-relaxed font-regular max-w-4xl"
                        style="text-shadow: 0 2px 8px rgba(0,0,0,0.9), 0 1px 2px rgba(0,0,0,0.8);">
                        {{ $desc }}
                    </p>
                @endif

                {{-- BUTTONS CTA --}}
                <div class="mt-6 sm:mt-8 flex flex-row flex-wrap gap-3 sm:gap-4 justify-center items-center">
                    @if ($btnText)
                        <a href="{{ $btnUrl }}" class="group inline-flex items-center gap-2
                                                               rounded-xl px-5 py-2.5 sm:px-8 sm:py-4
                                                               text-xs sm:text-base font-bold
                                                               text-white
                                                               shadow-md shadow-zinc-950/20
                                                               hover:brightness-95 hover:-translate-y-0.5
                                                               active:translate-y-0
                                                               transition-all duration-200"
                            style="background-color: {{ setting('primary_color', '#F5A21C') }};">
                            {{ $btnText }}
                            <x-heroicon-o-arrow-right
                                class="h-4 w-4 sm:h-5 sm:w-5 transition-transform group-hover:translate-x-1" />
                        </a>
                    @endif

                    <a href="#dssSection" class="group inline-flex items-center gap-2
                                rounded-xl px-5 py-2.5 sm:px-8 sm:py-4
                                text-xs sm:text-base font-bold
                                bg-white shadow-md shadow-zinc-950/10
                                hover:bg-zinc-50 hover:-translate-y-0.5
                                active:translate-y-0
                                transition-all duration-200" style="color: {{ setting('primary_color', '#F5A21C') }};">
                        {{ strip_tags(setting('about_cta_primary', 'Layanan kami')) }}
                        <x-heroicon-o-arrow-right
                            class="h-4 w-4 sm:h-5 sm:w-5 transition-transform group-hover:translate-x-1"
                            style="color: {{ setting('primary_color', '#F5A21C') }};" />
                    </a>
                </div>

            </div>



            {{-- PAGINATION --}}
            <div class="absolute bottom-6 inset-x-0 z-30 flex justify-center pointer-events-none">
                <div class="swiper-pagination !static pointer-events-auto"></div>
            </div>

        </div>

    </div>
</section>
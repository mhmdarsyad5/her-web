<section class="py-20 sm:py-24 bg-white">
    <div class="mx-auto max-w-7xl px-6 sm:px-12 lg:px-20">

        {{-- HEADER --}}
        <div class="mx-auto max-w-2xl text-center mb-16">

            {{-- BADGE --}}
            <span class="inline-flex items-center rounded-full
                       bg-primary-100
                       px-3 py-1.5
                       text-xs font-medium tracking-wide
                       text-primary-800">
                {{ strip_tags(setting('service_badge', 'Layanan Kami')) }}
            </span>

            {{-- TITLE (font size tidak diubah) --}}
            <h2 class="mt-4
                       text-xl sm:text-2xl lg:text-3xl
                       font-semibold tracking-tight leading-tight
                       text-zinc-900">
                {{ strip_tags(setting('title_section_service', 'Layanan yang Kami Sediakan')) }}
            </h2>

            {{-- DESCRIPTION (font size tidak diubah) --}}
            <p class="mt-4
                       text-sm sm:text-base
                       leading-relaxed
                       text-zinc-600">
                {{ strip_tags(setting(
    'subtitle_section_service',
    'Berbagai layanan profesional untuk mendukung kebutuhan bisnis dan transformasi digital Anda.'
)) }}
            </p>
        </div>

        {{-- SERVICES --}}
        <div class="grid grid-cols-1 gap-5
                   sm:grid-cols-2
                   lg:grid-cols-2
                   lg:gap-6">

            @forelse ($services->take(4) as $service)
                        <article class="rounded-2xl border
                                   border-zinc-200
                                   bg-white
                                   p-6
                                   transition-all duration-200
                                   hover:border-primary-300
                                   hover:shadow-md">

                            {{-- ICON (pakai primary subtle) --}}
                            @if ($service->icon)
                                <div class="mb-4 flex h-11 w-11
                                           items-center justify-center
                                           rounded-lg
                                           bg-primary-100
                                           ring-1 ring-primary-200">
                                    <img src="{{ asset('storage/' . $service->icon) }}" alt="{{ $service->name }}" loading="lazy"
                                        class="h-6 w-6 object-contain" />
                                </div>
                            @endif

                            {{-- TITLE (font size sama) --}}
                            <h3 class="text-base lg:text-lg
                                       font-medium tracking-tight
                                       text-zinc-900">
                                {{ $service->name }}
                            </h3>

                            {{-- DESCRIPTION (font size sama) --}}
                            <p class="mt-2
                                       text-sm
                                       leading-relaxed
                                       text-zinc-600
                                       line-clamp-3">
                                {{ \Illuminate\Support\Str::limit(
                    strip_tags($service->description),
                    160
                ) }}
                            </p>

                        </article>
            @empty
                <p class="text-center text-zinc-500 col-span-full">
                    Belum ada layanan.
                </p>
            @endforelse
        </div>

        {{-- CTA BUTTON (pakai primary full, konsisten dengan navbar & hero) --}}
        <div class="mt-16 text-center">
            <a href="{{ route('services.index') }}" class="inline-flex items-center gap-2
                       rounded-md
                       bg-primary-900
                       px-6 py-3
                       text-sm sm:text-base
                       font-medium
                       text-white
                       shadow-sm
                       hover:bg-primary-800
                       transition">
                {{ strip_tags(setting('cta_service', 'Lihat Semua Layanan')) }}
                <!-- <span aria-hidden="true">→</span> -->
            </a>
        </div>

    </div>
</section>
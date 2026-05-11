@php
    $logoPath = setting('profile_image');
    $storagePath = 'storage/' . $logoPath;
    $defaultPath = 'assets-default/setting/logo.svg';

    $aboutRaw = strip_tags(setting('about', 'Tidak ada deskripsi'));

    $aboutMobile = \Illuminate\Support\Str::limit($aboutRaw, 320, '');
    $aboutDesktop = \Illuminate\Support\Str::limit($aboutRaw, 1020, '');
    $isLongMobile = strlen($aboutRaw) > 320;
    $isLongDesktop = strlen($aboutRaw) > 1020;
@endphp

<section class="py-20 sm:py-24 lg:py-28 bg-white">
    <div class="mx-auto max-w-7xl px-6 sm:px-12 lg:px-20">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">

            {{-- LEFT — IMAGE --}}
            <div class="relative order-2 lg:order-1 flex items-center justify-center">
                <img src="{{ asset($storagePath) }}" onerror="this.src='{{ asset($defaultPath) }}'" loading="lazy"
                    alt="Logo {{ strip_tags(setting('site_name', 'Website')) }}" class="w-full max-w-sm sm:max-w-md lg:max-w-lg
                           rounded-2xl
                           shadow-lg
                           object-contain
                           select-none pointer-events-none" />
            </div>

            {{-- RIGHT — CONTENT --}}
            <div class="order-1 lg:order-2 max-w-xl mx-auto lg:mx-0 text-center lg:text-left">

                {{-- BADGE --}}
                <span class="inline-flex items-center rounded-full
                               bg-primary-100
                               px-3 py-1.5
                               text-xs font-medium tracking-wide
                               text-primary-800">
                    {{ strip_tags(setting('about_badge', 'Tentang Kami')) }}
                </span>

                {{-- TITLE --}}
                <h2 class="mt-4
                           text-xl sm:text-2xl lg:text-3xl
                           font-semibold tracking-tight leading-tight
                           text-zinc-900">
                    {!! setting('site_name', 'Nama Website') !!}
                </h2>

                {{-- DESCRIPTION --}}
                <p class="mt-4
                           text-sm sm:text-base
                           leading-relaxed
                           text-zinc-600">

                    {{-- MOBILE --}}
                    <span class="block lg:hidden">
                        {{ $aboutMobile }}
                        @if($isLongMobile)
                            <span class="text-zinc-400">…</span>
                        @endif
                    </span>

                    {{-- DESKTOP --}}
                    <span class="hidden lg:block">
                        {{ $aboutDesktop }}
                        @if($isLongDesktop)
                            <span class="text-zinc-400">…</span>
                        @endif
                    </span>
                </p>

                {{-- CTA --}}
                <div class="mt-10 flex flex-wrap gap-4 justify-center lg:justify-start">

                    {{-- PRIMARY BUTTON (pakai primary full) --}}
                    <a href="{{ route('services.index') }}" class="inline-flex items-center gap-2
                              rounded-md
                              bg-primary-900 text-white
                              px-6 py-3
                              text-sm sm:text-base font-medium
                              shadow-sm
                              hover:bg-primary-800
                              transition-colors">
                        {{ strip_tags(setting('about_cta_primary', 'Layanan Kami')) }}
                        <!-- <span aria-hidden="true">→</span> -->
                    </a>

                    {{-- SECONDARY BUTTON (outline dengan primary) --}}
                    <a href="{{ route('abouts.index') }}" class="inline-flex items-center gap-2
                              rounded-md border
                              border-primary-300
                              px-6 py-3
                              text-sm sm:text-base font-medium
                              text-primary-700
                              hover:bg-primary-100/50
                              transition-colors">
                        {{ strip_tags(setting('about_cta_secondary', 'Lihat Selengkapnya')) }}
                        <!-- <span aria-hidden="true">→</span> -->
                    </a>
                </div>

            </div>
        </div>
    </div>
</section>
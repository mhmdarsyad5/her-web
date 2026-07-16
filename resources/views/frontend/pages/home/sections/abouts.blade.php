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

<section
    class="py-8 sm:py-10 lg:py-12 bg-gradient-to-b from-white via-zinc-50/20 to-white relative overflow-hidden border-b border-zinc-200/80">

    {{-- Glowing side light --}}
    <div class="absolute bottom-1/4 right-0 w-80 h-80 bg-primary-900/5 rounded-full blur-[100px] pointer-events-none">
    </div>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative z-10">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-center">

            {{-- LEFT — IMAGE --}}
            <div class="relative order-2 lg:order-1 flex items-center justify-center">
                {{-- Glow Backing --}}
                <div class="absolute -inset-6 bg-primary-900/5 rounded-full blur-[100px] pointer-events-none"></div>

                <div
                    class="relative rounded-3xl border border-zinc-200/60 bg-gradient-to-br from-white to-zinc-50/50 p-4 shadow-xl shadow-zinc-200/30">
                    <img src="{{ asset($storagePath) }}" onerror="this.src='{{ asset($defaultPath) }}'" loading="lazy"
                        alt="Logo {{ strip_tags(setting('site_name', 'Website')) }}" class="w-full max-w-sm sm:max-w-md lg:max-w-lg
                               rounded-2xl
                               object-contain
                               select-none pointer-events-none" />
                </div>
            </div>

            {{-- RIGHT — CONTENT --}}
            <div class="order-1 lg:order-2 max-w-xl mx-auto lg:mx-0 text-center lg:text-left">

                {{-- BADGE --}}
                @if(setting('about_badge'))
                    <span class="inline-flex items-center rounded-full
                                       bg-zinc-100 border border-zinc-200/40
                                       px-3.5 py-1
                                       text-xs font-semibold tracking-wide
                                       text-zinc-900">
                        {{ strip_tags(setting('about_badge')) }}
                    </span>
                @endif

                {{-- TITLE --}}
                <h2 class="mt-5
                           text-2xl sm:text-3xl lg:text-4xl
                           font-extrabold tracking-tight leading-tight
                           text-zinc-955">
                    {!! setting('site_name', 'Nama Website') !!}
                </h2>

                {{-- DESCRIPTION --}}
                <p class="mt-5
                           text-sm sm:text-base lg:text-lg
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

                    {{-- PRIMARY BUTTON --}}
                    <a href="{{ route('services.index') }}" class="inline-flex items-center gap-2
                               rounded-lg
                               text-white
                               px-6 py-3.5
                               text-sm sm:text-base font-bold
                               shadow-md shadow-primary-900/10
                               hover:brightness-90 hover:shadow-lg hover:-translate-y-0.5
                               transition-all duration-200"
                               style="background-color: {{ setting('primary_color', '#F5A21C') }};">
                        {{ strip_tags(setting('about_cta_primary', 'Layanan Kami')) }}
                        <x-heroicon-o-arrow-right class="h-4 w-4" />
                    </a>

                    {{-- SECONDARY BUTTON --}}
                    <a href="{{ route('abouts.index') }}" class="inline-flex items-center gap-2
                               rounded-lg border
                               border-primary-300
                               px-6 py-3.5
                               text-sm sm:text-base font-bold
                               text-primary-900
                               hover:bg-primary-50/50 hover:-translate-y-0.5
                               transition-all duration-200">
                        {{ strip_tags(setting('about_cta_secondary', 'Lihat Selengkapnya')) }}
                    </a>
                </div>

            </div>
        </div>
    </div>
</section>
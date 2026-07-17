@php
    $primaryColor = setting('primary_color', '#F5A21C');
@endphp
<section
    class="pt-8 pb-16 sm:pt-10 sm:pb-20 lg:pt-12 lg:pb-24 relative overflow-hidden select-none"
    style="background-color: {{ $primaryColor }};">

    <div class="mx-auto max-w-7xl px-6 sm:px-12 lg:px-20 relative z-10">

        {{-- HEADER --}}
        <div class="mx-auto max-w-2xl text-center mb-16">

            {{-- BADGE --}}
            @if(setting('service_badge'))
                <span class="inline-flex items-center rounded-full
                                   bg-white/20 border border-white/30
                                   px-3.5 py-1
                                   text-xs font-bold tracking-wide
                                   text-white">
                    {{ strip_tags(setting('service_badge')) }}
                </span>
            @endif

            {{-- TITLE --}}
            <h2 class="mt-5
                       text-2xl sm:text-3xl lg:text-4xl
                       font-extrabold tracking-tight leading-tight
                       text-white">
                {{ strip_tags(setting('title_section_service', 'Layanan Kami')) }}
            </h2>

            {{-- DESCRIPTION --}}
            <p class="mt-4
                       text-sm sm:text-base lg:text-lg
                       leading-relaxed
                       text-white/90 font-medium">
                {{ strip_tags(setting('subtitle_section_service', 'Dukungan penuh untuk operasional berjalan tanpa hambatan')) }}
            </p>
        </div>

        {{-- SERVICES OVERLAPPING GRID LAYOUT (100% DB Dynamic Icons + Overlapping Cards) --}}
        <div
            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-y-16 gap-x-6 lg:gap-x-8 fade-slide opacity-0 translate-y-4">

            @forelse ($services as $service)
                @php
                    $showImage = setting('service_show_image', true);
                    $showDesc = setting('service_show_desc', true);
                @endphp
                <article class="group flex flex-col relative bg-transparent rounded-2xl w-full transition-all duration-300">

                    {{-- Top Photo Section --}}
                    @if($showImage)
                        <div class="relative h-40 sm:h-44 rounded-2xl overflow-hidden shadow-md">
                            @if($service->image)
                                <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" loading="lazy"
                                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" />
                            @else
                                {{-- Fallback image --}}
                                <div class="w-full h-full bg-zinc-100 flex items-center justify-center text-zinc-400">
                                    <x-heroicon-o-photo class="h-10 w-10" />
                                </div>
                            @endif
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent pointer-events-none">
                            </div>
                        </div>
                    @endif

                    {{-- Content Card --}}
                    <div
                        class="relative z-10 bg-white rounded-2xl p-4 text-center flex flex-col items-center justify-center flex-1 transition-all duration-300 group-hover:border-primary-200 group-hover:shadow-zinc-300/60 {{ $showImage ? '-mt-12 mx-5 pt-8 pb-5' : 'mt-0 pt-8 pb-8' }}">

                        {{-- Circular Icon Badge (Dynamic DB icon with white filter color) --}}
                        <div class="absolute -top-6 left-1/2 -translate-x-1/2 flex h-11 w-11 items-center justify-center rounded-full border-[3px] border-white text-white shadow-md z-20 transition-transform duration-300 group-hover:scale-105"
                            style="background-color: {{ setting('primary_color', '#F5A21C') }};">
                            @if($service->icon)
                                <img src="{{ asset('storage/' . $service->icon) }}" alt="{{ $service->name }} Icon"
                                    loading="lazy" class="h-5 w-5 object-contain brightness-0 invert" />
                            @else
                                {{-- Default Fallback Icon --}}
                                <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                    stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            @endif
                        </div>

                        {{-- Title (Matching dark theme color with dynamic primary color hover) --}}
                        <h3
                            class="text-base sm:text-lg font-extrabold text-zinc-955 leading-snug tracking-tight transition-colors group-hover:text-primary-900 {{ $showDesc ? 'mb-2' : 'mb-0' }}">
                            {{ $service->name }}
                        </h3>

                        {{-- Description --}}
                        @if($showDesc)
                            <p class="text-xs sm:text-sm leading-relaxed text-zinc-500 flex-1">
                                {{ strip_tags($service->description) }}
                            </p>
                        @endif
                    </div>
                </article>
            @empty
                <p class="text-center text-zinc-500 col-span-full">
                    Belum ada layanan.
                </p>
            @endforelse

        </div>

        {{-- CTA BUTTON --}}
        <!-- <div class="mt-20 text-center">
            <a href="{{ route('services.index') }}" class="inline-flex items-center gap-2
                       rounded-xl
                       bg-primary-900 text-white
                       px-7 py-3.5
                       text-sm sm:text-base
                       font-bold
                       shadow-md shadow-primary-900/10
                       hover:bg-primary-800 hover:-translate-y-0.5
                       active:translate-y-0
                       transition-all duration-200">
                {{ strip_tags(setting('cta_service', 'Lihat Semua Layanan')) }}
                <x-heroicon-o-arrow-right class="h-4 w-4" />
            </a>
        </div> -->

    </div>
</section>

{{-- ================= FADE ANIMATION ================= --}}
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const elements = document.querySelectorAll(".fade-slide");

        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.remove("opacity-0", "translate-y-4");
                    entry.target.classList.add("opacity-100", "translate-y-0");
                    entry.target.style.transition =
                        "all 0.7s cubic-bezier(0.4, 0, 0.2, 1)";
                }
            });
        }, {
            threshold: 0.1
        });

        elements.forEach(el => observer.observe(el));
    });
</script>
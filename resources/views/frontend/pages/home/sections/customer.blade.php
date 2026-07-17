<section class="py-8 sm:py-10 lg:py-12 bg-white relative overflow-hidden select-none">

    {{-- Subtle glowing background backing --}}
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-primary-900/5 rounded-full blur-[150px] pointer-events-none"></div>

    <div class="mx-auto max-w-7xl px-6 sm:px-12 lg:px-20 relative z-10">

        {{-- HEADER --}}
        <div class="mx-auto max-w-2xl text-center mb-10">

            {{-- BADGE --}}
            @if(setting('customer_badge'))
                <span class="inline-flex items-center rounded-full
                           bg-zinc-100 border border-zinc-200/40
                           px-3.5 py-1
                           text-xs font-semibold tracking-wide
                           text-zinc-900">
                    {{ strip_tags(setting('customer_badge')) }}
                </span>
            @endif

            {{-- TITLE --}}
            <h2 class="mt-5
                       text-2xl sm:text-3xl lg:text-4xl
                       font-extrabold tracking-tight leading-tight
                       text-zinc-950">
                {{ strip_tags(setting('customer_title', 'Dipercaya oleh Partner Terbaik')) }}
            </h2>

            {{-- DESCRIPTION --}}
            <p class="mt-4
                       text-sm sm:text-base lg:text-lg
                       leading-relaxed
                       text-zinc-650">
                {{ strip_tags(setting('customer_subtitle', 'Berbagai industri telah merasakan dampak positif dari solusi yang dihadirkan Herro')) }}
            </p>
        </div>

        {{-- CUSTOMER LOGOS SMOOTH MARQUEE SLIDER (Pure CSS Marquee - Smooth & Bug-free) --}}
        @if($partners->count() > 0)
            <div class="relative w-full overflow-hidden py-4">
                
                {{-- Left & Right Blur Overlays for Premium Cinematic Fade --}}
                <div class="absolute left-0 top-0 bottom-0 w-16 sm:w-32 bg-gradient-to-r from-white to-transparent z-20 pointer-events-none"></div>
                <div class="absolute right-0 top-0 bottom-0 w-16 sm:w-32 bg-gradient-to-l from-white to-transparent z-20 pointer-events-none"></div>

                {{-- Marquee Track Container --}}
                <div class="w-full overflow-hidden select-none">
                    <div class="flex gap-6 py-2 marquee-track hover:[animation-play-state:paused]">
                        
                        {{-- First Loop --}}
                        @foreach ($partners as $partner)
                            <div class="flex-shrink-0 flex justify-center items-center">
                                <div class="group h-20 w-44 sm:h-24 sm:w-52 px-6 sm:px-8 bg-white border border-zinc-200/60 rounded-2xl flex items-center justify-center shadow-sm transition-all duration-300 hover:shadow-md hover:border-primary-400/40 select-none">
                                    <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }}" loading="lazy"
                                        class="max-w-[120px] sm:max-w-[145px] max-h-[44px] sm:max-h-[52px] object-contain opacity-95 group-hover:opacity-100 transition-all duration-300" />
                                </div>
                            </div>
                        @endforeach

                        {{-- Second Loop for Seamless Loop Effect --}}
                        @foreach ($partners as $partner)
                            <div class="flex-shrink-0 flex justify-center items-center">
                                <div class="group h-20 w-44 sm:h-24 sm:w-52 px-6 sm:px-8 bg-white border border-zinc-200/60 rounded-2xl flex items-center justify-center shadow-sm transition-all duration-300 hover:shadow-md hover:border-primary-400/40 select-none">
                                    <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }}" loading="lazy"
                                        class="max-w-[120px] sm:max-w-[145px] max-h-[44px] sm:max-h-[52px] object-contain opacity-95 group-hover:opacity-100 transition-all duration-300" />
                                </div>
                            </div>
                        @endforeach

                        {{-- Third Loop (For very wide screens) --}}
                        @foreach ($partners as $partner)
                            <div class="flex-shrink-0 flex justify-center items-center">
                                <div class="group h-20 w-44 sm:h-24 sm:w-52 px-6 sm:px-8 bg-white border border-zinc-200/60 rounded-2xl flex items-center justify-center shadow-sm transition-all duration-300 hover:shadow-md hover:border-primary-400/40 select-none">
                                    <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }}" loading="lazy"
                                        class="max-w-[120px] sm:max-w-[145px] max-h-[44px] sm:max-h-[52px] object-contain opacity-95 group-hover:opacity-100 transition-all duration-300" />
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        @else
            <p class="text-center text-zinc-400 text-sm">
                Belum ada data customer.
            </p>
        @endif

    </div>
</section>

{{-- Custom CSS for Constant Velocity Smooth Marquee --}}
<style>
    @keyframes marqueeScroll {
        0% {
            transform: translateX(0);
        }
        100% {
            /* Moves the width of one loop segment (33.333%) perfectly */
            transform: translateX(calc(-33.3333% - 8px));
        }
    }

    .marquee-track {
        display: flex;
        width: max-content;
        animation: marqueeScroll 25s linear infinite;
        will-change: transform;
    }
</style>

<div x-data="{ showScrollTop: false }" @scroll.window="showScrollTop = (window.pageYOffset > 400)"
    class="fixed z-50 bottom-28 right-4 md:bottom-6 md:right-6 flex flex-col items-center gap-3 select-none pointer-events-auto">

    <!-- BACK TO TOP BUTTON WITH CIRCULAR PROGRESS -->
    <div x-show="showScrollTop" x-cloak
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-2 scale-90"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-2 scale-90"
        class="relative flex items-center justify-center bg-white rounded-full shadow-lg border border-zinc-200/50 hover:border-zinc-300/80 transition-all duration-200 transform hover:scale-105"
        style="width: 40px; height: 40px;"
        x-data="{ progress: 0 }"
        @scroll.window="
            const scrollHeight = document.documentElement.scrollHeight - window.innerHeight;
            progress = scrollHeight > 0 ? (window.pageYOffset / scrollHeight) * 100 : 0;
        ">
        
        <!-- CIRCULAR PROGRESS SVG -->
        <svg class="absolute inset-0 w-full h-full -rotate-90 pointer-events-none p-0.5" viewBox="0 0 36 36">
            <!-- Background grey circle -->
            <circle cx="18" cy="18" r="16" fill="none" stroke="#f4f4f5" stroke-width="2" class="opacity-100" />
            <!-- Active progress circle -->
            <circle cx="18" cy="18" r="16" fill="none" stroke="{{ setting('primary_color', '#F5A21C') }}" stroke-width="2.2"
                stroke-dasharray="100"
                :stroke-dashoffset="100 - progress"
                stroke-linecap="round"
                class="transition-all duration-75" />
        </svg>

        <!-- BUTTON INNER ARROW -->
        <button @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
            class="flex items-center justify-center rounded-full text-zinc-650 hover:text-zinc-900 active:scale-95 transition-all duration-200 z-10"
            style="width: 30px; height: 30px;"
            title="Kembali ke Atas"
            aria-label="Kembali ke atas">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3.2" stroke="currentColor"
                class="h-4 w-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
            </svg>
        </button>
    </div>

    <!-- FLOATING WHATSAPP -->
    <div x-data="waFloat" x-init="init()" x-show="show" x-cloak x-transition.opacity.duration.200ms
        class="relative flex items-center justify-end h-[56px] w-[56px]">

        <!-- TEXT POPUP CAPSULE WITH COMPILER-PROOF NATIVE CSS TRANSITIONS -->
        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', setting('whatsapp_number', '6281234567890')) }}"
            target="_blank"
            :class="showText ? 'opacity-100 translate-x-0 scale-100 pointer-events-auto' : 'opacity-0 translate-x-8 scale-90 pointer-events-none'"
            style="transition: all 0.8s cubic-bezier(0.34, 1.56, 0.64, 1);"
            class="absolute right-[68px] top-1/2 -translate-y-1/2 wa-text-capsule flex-col bg-[#15a847] hover:bg-[#128c3a] text-white px-5 py-2.5 rounded-[1.25rem] shadow-lg transform leading-tight whitespace-nowrap"
            aria-label="Konsultasi WhatsApp">
            <span class="text-[11px] font-normal text-white/90">Ada pertanyaan?</span>
            <span class="text-[13px] sm:text-[14px] font-bold mt-0.5">Yuk konsultasi sekarang!</span>
        </a>

        <!-- FLOAT WRAPPER -->
        <button type="button" aria-label="Chat via WhatsApp" @click="window.open(
                    'https://wa.me/{{ preg_replace('/[^0-9]/', '', setting('whatsapp_number', '6281234567890')) }}',
                    '_blank'
                )" class="wa-float-wrapper flex-shrink-0 relative z-10 focus:outline-none">
            <!-- WA ICON -->
            <img src="{{ setting('icon_whatsapp')
    ? asset('storage/' . setting('icon_whatsapp'))
    : asset('default-wa-icon.png') }}" alt="Chat via WhatsApp" class="wa-float-img">
        </button>
    </div>
</div>

<style>
    .wa-text-capsule {
        display: none !important;
    }
    @media (min-width: 768px) {
        .wa-text-capsule {
            display: flex !important;
        }
    }
</style>
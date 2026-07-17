@php
    $primaryColor = setting('primary_color', '#F5A21C');
@endphp
<section class="pt-12 pb-6 sm:pt-12 sm:pb-8 bg-white relative overflow-hidden">

    <div class="mx-auto max-w-7xl px-6 sm:px-12 lg:px-20 relative z-10">
        {{-- Steps Grid with Connection Line --}}
        <div class="relative">
            {{-- Horizontal Connection Line (Desktop only) --}}
            <div class="hidden lg:block absolute top-[44px] left-[12%] right-[12%] h-0.5 bg-zinc-100 z-0">
                <div class="absolute inset-0 bg-gradient-to-r from-primary-900 to-amber-500 w-0 transition-all duration-1000"
                    id="stepProgressLine" style="width: 100%;"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 relative z-10">
                {{-- STEP 1 --}}
                <a href="#dssSection" class="group flex flex-col items-center text-center focus:outline-none">
                    {{-- Step Icon Circle --}}
                    <div
                        class="relative flex items-center justify-center w-20 h-20 rounded-2xl bg-zinc-50 border border-zinc-200/80 shadow-sm transition-all duration-300 group-hover:scale-105 group-hover:border-primary-900/30 group-hover:shadow-md group-hover:shadow-primary-900/5">
                        <span
                            class="absolute -top-2.5 -right-2.5 flex items-center justify-center w-7 h-7 rounded-full bg-zinc-950 text-white text-xs font-bold ring-4 ring-white">
                            01
                        </span>
                        <svg class="w-8 h-8 text-primary-900" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m4-3H6" />
                        </svg>
                    </div>
                    <h3
                        class="mt-5 text-base sm:text-lg font-bold text-zinc-955 group-hover:text-primary-900 transition-colors">
                        Pilih Unit Alat
                    </h3>
                    <p class="mt-2 text-xs sm:text-sm text-zinc-500 leading-relaxed px-4">
                        Pilih unit yang sesuai lewat katalog kami atau dengan fitur rekomendasi kami.
                    </p>
                </a>

                {{-- STEP 2 --}}
                <div class="group flex flex-col items-center text-center">
                    {{-- Step Icon Circle --}}
                    <div
                        class="relative flex items-center justify-center w-20 h-20 rounded-2xl bg-zinc-50 border border-zinc-200/80 shadow-sm transition-all duration-300 group-hover:scale-105 group-hover:border-primary-900/30 group-hover:shadow-md group-hover:shadow-primary-900/5">
                        <span
                            class="absolute -top-2.5 -right-2.5 flex items-center justify-center w-7 h-7 rounded-full bg-zinc-950 text-white text-xs font-bold ring-4 ring-white">
                            02
                        </span>
                        <svg class="w-8 h-8 text-primary-900" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3
                        class="mt-5 text-base sm:text-lg font-bold text-zinc-950 group-hover:text-primary-900 transition-colors">
                        Ajukan Penawaran
                    </h3>
                    <p class="mt-2 text-xs sm:text-sm text-zinc-500 leading-relaxed px-4">
                        Hubungi sales untuk memperoleh proposal harga sewa bersaing.
                    </p>
                </div>

                {{-- STEP 3 --}}
                <div class="group flex flex-col items-center text-center">
                    {{-- Step Icon Circle --}}
                    <div
                        class="relative flex items-center justify-center w-20 h-20 rounded-2xl bg-zinc-50 border border-zinc-200/80 shadow-sm transition-all duration-300 group-hover:scale-105 group-hover:border-primary-900/30 group-hover:shadow-md group-hover:shadow-primary-900/5">
                        <span
                            class="absolute -top-2.5 -right-2.5 flex items-center justify-center w-7 h-7 rounded-full bg-zinc-950 text-white text-xs font-bold ring-4 ring-white">
                            03
                        </span>
                        <svg class="w-8 h-8 text-primary-900" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125a1.125 1.125 0 0 0 1.125-1.125V9.75M3.75 14.25h16.5M3.75 14.25V7.5a1.5 1.5 0 0 1 1.5-1.5h10.086a1.5 1.5 0 0 1 1.06.44l2.442 2.44a1.5 1.5 0 0 1 .44 1.06v4.81" />
                        </svg>
                    </div>
                    <h3
                        class="mt-5 text-base sm:text-lg font-bold text-zinc-950 group-hover:text-primary-900 transition-colors">
                        Pengiriman Unit
                    </h3>
                    <p class="mt-2 text-xs sm:text-sm text-zinc-500 leading-relaxed px-4">
                        Armada akan diantar langsung ke lokasi pabrik atau gudang Anda dengan aman.
                    </p>
                </div>

                {{-- STEP 4 --}}
                <div class="group flex flex-col items-center text-center">
                    {{-- Step Icon Circle --}}
                    <div
                        class="relative flex items-center justify-center w-20 h-20 rounded-2xl bg-zinc-50 border border-zinc-200/80 shadow-sm transition-all duration-300 group-hover:scale-105 group-hover:border-primary-900/30 group-hover:shadow-md group-hover:shadow-primary-900/5">
                        <span
                            class="absolute -top-2.5 -right-2.5 flex items-center justify-center w-7 h-7 rounded-full bg-zinc-950 text-white text-xs font-bold ring-4 ring-white">
                            04
                        </span>
                        <x-heroicon-o-wrench class="w-8 h-8 text-primary-900" />
                    </div>
                    <h3
                        class="mt-5 text-base sm:text-lg font-bold text-zinc-950 group-hover:text-primary-900 transition-colors">
                        Layanan Maintenance
                    </h3>
                    <p class="mt-2 text-xs sm:text-sm text-zinc-500 leading-relaxed px-4">
                        Nikmati garansi servis berkala gratis dan dukungan teknisi demi kelancaran operasional.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
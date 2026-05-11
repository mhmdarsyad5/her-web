@extends('frontend.layouts.app')

@section('title', $pageTitle ?? strip_tags(setting('site_name')))

@section('content')

{{-- Breadcrumb --}}
@include('frontend.components.breadcrumb')

{{-- ================= ABOUT HERO ================= --}}
<div class="bg-gradient-to-br from-zinc-50 to-zinc-100 border-b border-zinc-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">

        {{-- Logo --}}
        <div class="fade-slide opacity-0 translate-y-4 flex justify-center mb-6">
            <img
                src="{{ setting_url('logo_light') }}"
                alt="{{ strip_tags($siteName ?? 'Website') }} Logo"
                class="h-12 sm:h-16 lg:h-20 w-auto"
                fetchpriority="high">
        </div>

        {{-- Badge --}}
        <div class="fade-slide opacity-0 translate-y-4 flex justify-center mb-3">
            <span class="inline-flex items-center rounded-full
                           bg-primary-900/10
                           px-4 py-1
                           text-xs font-semibold tracking-widest uppercase
                           text-primary-900">
                {{ strip_tags(setting('about_badge', 'Tentang Kami')) }}
            </span>
        </div>

        {{-- Title --}}
        <div class="fade-slide opacity-0 translate-y-4 text-center mb-5">
            <h1 class="text-2xl sm:text-3xl lg:text-4xl
                       font-bold tracking-tight
                       text-zinc-900">
                {{ $siteName }}
            </h1>
            <div class="mt-2.5 mx-auto w-14 h-0.5 bg-primary-900 rounded-full"></div>
        </div>

        {{-- About Text --}}
        <div class="fade-slide opacity-0 translate-y-4 max-w-2xl mx-auto text-center">
            <p class="text-sm sm:text-base leading-relaxed text-zinc-600">
                {{ $aboutText }}
            </p>
        </div>
    </div>
</div>

{{-- ================= HISTORY ================= --}}
<div class="bg-white py-12 lg:py-14">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="fade-slide opacity-0 translate-y-4
                    text-sm sm:text-base
                    text-zinc-600
                    leading-relaxed
                    [&_p]:mb-4
                    [&_strong]:text-zinc-800 [&_strong]:font-semibold
                    [&_ul]:mb-4 [&_ul]:pl-5 [&_ul]:list-disc
                    [&_ol]:mb-4 [&_ol]:pl-5 [&_ol]:list-decimal">
            {!! $historyText !!}
        </div>
    </div>
</div>

{{-- ================= VISION & MISSION ================= --}}
<div class="bg-zinc-50 py-12 lg:py-14 border-t border-zinc-200">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Section Header --}}
        <div class="fade-slide opacity-0 translate-y-4 text-center mb-8">
            <h2 class="text-xl sm:text-2xl font-bold text-zinc-900">Tujuan Kami</h2>
            <p class="mt-1.5 text-sm text-zinc-400">Visi & Misi Perusahaan</p>
        </div>

        {{-- Cards Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 lg:gap-6">

            {{-- VISION --}}
            <div class="fade-slide opacity-0 translate-y-4
                       rounded-2xl border border-zinc-200
                       bg-white p-6 lg:p-7
                       shadow-sm">

                {{-- Header --}}
                <div class="flex items-center gap-2.5 mb-4">
                    <div class="w-8 h-8 rounded-full bg-primary-900/10 flex items-center justify-center flex-shrink-0">
                        <svg class="w-3.5 h-3.5 text-primary-900" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-zinc-900">Visi</h3>
                        <p class="text-xs text-zinc-400">Pandangan jangka panjang</p>
                    </div>
                </div>

                <div class="h-px bg-zinc-100 mb-4"></div>

                <div class="text-xs sm:text-sm text-zinc-600 leading-relaxed
                            [&_p]:mb-3 [&_p:last-child]:mb-0
                            [&_strong]:text-zinc-800 [&_strong]:font-semibold">
                    {!! $visionText !!}
                </div>
            </div>

            {{-- MISSION --}}
            <div class="fade-slide opacity-0 translate-y-4
                       rounded-2xl border border-zinc-200
                       bg-white p-6 lg:p-7
                       shadow-sm">

                {{-- Header --}}
                <div class="flex items-center gap-2.5 mb-4">
                    <div class="w-8 h-8 rounded-full bg-primary-900/10 flex items-center justify-center flex-shrink-0">
                        <svg class="w-3.5 h-3.5 text-primary-900" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-zinc-900">Misi</h3>
                        <p class="text-xs text-zinc-400">Langkah nyata kami</p>
                    </div>
                </div>

                <div class="h-px bg-zinc-100 mb-4"></div>

                <style>
                    .mission-list ol { counter-reset: mission-item; list-style: none; padding: 0; margin: 0; }
                    .mission-list ol > li { counter-increment: mission-item; display: flex; align-items: flex-start; gap: 0.625rem; margin-bottom: 0.5rem; }
                    .mission-list ol > li::before {
                        content: counter(mission-item);
                        display: inline-flex;
                        align-items: center; justify-content: center;
                        min-width: 1.375rem; height: 1.375rem;
                        border-radius: 9999px;
                        border: 1.5px solid #d4d4d8;
                        color: #52525b;
                        font-size: 0.625rem; font-weight: 700;
                        flex-shrink: 0; margin-top: 0.0625rem;
                    }
                    .mission-list ol > li:last-child { margin-bottom: 0; }
                </style>
                <div class="mission-list text-xs sm:text-sm text-zinc-600 leading-relaxed">
                    {!! $missionText !!}
                </div>
            </div>

        </div>
    </div>
</div>

{{-- ================= ANIMATION ================= --}}
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const elements = document.querySelectorAll(".fade-slide");
        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.remove("opacity-0", "translate-y-4");
                    entry.target.classList.add("opacity-100", "translate-y-0");
                    entry.target.style.transition = "all 0.6s cubic-bezier(0.4, 0, 0.2, 1)";
                }
            });
        }, { threshold: 0.1, rootMargin: "0px 0px -20px 0px" });
        elements.forEach(el => observer.observe(el));
    });
</script>

@endsection
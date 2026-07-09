@extends('frontend.layouts.app')

@section('title', $pageTitle)

@section('content')

{{-- Breadcrumb --}}
@include('frontend.components.breadcrumb')

<div class="relative overflow-hidden bg-zinc-50 pt-6 pb-12 sm:pt-8 sm:pb-16">
    {{-- Decorative Background Glows --}}
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-7xl h-full -z-10 pointer-events-none">
        <div class="absolute top-[-10%] right-[-10%] w-[500px] h-[500px] rounded-full bg-primary-900/5 blur-[120px]"></div>
        <div class="absolute bottom-[10%] left-[-10%] w-[400px] h-[400px] rounded-full bg-primary-900/5 blur-[100px]"></div>
    </div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Document Header --}}
        <div class="mb-12 text-center fade-slide opacity-0 translate-y-4">
            <h1 class="text-3xl font-extrabold tracking-tight text-zinc-900 sm:text-4xl lg:text-5xl mb-4">
                {{ $title }}
            </h1>
            
            <div class="flex items-center justify-center gap-2">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-zinc-100 text-zinc-800 ring-1 ring-inset ring-zinc-500/10">
                    Resmi
                </span>
                <span class="text-sm text-zinc-500">
                    &bull;
                </span>
                <span class="text-sm text-zinc-500">
                    Terakhir Diperbarui: {{ now()->translatedFormat('d F Y') }}
                </span>
            </div>
        </div>

        {{-- The Document Card --}}
        <div class="relative fade-slide opacity-0 translate-y-8">
            <div class="bg-white rounded-2xl shadow-xl shadow-zinc-200/50 border border-zinc-200 p-8 sm:p-12 lg:p-16">
                <div class="prose-legal">
                    {!! $termsText !!}
                </div>
            </div>
        </div>

    </div>
</div>

{{-- Animation script remained unchanged --}}
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const elements = document.querySelectorAll(".fade-slide");
        
        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.remove("opacity-0", "translate-y-4", "translate-y-8");
                    entry.target.classList.add("opacity-100", "translate-y-0");
                    entry.target.style.transition = "all 0.8s cubic-bezier(0.2, 0.8, 0.2, 1)";
                }
            });
        }, { threshold: 0.1 });

        elements.forEach(el => observer.observe(el));
    });
</script>

@endsection

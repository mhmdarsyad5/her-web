@extends('frontend.layouts.app')

@section('title', strip_tags($title) . ' - ' . strip_tags(setting('site_name')))
@section('description', 'Temukan jawaban atas pertanyaan umum mengenai proses sewa alat berat, syarat, biaya, serta sistem operasional di Herro Equipment Rentals.')

@section('content')

{{-- Breadcrumb --}}
@include('frontend.components.breadcrumb', [
'title' => $title
])

<section class="pt-6 pb-12 sm:pt-8 sm:pb-16 bg-white">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- ================= HEADER ================= --}}
        <div class="mb-14 text-center fade-slide opacity-0 translate-y-4">

            {{-- BADGE --}}
            <span class="inline-flex items-center rounded-full
                           bg-primary-100
                           px-3 py-1
                           text-xs font-medium tracking-wide
                           text-primary-800">
                {{ strip_tags(setting('faq_badge', 'FAQ')) }}
            </span>

            {{-- TITLE --}}
            <h1 class="mt-4
                       text-2xl sm:text-3xl lg:text-3xl
                       font-bold tracking-tight
                       text-zinc-900">
                {{ strip_tags(setting(
                    'faq_title',
                    'Pertanyaan yang Sering Diajukan'
                )) }}
            </h1>

            {{-- SUBTITLE --}}
            <p class="mt-3
                       max-w-2xl mx-auto
                       text-sm sm:text-base
                       text-zinc-600">
                {{ strip_tags(setting(
                    'faq_subtitle',
                    'Temukan jawaban atas pertanyaan umum seputar layanan, proses, dan penggunaan website kami.'
                )) }}
            </p>
        </div>

        {{-- ================= FAQ LIST ================= --}}
        <div class="space-y-4 sm:space-y-6 fade-slide opacity-0 translate-y-4">

            @forelse ($faqs as $faq)
            <details class="group rounded-xl border
                            border-zinc-200
                            bg-white
                            p-5 sm:p-6
                            transition-all duration-300
                            hover:-translate-y-0.5 hover:shadow-md
                            hover:border-primary-300
                            focus-within:ring-2 focus-within:ring-primary-500/30">

                {{-- QUESTION --}}
                <summary class="flex cursor-pointer list-none items-center justify-between">

                        {{ $faq->question }}
                    </h3>

                    {{-- ICON --}}
                    <span class="ml-4 flex-shrink-0
                                 text-zinc-500
                                 transition-transform duration-300
                                 group-open:rotate-180
                                 group-open:text-primary-700">
                        <x-heroicon-o-chevron-down class="h-5 w-5" />
                    </span>
                </summary>

                {{-- ANSWER --}}
                <div class="mt-4
                            text-sm sm:text-base
                            leading-relaxed
                            text-zinc-600
                            prose prose-neutral max-w-none
                            prose-a:text-primary-700">
                    {!! $faq->answer !!}
                </div>

            </details>
            @empty

            {{-- EMPTY STATE --}}
            <div class="text-center py-20">
                <p class="text-sm sm:text-base text-zinc-600">
                    {{ strip_tags(setting(
                        'faq_empty_text',
                        'Belum ada pertanyaan yang tersedia saat ini.'
                    )) }}
                </p>
            </div>

            @endforelse

        </div>

        {{-- ================= PAGINATION ================= --}}
        @if(method_exists($faqs, 'links'))
        <div class="mt-14 fade-slide opacity-0 translate-y-4">
            {{ $faqs->links('pagination::tailwind') }}
        </div>
        @endif

    </div>
</section>

@endsection

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

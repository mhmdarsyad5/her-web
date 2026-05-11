@extends('frontend.layouts.app')

@section('title', strip_tags($title) . ' - ' . strip_tags(setting('site_name')))

@section('content')

{{-- Breadcrumb --}}
@include('frontend.components.breadcrumb')

<section
    class="py-20 lg:py-24 bg-white"
    x-data="serviceModal()"
    x-cloak>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- ================= HEADER ================= --}}
        <div class="mx-auto max-w-2xl text-center mb-16 fade-slide opacity-0 translate-y-4">

            {{-- BADGE --}}
            <span class="inline-flex items-center rounded-full
                           bg-primary-100
                           px-3 py-1
                           text-xs font-medium tracking-wide
                           text-primary-800">
                {{ strip_tags(setting('service_badge', 'Layanan Kami')) }}
            </span>

            {{-- TITLE --}}
            <h2 class="mt-4 text-xl sm:text-2xl lg:text-3xl
                       font-bold tracking-tight
                       text-zinc-900">
                {{ strip_tags(setting('title_section_service', 'Layanan yang Kami Sediakan')) }}
            </h2>

            {{-- DESCRIPTION --}}
            <p class="mt-4 text-sm sm:text-base
                       leading-relaxed
                       text-zinc-600">
                {{ strip_tags(setting(
                    'subtitle_section_service',
                    'Berbagai layanan profesional untuk mendukung kebutuhan bisnis dan transformasi digital Anda.'
                )) }}
            </p>
        </div>

        {{-- ================= SERVICES ================= --}}
        <div class="grid grid-cols-1 gap-4
                     sm:grid-cols-2 sm:gap-6
                     lg:grid-cols-2
                     fade-slide opacity-0 translate-y-4">

            @forelse ($services as $service)
            <article class="rounded-xl sm:rounded-2xl
                            border border-zinc-200
                            bg-white
                            p-4 sm:p-6
                            transition-all duration-300
                            hover:-translate-y-1
                            hover:shadow-lg
                            hover:border-primary-300
                            flex flex-col h-full">

                {{-- ICON --}}
                @if ($service->icon)
                <div class="mb-4 flex h-10 w-10 sm:h-11 sm:w-11
                             items-center justify-center
                             rounded-lg border
                             border-zinc-200
                             bg-primary-100
                             ring-1 ring-primary-200">
                    <img
                        src="{{ asset('storage/' . $service->icon) }}"
                        alt="{{ $service->name }}"
                        loading="lazy"
                        class="h-5 w-5 sm:h-6 sm:w-6 object-contain" />
                </div>
                @endif

                {{-- TITLE --}}
                <h3 class="text-base sm:text-lg
                           font-semibold
                           text-zinc-900">
                    {{ $service->name }}
                </h3>

                {{-- DESCRIPTION --}}
                <p class="mt-2 text-sm leading-relaxed line-clamp-3 text-zinc-700">
                    {{ \Illuminate\Support\Str::limit(
                        strip_tags($service->description),
                        160
                    ) }}
                </p>

                {{-- CTA --}}
                <button
                    class="mt-auto pt-4 inline-flex items-center gap-1.5
                           text-sm font-medium
                           text-primary-700
                           hover:text-primary-900
                           transition-colors"
                    @click="openModal(
                        `{{ $service->name }}`,
                        `{!! addslashes($service->description) !!}`,
                        `{{ $service->image ? asset('storage/' . $service->image) : '' }}`
                    )">
                    {{ strip_tags(setting('service_cta_modal', 'Selengkapnya')) }}
                    <span class="transition-transform group-hover:translate-x-0.5">→</span>
                </button>

            </article>

            @empty
            <div class="col-span-full text-center py-20 w-full">
                <p class="text-sm lg:text-base text-zinc-600">
                    Belum ada layanan yang tersedia.
                </p>
            </div>
            @endforelse

        </div>

        {{-- ================= PAGINATION ================= --}}
        <div class="mt-14 fade-slide opacity-0 translate-y-4">
            {{ $services->links('pagination::tailwind') }}
        </div>

    </div>

    {{-- ================= MODAL ================= --}}
    <div
        x-show="show"
        x-transition.opacity
        class="fixed inset-0 bg-black/60 backdrop-blur-sm
               z-[9999] flex items-center justify-center p-4">

        <div
            x-show="show"
            x-transition
            @click.away="closeModal"
            class="relative bg-white
                   rounded-2xl shadow-2xl
                   w-full max-w-3xl
                   max-h-[85vh]
                   overflow-y-auto
                   p-5 sm:p-6 lg:p-8">

            {{-- CLOSE --}}
            <button
                class="absolute top-4 right-4
                       h-9 w-9 flex items-center justify-center rounded-full
                       bg-zinc-100
                       text-zinc-600
                       hover:bg-zinc-200
                       transition"
                @click="closeModal">
                ✕
            </button>

            {{-- IMAGE --}}
            <template x-if="image">
                <div class="-mt-5 sm:-mt-6 lg:-mt-8 mb-6 -mx-5 sm:-mx-6 lg:-mx-8 first:mt-0">
                    <img
                        :src="image"
                        class="w-full h-64 sm:h-80 object-cover rounded-t-2xl">
                </div>
            </template>

            {{-- TITLE --}}
            <h2 class="mb-4 text-lg lg:text-xl
                       font-bold tracking-tight
                       text-zinc-900"
                x-text="title"></h2>

            {{-- CONTENT --}}
            <div class="prose prose-sm sm:prose-base max-w-none
                        text-zinc-700"
                 x-html="description">
            </div>

        </div>
    </div>

</section>

@endsection

{{-- Fade Animation --}}
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

{{-- Modal Alpine Component --}}
<script>
    function serviceModal() {
        return {
            show: false,
            title: '',
            description: '',
            image: '',

            openModal(title, description, image) {
                this.title = title;
                this.description = description;
                this.image = image || '';
                this.show = true;
                document.body.classList.add("overflow-hidden");
            },

            closeModal() {
                this.show = false;
                document.body.classList.remove("overflow-hidden");
            }
        }
    }
</script>

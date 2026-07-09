@extends('frontend.layouts.app')

@section(
'title',
strip_tags(setting('gallery_title', 'Galeri'))
. ' - '
. strip_tags(setting('site_name', 'mulaidigital.com'))
)

@section('content')

{{-- ================= BREADCRUMB ================= --}}
@include('frontend.components.breadcrumb')

<section class="pt-6 pb-12 sm:pt-8 sm:pb-16 bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        {{-- ================= HEADER ================= --}}
        <div class="mb-12 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between
                     fade-slide opacity-0 translate-y-4">

            <div>
                {{-- BADGE --}}
                <span class="inline-flex items-center rounded-full
                               bg-primary-100
                               px-3 py-1
                               text-xs font-medium tracking-wide
                               text-primary-800">
                    {{ strip_tags(setting('gallery_badge', 'Galeri')) }}
                </span>

                {{-- TITLE --}}
                <h1 class="mt-4
                           text-2xl sm:text-3xl lg:text-3xl
                           font-bold tracking-tight
                           text-zinc-900">
                    {{ strip_tags(setting('gallery_title', 'Dokumentasi & Momen')) }}
                </h1>

                {{-- DESCRIPTION --}}
                <p class="mt-2 max-w-xl
                           text-sm sm:text-base
                           text-zinc-600">
                    {{ strip_tags(
                        setting(
                            'gallery_description',
                            'Kumpulan dokumentasi kegiatan, proyek, dan momen terbaik kami.'
                        )
                    ) }}
                </p>
            </div>
        </div>

        {{-- ================= SEARCH ================= --}}
        <div class="mb-12 fade-slide opacity-0 translate-y-4">
            <div class="relative max-w-md">
                <input
                    type="text"
                    id="searchInput"
                    placeholder="{{ strip_tags(setting('gallery_search_placeholder', 'Cari galeri...')) }}"
                    class="w-full rounded-xl border
                           border-zinc-300
                           bg-white
                           px-4 py-3 pl-10
                           text-sm sm:text-base
                           text-zinc-900
                           placeholder:text-zinc-400
                           focus:outline-none
                           focus:ring-2 focus:ring-primary-500/30
                           transition">

                <x-heroicon-o-magnifying-glass
                    class="absolute left-3 top-3.5 h-5 w-5
                           text-zinc-500" />
            </div>
        </div>

        {{-- ================= GALLERY GRID ================= --}}
        <div
            id="galleryGrid"
            class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3
                   gap-6 lg:gap-8
                   fade-slide opacity-0 translate-y-4">

            @include('frontend.pages.gallery.partials.gallery-list', [
            'galleries' => $galleries
            ])

        </div>

        {{-- ================= PAGINATION ================= --}}
        <div id="paginationWrapper" class="mt-14 fade-slide opacity-0 translate-y-4">
            {{ $galleries->links('pagination::tailwind') }}
        </div>

    </div>
</section>

@endsection

@push('scripts')
{{-- ================= AJAX SEARCH ================= --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {

        const searchInput = document.getElementById('searchInput');
        const galleryGrid = document.getElementById('galleryGrid');
        const paginationWrapper = document.getElementById('paginationWrapper');

        let timer;

        if (!searchInput) return;

        searchInput.addEventListener('keyup', () => {
            clearTimeout(timer);

            timer = setTimeout(() => {
                const keyword = searchInput.value.trim();

                // Skeleton loading
                fetch('{{route('galleries.search.skeleton') }}')
                    .then(res => res.text())
                    .then(html => {
                        galleryGrid.innerHTML = html;
                        paginationWrapper.innerHTML = '';
                    });

                // Actual search
                fetch(`{{ route('galleries.search') }}?keyword=${encodeURIComponent(keyword)}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.html?.trim()) {
                            galleryGrid.innerHTML = data.html;
                            paginationWrapper.innerHTML = data.pagination ?? '';
                        } else {
                            galleryGrid.innerHTML = data.empty || '<p class="col-span-full text-center text-zinc-500">Tidak ada hasil ditemukan.</p>';
                            paginationWrapper.innerHTML = '';
                        }
                    })
                    .catch(() => {
                        galleryGrid.innerHTML = '<p class="col-span-full text-center text-zinc-500">Gagal memuat galeri.</p>';
                    });

            }, 400);
        });

    });
</script>

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
@endpush

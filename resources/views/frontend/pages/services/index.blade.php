@extends('frontend.layouts.app')

@section('title', strip_tags($title) . ' - ' . strip_tags(setting('site_name')))
@section('description', 'Penyedia layanan sewa alat berat berkualitas untuk proyek logistik, konstruksi, dan pergudangan dengan unit forklift, crane, dll.')

@section('content')

{{-- Breadcrumb --}}
@include('frontend.components.breadcrumb')

{{-- DSS / SPK Section --}}
@include('frontend.pages.home.sections.dss')

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

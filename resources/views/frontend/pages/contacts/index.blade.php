@extends('frontend.layouts.app')

@section('title', $pageTitle)

@section('content')

    {{-- Breadcrumb --}}
    @include('frontend.components.breadcrumb')

    <!-- {{-- Google Maps --}}
    <div class="map w-full h-96">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6358.383713724025!2d106.74264113880913!3d-6.109899402633105!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6a1dca36259207%3A0x54c0df7074b21d11!2sPT%20Herro%20Dynamics%20Indonesia%20(PT%20HDI)!5e0!3m2!1sen!2sid!4v1705548787679!5m2!1sen!2sid"
            frameborder="0" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
            class="w-full h-full"></iframe>
    </div>End Google Maps -->

    <section class="bg-white py-16 sm:py-20 lg:py-28">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-start">

                {{-- LEFT --}}
                <div class="flex flex-col justify-center fade-slide opacity-0 translate-y-4">

                    {{-- BADGE --}}
                    <span class="mb-6 inline-flex w-fit rounded-full
                                   bg-primary-100
                                   px-3 py-1
                                   text-xs font-medium tracking-wide
                                   text-primary-800">
                        {{ $badge }}
                    </span>

                    {{-- TITLE --}}
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl
                               font-bold tracking-tight leading-tight
                               text-zinc-900">
                        <!-- {{ $title }} -->Konsultasikan Kebutuhan Equipment Anda
                    </h1>

                    {{-- DESC --}}
                    <p class="mt-4 max-w-md
                               text-sm sm:text-base
                               leading-relaxed
                               text-zinc-600">
                        <!-- {{ $description }} -->Tim kami siap membantu Anda menemukan solusi rental yang tepat untuk operasional Anda.
                    </p>

                    {{-- BRANCH CARDS --}}
                    <div class="mt-8 lg:mt-10 grid grid-cols-1 gap-4">
                        {{-- BRANCH 1 --}}
                        <div class="rounded-xl border border-zinc-200 bg-white p-4 shadow-sm hover:shadow-md transition-shadow">
                            <div class="flex flex-col sm:flex-row gap-4">
                                {{-- MAP --}}
                                <div class="flex-shrink-0 w-full sm:w-32 h-24 rounded-lg overflow-hidden">
                                    @php
                                        $mapUrl = setting_src('branch_1_map_url', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6358.383713724025!2d106.74264113880913!3d-6.109899402633105!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6a1dca36259207%3A0x54c0df7074b21d11!2sPT%20Herro%20Dynamics%20Indonesia%20(PT%20HDI)!5e0!3m2!1sen!2sid!4v1705548787679!5m2!1sen!2sid');
                                    @endphp
                                    @if($mapUrl && filter_var($mapUrl, FILTER_VALIDATE_URL))
                                        <iframe
                                            src="{{ $mapUrl }}"
                                            frameborder="0" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                                            class="w-full h-full"></iframe>
                                    @else
                                        <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-500 text-xs">
                                            Map tidak tersedia
                                        </div>
                                    @endif
                                </div>
                                {{-- INFO --}}
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm sm:text-base font-semibold text-zinc-900 mb-1">
                                        {{ strip_tags(setting('branch_1_name', 'Kantor Pusat Jakarta')) }}
                                    </h4>
                                    <p class="text-xs sm:text-sm text-zinc-600 mb-2">
                                        {{ strip_tags(setting('branch_1_address', 'Jl. Raya Jakarta No. 123, Jakarta Pusat')) }}
                                    </p>
                                    <div class="space-y-1">
                                        <p class="text-xs sm:text-sm text-zinc-700">
                                            <span class="font-medium">WhatsApp:</span>
                                            {{ strip_tags(setting('branch_1_whatsapp', '+62 812-3456-7890')) }}
                                        </p>
                                        <p class="text-xs sm:text-sm text-zinc-700">
                                            <span class="font-medium">Email:</span>
                                            {{ strip_tags(setting('branch_1_email', 'jakarta@herro.id')) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- BRANCH 2 --}}
                        <div class="rounded-xl border border-zinc-200 bg-white p-4 shadow-sm hover:shadow-md transition-shadow">
                            <div class="flex flex-col sm:flex-row gap-4">
                                {{-- MAP --}}
                                <div class="flex-shrink-0 w-full sm:w-32 h-24 rounded-lg overflow-hidden">
                                    @php
                                        $mapUrl = setting_src('branch_2_map_url', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.4!2d106.816666!3d-6.2!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f5e2b5c5c5c5%3A0x5c5c5c5c5c5c5c5!2sBogor%2C%20West%20Java!5e0!3m2!1sen!2sid!4v1705548787679!5m2!1sen!2sid');
                                    @endphp
                                    @if($mapUrl && filter_var($mapUrl, FILTER_VALIDATE_URL))
                                        <iframe
                                            src="{{ $mapUrl }}"
                                            frameborder="0" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                                            class="w-full h-full"></iframe>
                                    @else
                                        <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-500 text-xs">
                                            Map tidak tersedia
                                        </div>
                                    @endif
                                </div>
                                {{-- INFO --}}
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm sm:text-base font-semibold text-zinc-900 mb-1">
                                        {{ strip_tags(setting('branch_2_name', 'Cabang Bogor')) }}
                                    </h4>
                                    <p class="text-xs sm:text-sm text-zinc-600 mb-2">
                                        {{ strip_tags(setting('branch_2_address', 'Jl. Raya Bogor No. 456, Bogor')) }}
                                    </p>
                                    <div class="space-y-1">
                                        <p class="text-xs sm:text-sm text-zinc-700">
                                            <span class="font-medium">WhatsApp:</span>
                                            {{ strip_tags(setting('branch_2_whatsapp', '+62 811-2345-6789')) }}
                                        </p>
                                        <p class="text-xs sm:text-sm text-zinc-700">
                                            <span class="font-medium">Email:</span>
                                            {{ strip_tags(setting('branch_2_email', 'bogor@herro.id')) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- BRANCH 3 --}}
                        <div class="rounded-xl border border-zinc-200 bg-white p-4 shadow-sm hover:shadow-md transition-shadow">
                            <div class="flex flex-col sm:flex-row gap-4">
                                {{-- MAP --}}
                                <div class="flex-shrink-0 w-full sm:w-32 h-24 rounded-lg overflow-hidden">
                                    @php
                                        $mapUrl = setting_src('branch_3_map_url', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.4!2d107.6!3d-6.9!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e6398255c5c5%3A0x5c5c5c5c5c5c5c5!2sBandung%2C%20West%20Java!5e0!3m2!1sen!2sid!4v1705548787679!5m2!1sen!2sid');
                                    @endphp
                                    @if($mapUrl && filter_var($mapUrl, FILTER_VALIDATE_URL))
                                        <iframe
                                            src="{{ $mapUrl }}"
                                            frameborder="0" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                                            class="w-full h-full"></iframe>
                                    @else
                                        <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-500 text-xs">
                                            Map tidak tersedia
                                        </div>
                                    @endif
                                </div>
                                {{-- INFO --}}
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm sm:text-base font-semibold text-zinc-900 mb-1">
                                        {{ strip_tags(setting('branch_3_name', 'Cabang Bandung')) }}
                                    </h4>
                                    <p class="text-xs sm:text-sm text-zinc-600 mb-2">
                                        {{ strip_tags(setting('branch_3_address', 'Jl. Raya Bandung No. 789, Bandung')) }}
                                    </p>
                                    <div class="space-y-1">
                                        <p class="text-xs sm:text-sm text-zinc-700">
                                            <span class="font-medium">WhatsApp:</span>
                                            {{ strip_tags(setting('branch_3_whatsapp', '+62 813-4567-8901')) }}
                                        </p>
                                        <p class="text-xs sm:text-sm text-zinc-700">
                                            <span class="font-medium">Email:</span>
                                            {{ strip_tags(setting('branch_3_email', 'bandung@herro.id')) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- INFO --}}
                    <!-- <div class="mt-10 lg:mt-12">
                        <h3 class="mb-4 text-base sm:text-lg font-semibold tracking-tight
                                   text-zinc-900">
                            {{ strip_tags(setting('contact_info_title', 'Informasi Kontak')) }}
                        </h3>

                        <ul class="space-y-4 text-sm sm:text-base text-zinc-700">
                            <li>
                                <span class="font-medium">
                                    {{ strip_tags(setting('contact_label_whatsapp', 'WhatsApp')) }}:
                                </span>
                                {{ $whatsapp }}
                            </li>
                            <li>
                                <span class="font-medium">
                                    {{ strip_tags(setting('contact_label_email', 'Email')) }}:
                                </span>
                                {{ $email }}
                            </li>
                            <li>
                                <span class="font-medium">
                                    {{ strip_tags(setting('contact_label_address', 'Alamat')) }}:
                                </span>
                                {{ $address }}
                            </li>
                        </ul>
                    </div> -->
                </div>

                {{-- RIGHT — FORM --}}
                <div class="fade-slide opacity-0 translate-y-4
                           rounded-2xl border
                           border-zinc-200
                           bg-white
                           p-6 sm:p-8 lg:p-10
                           shadow-lg">

                    <form id="form" method="POST" action="{{ route('contact.store') }}" class="space-y-6 mb-10 ">
                        @csrf

                        {{-- NAME --}}
                        <div>
                            <label class="block mb-1.5 text-sm sm:text-base font-medium text-zinc-700">
                                {{ strip_tags(setting('contact_label_name', 'Nama')) }}
                            </label>
                            <input type="text" name="name" required
                                placeholder="{{ strip_tags(setting('contact_placeholder_name', 'Nama lengkap Anda')) }}"
                                class="w-full rounded-lg border border-zinc-300
                                       bg-white
                                       px-4 py-3.5 text-sm sm:text-base
                                       text-zinc-900
                                       placeholder:text-zinc-400
                                       focus:outline-none focus:ring-2 focus:ring-primary-500/30
                                       transition">
                        </div>

                        {{-- EMAIL --}}
                        <div>
                            <label class="block mb-1.5 text-sm sm:text-base font-medium text-zinc-700">
                                {{ strip_tags(setting('contact_label_email_form', 'Email')) }}
                            </label>
                            <input type="email" name="email" required
                                placeholder="{{ strip_tags(setting('contact_placeholder_email', 'contoh@mail.com')) }}"
                                class="w-full rounded-lg border border-zinc-300
                                       bg-white
                                       px-4 py-3.5 text-sm sm:text-base
                                       text-zinc-900
                                       placeholder:text-zinc-400
                                       focus:outline-none focus:ring-2 focus:ring-primary-500/30
                                       transition">
                        </div>

                        {{-- WHATSAPP --}}
                        <div>
                            <label class="block mb-1.5 text-sm sm:text-base font-medium text-zinc-700">
                                {{ strip_tags(setting('contact_label_whatsapp_form', 'Nomor WhatsApp')) }}
                            </label>
                            <input type="tel" name="whatsapp_number" required
                                placeholder="{{ strip_tags(setting('contact_placeholder_whatsapp', '+6281234567890')) }}"
                                class="w-full rounded-lg border border-zinc-300
                                       bg-white
                                       px-4 py-3.5 text-sm sm:text-base
                                       text-zinc-900
                                       placeholder:text-zinc-400
                                       focus:outline-none focus:ring-2 focus:ring-primary-500/30
                                       transition">
                        </div>

                        {{-- SUBJECT --}}
                        <div>
                            <label class="mb-1.5 block
                                           text-xs sm:text-sm
                                           font-medium
                                           text-zinc-700">
                                {{ strip_tags(setting('contact_label_subject', 'Subjek')) }}
                            </label>
                            <input type="text" name="subject"
                                placeholder="{{ strip_tags(setting('contact_placeholder_subject', 'Contoh: Kerja sama, Konsultasi')) }}"
                                class="w-full rounded-lg border border-zinc-300
                                       bg-white
                                       px-4 py-3.5
                                       text-sm sm:text-base
                                       leading-normal
                                       text-zinc-900
                                       placeholder:text-zinc-400
                                       focus:outline-none focus:ring-2 focus:ring-primary-500/30
                                       transition" />
                        </div>

                        {{-- MESSAGE --}}
                        <div>
                            <label class="block mb-1.5 text-sm sm:text-base font-medium text-zinc-700">
                                {{ strip_tags(setting('contact_label_message', 'Pesan')) }}
                            </label>
                            <textarea name="message" rows="5" required
                                placeholder="{{ strip_tags(setting('contact_placeholder_message', 'Tulis pesan Anda di sini...')) }}"
                                class="w-full resize-none rounded-lg border border-zinc-300
                                       bg-white
                                       px-4 py-3.5 text-sm sm:text-base
                                       text-zinc-900
                                       placeholder:text-zinc-400
                                       focus:outline-none focus:ring-2 focus:ring-primary-500/30
                                       transition"></textarea>
                        </div>

                        {{-- SUBMIT --}}
                        <button type="submit" class="w-full inline-flex items-center justify-center gap-2
                                   rounded-lg
                                   bg-primary-900
                                   px-6 py-3.5
                                   text-sm sm:text-base font-medium
                                   text-white
                                   shadow-sm
                                   hover:bg-primary-800
                                   transition-colors">
                            {{ strip_tags(setting('contact_button_submit', 'Kirim Pesan')) }}
                            <span>→</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    {{-- Animation --}}
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
                threshold: 0.15
            });

            elements.forEach(el => observer.observe(el));
        });
    </script>

@endsection
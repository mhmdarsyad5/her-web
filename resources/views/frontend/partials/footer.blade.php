<footer class="w-full
           border-t border-neutral-200
           bg-white">

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pb-10 sm:pb-12">

        {{-- ================= MAIN GRID ================= --}}
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-y-12 gap-x-8 mt-12 md:mt-16">

            {{-- ================= BRAND ================= --}}
            <div class="col-span-2 md:col-span-4 lg:col-span-2 flex flex-col items-start
                       text-left space-y-4">

                <div class="flex items-center gap-3">
                    <img src="{{ setting_url('logo_light') }}" alt="{{ strip_tags($siteName ?? 'Website') }} Logo"
                        class="h-10 w-auto" width="160" height="40" fetchpriority="high">
                </div>

                <p class="max-w-sm text-sm leading-relaxed text-neutral-600">
                    {!! setting(
    'footer_tagline',
    'Solusi digital untuk pertumbuhan bisnis modern.'
) !!}
                </p>
            </div>

            {{-- ================= NAVIGASI ================= --}}
            <nav class="col-span-1 flex flex-col items-start text-left" aria-label="Footer Navigation">
                <h3 class="mb-5 text-sm font-semibold uppercase tracking-wider
                           text-neutral-900">
                    {{ strip_tags(setting('footer_nav_title', 'Navigasi')) }}
                </h3>

                <ul class="space-y-3 text-sm text-neutral-600">
                    <li><a href="{{ route('home') }}" class="footer-link">
                            {{ strip_tags(setting('nav_home', 'Beranda')) }}
                        </a></li>
                    <li><a href="{{ route('abouts.index') }}" class="footer-link">
                            {{ strip_tags(setting('nav_about', 'Tentang Kami')) }}
                        </a></li>
                    <li><a href="{{ route('services.index') }}" class="footer-link">
                            {{ strip_tags(setting('nav_services', 'Layanan')) }}
                        </a></li>
                    <li><a href="{{ route('pages.index') }}" class="footer-link">
                            {{ strip_tags(setting('nav_blog', 'Blog')) }}
                        </a></li>
                    <!-- <li><a href="{{ route('galleries.index') }}" class="footer-link">
                            {{ strip_tags(setting('nav_gallery', 'Galeri')) }}
                        </a></li> -->
                </ul>
            </nav>
            {{-- ================ BANTUAN ================= --}}
            <nav class="col-span-1 flex flex-col items-start text-left" aria-label="Footer Support">
                <h3 class="mb-5 text-sm font-semibold uppercase tracking-wider
                           text-neutral-900">
                    {{ strip_tags(setting('footer_help_title', 'Bantuan')) }}
                </h3>

                <ul class="space-y-3 text-sm text-neutral-600">
                    <li><a href="{{ route('faq.index') }}" class="footer-link">
                            {{ strip_tags(setting('nav_faq', 'FAQ')) }}
                        </a></li>
                    <li><a href="{{ route('privacy-policy.index') }}" class="footer-link">
                            {{ strip_tags(setting('nav_privacy', 'Kebijakan Privasi')) }}
                        </a></li>
                    <li><a href="{{ route('terms-conditions.index') }}" class="footer-link">
                            {{ strip_tags(setting('nav_terms', 'Syarat & Ketentuan')) }}
                        </a></li>
                    <li><a href="{{ route('contacts.index') }}" class="footer-link">
                            {{ strip_tags(setting('nav_contact', 'Hubungi Kami')) }}
                        </a></li>
                </ul>
            </nav>

            {{-- ================= KONTAK ================= --}}
            <div class="col-span-2 md:col-span-2 flex flex-col items-start
                       text-left space-y-5">

                <h3 class="text-sm font-semibold uppercase tracking-wider
                           text-neutral-900">
                    {{ strip_tags(setting('footer_contact_title', 'Kontak')) }}
                </h3>

                <ul class="space-y-4 text-sm text-neutral-600">

                    {{-- WHATSAPP --}}
                    <li class="flex items-center justify-start gap-3">
                        <x-heroicon-o-phone-arrow-down-left class="h-5 w-5 shrink-0 text-neutral-700" />
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', setting('whatsapp_number')) }}"
                            target="_blank" class="hover:text-neutral-900 transition">
                            {!! setting('whatsapp_number', '+6282112345678') !!}
                        </a>
                    </li>

                    {{-- EMAIL --}}
                    <li class="flex items-center justify-start gap-3">
                        <x-heroicon-o-at-symbol class="h-5 w-5 shrink-0 text-neutral-700" />
                        <a href="mailto:{{ setting('email') }}" class="hover:text-neutral-900 transition">
                            {{ strip_tags(setting('email', 'email@example.com')) }}
                        </a>
                    </li>

                    {{-- ALAMAT --}}
                    <li class="flex items-start justify-start gap-3">
                        <x-heroicon-o-map-pin class="mt-0.5 h-5 w-5 shrink-0 text-neutral-700" />
                        <span class="leading-relaxed">
                            {!! setting('address', 'Jl. Contoh No. 123, Kota Contoh') !!}
                        </span>
                    </li>

                </ul>
            </div>
        </div>

        {{-- ================= COPYRIGHT ================= --}}
        <div class="mt-14 border-t border-neutral-200
           pt-6 text-center text-sm
           text-neutral-600">
            © {{ date('Y') }}
            {{ strip_tags(setting('site_name', 'Website')) }}.
            {{ strip_tags(setting('footer_copyright', 'Seluruh hak cipta dilindungi.')) }}
        </div>

    </div>
</footer>
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

                <div
                    class="max-w-sm text-sm leading-relaxed text-neutral-600 [&>p]:text-neutral-600 [&_strong]:text-neutral-900">
                    {!! setting(
    'footer_tagline',
    'Solusi digital untuk pertumbuhan bisnis modern.'
) !!}
                </div>
            </div>

            {{-- ================= NAVIGASI ================= --}}
            <nav class="col-span-1 flex flex-col items-start text-left" aria-label="Footer Navigation">
                <h3 class="mb-5 text-sm font-semibold uppercase tracking-wider
                           text-neutral-900">
                    {{ strip_tags(setting('footer_nav_title', 'Navigasi')) }}
                </h3>

                <ul class="space-y-3 text-sm text-neutral-600">
                    <li><a href="{{ route('home') }}" class="hover:text-neutral-900 transition-colors">
                            {{ strip_tags(setting('nav_home', 'Beranda')) }}
                        </a></li>
                    <li><a href="{{ route('abouts.index') }}" class="hover:text-neutral-900 transition-colors">
                            {{ strip_tags(setting('nav_about', 'Tentang Kami')) }}
                        </a></li>
                    <li><a href="{{ route('services.index') }}" class="hover:text-neutral-900 transition-colors">
                            {{ strip_tags(setting('nav_services', 'Layanan')) }}
                        </a></li>
                    <li><a href="{{ route('pages.index') }}" class="hover:text-neutral-900 transition-colors">
                            {{ strip_tags(setting('nav_blog', 'Blog')) }}
                        </a></li>
                </ul>
            </nav>

            {{-- ================ BANTUAN ================= --}}
            <nav class="col-span-1 flex flex-col items-start text-left" aria-label="Footer Support">
                <h3 class="mb-5 text-sm font-semibold uppercase tracking-wider
                           text-neutral-900">
                    {{ strip_tags(setting('footer_help_title', 'Bantuan')) }}
                </h3>

                <ul class="space-y-3 text-sm text-neutral-600">
                    <li><a href="{{ route('faq.index') }}" class="hover:text-neutral-900 transition-colors">
                            {{ strip_tags(setting('nav_faq', 'FAQ')) }}
                        </a></li>
                    <li><a href="{{ route('privacy-policy.index') }}" class="hover:text-neutral-900 transition-colors">
                            {{ strip_tags(setting('nav_privacy', 'Kebijakan Privasi')) }}
                        </a></li>
                    <li><a href="{{ route('terms-conditions.index') }}"
                            class="hover:text-neutral-900 transition-colors">
                            {{ strip_tags(setting('nav_terms', 'Syarat & Ketentuan')) }}
                        </a></li>
                    <li><a href="{{ route('contacts.index') }}" class="hover:text-neutral-900 transition-colors">
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
                            target="_blank" class="hover:text-neutral-900 transition-colors">
                            {!! setting('whatsapp_number', '+6282112345678') !!}
                        </a>
                    </li>

                    {{-- EMAIL --}}
                    <li class="flex items-center justify-start gap-3">
                        <x-heroicon-o-at-symbol class="h-5 w-5 shrink-0 text-neutral-700" />
                        <a href="mailto:{{ setting('email') }}" class="hover:text-neutral-900 transition-colors">
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

        {{-- ================= COPYRIGHT & SOCIALS ================= --}}
        <div
            class="mt-14 border-t border-neutral-200 pt-6 flex flex-col sm:flex-row items-center justify-between gap-4 text-center sm:text-left text-sm text-neutral-600">
            <div>
                © {{ date('Y') }}
                <strong class="font-bold text-neutral-800">{{ strip_tags(setting('site_name', 'Website')) }}</strong>.
                {{ strip_tags(setting('footer_copyright', 'Seluruh hak cipta dilindungi.')) }}
            </div>

            {{-- Social Media Icons with Label --}}
            <div class="flex flex-col sm:flex-row items-center gap-3 sm:gap-4 shrink-0">
                <span class="text-xs font-semibold tracking-wider text-neutral-600 uppercase">Ikuti Sosial Media
                    Kami</span>
                <div class="flex items-center gap-3.5 sm:gap-4 text-neutral-500">
                    @if(setting('social_facebook'))
                        <a href="{{ strip_tags(setting('social_facebook')) }}" target="_blank" rel="noopener noreferrer"
                            class="hover:text-neutral-950 transition-colors" title="Facebook">
                            <svg class="h-5 w-5 fill-current" viewBox="0 0 24 24">
                                <path
                                    d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-3 7h-1.924c-.615 0-1.076.252-1.076.885v1.115h3l-.5 3h-2.5v8h-3v-8h-2v-3h2v-2.07c0-2.062 1.343-3.18 3.5-3.18 1.053 0 1.956.08 2.222.11v2.585z" />
                            </svg>
                        </a>
                    @endif
                    @if(setting('social_instagram'))
                        <a href="{{ strip_tags(setting('social_instagram')) }}" target="_blank" rel="noopener noreferrer"
                            class="hover:text-neutral-950 transition-colors" title="Instagram">
                            <svg class="h-5 w-5 fill-current" viewBox="0 0 24 24">
                                <path
                                    d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.051.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z" />
                            </svg>
                        </a>
                    @endif
                    @if(setting('social_tiktok'))
                        <a href="{{ strip_tags(setting('social_tiktok')) }}" target="_blank" rel="noopener noreferrer"
                            class="hover:text-neutral-950 transition-colors" title="TikTok">
                            <svg class="h-5 w-5 fill-current" viewBox="0 0 24 24">
                                <path
                                    d="M12.53.02C13.84 0 15.14.01 16.44 0c.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.6-1v7.65c0 1.62-.37 3.27-1.21 4.6-1.39 2.23-3.94 3.65-6.6 3.62-3.11-.03-6.07-2.07-7.14-5-1.29-3.48-.11-7.79 2.92-10 1.47-1.07 3.28-1.62 5.12-1.57.02 1.34 0 2.69.01 4.03-1.1-.06-2.25.2-3.15.85-1.2.87-1.85 2.47-1.55 3.96.28 1.36 1.43 2.44 2.81 2.58 1.65.17 3.24-.76 3.79-2.29.26-.71.3-1.49.3-2.24V.02z" />
                            </svg>
                        </a>
                    @endif
                    @if(setting('social_linkedin'))
                        <a href="{{ strip_tags(setting('social_linkedin')) }}" target="_blank" rel="noopener noreferrer"
                            class="hover:text-neutral-950 transition-colors" title="LinkedIn">
                            <svg class="h-5 w-5 fill-current" viewBox="0 0 24 24">
                                <path
                                    d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                            </svg>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</footer>
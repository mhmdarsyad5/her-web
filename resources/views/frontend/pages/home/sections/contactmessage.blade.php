<section class="py-8 sm:py-10 lg:py-12 bg-gradient-to-b from-white via-zinc-50/20 to-white relative overflow-hidden">

    {{-- Glowing side light --}}
    <div class="absolute top-1/4 right-0 w-96 h-96 bg-primary-900/5 rounded-full blur-[120px] pointer-events-none">
    </div>

    <div class="mx-auto max-w-7xl px-6 sm:px-12 lg:px-20 relative z-10">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-start">

            {{-- LEFT COLUMN --}}
            <div class="flex flex-col justify-center">

                {{-- BADGE --}}
                @if(setting('contact_badge'))
                    <span class="mb-5 inline-flex w-fit rounded-full
                                           bg-zinc-100 border border-zinc-200/40
                                           px-3.5 py-1
                                           text-xs font-semibold tracking-wide
                                           text-zinc-900">
                        {{ strip_tags(setting('contact_badge')) }}
                    </span>
                @endif

                {{-- TITLE --}}
                <h2 class="text-3xl sm:text-4xl lg:text-5xl
                           font-extrabold tracking-tight
                           leading-[1.1]
                           text-zinc-950">
                    {{ strip_tags(setting('contact_title', 'Mari Terhubung')) }}
                </h2>

                {{-- DESC --}}
                <p class="mt-4 max-w-md
                           text-sm sm:text-base lg:text-lg
                           leading-relaxed
                           text-zinc-600">
                    {{ strip_tags(
    setting(
        'contact_description',
        'Pertanyaan, masukan, atau peluang kolaborasi? Kirim pesan dan tim kami akan menghubungi Anda.'
    )
) }}
                </p>

                {{-- BRANCH CARDS --}}
                <div class="mt-10 grid grid-cols-1 gap-5">
                    @foreach([1, 2, 3] as $branch)
                        @if(setting('branch_' . $branch . '_name'))
                            <div
                                class="rounded-xl border border-zinc-200 bg-white p-4 shadow-sm hover:shadow-md transition-shadow">
                                <div class="flex flex-col sm:flex-row gap-4">
                                    {{-- MAP (Embed Iframe) --}}
                                    @if(setting('branch_' . $branch . '_map_url'))
                                        <div class="flex-shrink-0 w-full sm:w-32 h-24 rounded-lg overflow-hidden border border-zinc-150 shadow-inner">
                                            @php
                                                $mapUrl = setting_src('branch_' . $branch . '_map_url');
                                            @endphp
                                            @if($mapUrl && filter_var($mapUrl, FILTER_VALIDATE_URL))
                                                <iframe src="{{ $mapUrl }}" frameborder="0" allowfullscreen="" loading="lazy"
                                                    referrerpolicy="no-referrer-when-downgrade" class="w-full h-full"></iframe>
                                            @else
                                                <div
                                                    class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-500 text-xs">
                                                    Map tidak tersedia
                                                </div>
                                            @endif
                                        </div>
                                    @endif

                                    {{-- INFO --}}
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-sm sm:text-base font-semibold text-zinc-900 mb-1">
                                            {{ strip_tags(setting('branch_' . $branch . '_name')) }}
                                        </h4>
                                        @if(setting('branch_' . $branch . '_address'))
                                            <p class="text-xs sm:text-sm text-zinc-600 mb-2">
                                                {{ strip_tags(setting('branch_' . $branch . '_address')) }}
                                            </p>
                                        @endif
                                        <div class="space-y-1">
                                            @if(setting('branch_' . $branch . '_whatsapp'))
                                                <p class="text-xs sm:text-sm text-zinc-700">
                                                    <span class="font-medium">WhatsApp:</span>
                                                    {{ strip_tags(setting('branch_' . $branch . '_whatsapp')) }}
                                                </p>
                                            @endif
                                            @if(setting('branch_' . $branch . '_email'))
                                                <p class="text-xs sm:text-sm text-zinc-700">
                                                    <span class="font-medium">Email:</span>
                                                    {{ strip_tags(setting('branch_' . $branch . '_email')) }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            {{-- RIGHT COLUMN — FORM CARD --}}
            <div class="rounded-3xl border
                       border-zinc-200/60
                       bg-white
                       p-6 sm:p-10
                       shadow-xl shadow-zinc-200/50 relative overflow-hidden">

                {{-- Decorative Card Blur --}}
                <div
                    class="absolute -top-12 -right-12 w-32 h-32 bg-primary-900/5 rounded-full blur-[40px] pointer-events-none">
                </div>

                <form id="contactForm" method="POST" action="{{ route('contact.store') }}"
                    class="space-y-5 sm:space-y-6 relative z-10">
                    @csrf

                    {{-- Honeypot Anti-Spam (Invisible to humans) --}}
                    <div class="hidden" aria-hidden="true">
                        <input type="text" name="company_website" tabindex="-1" autocomplete="off" />
                    </div>

                    {{-- NAMA --}}
                    <div>
                        <label class="mb-2 block
                                       text-xs sm:text-sm
                                       font-semibold
                                       text-zinc-800">
                            {{ strip_tags(setting('contact_label_name', 'Nama')) }}
                        </label>
                        <input type="text" name="name" required
                            placeholder="{{ strip_tags(setting('contact_placeholder_name', 'Nama lengkap Anda')) }}"
                            class="w-full rounded-xl border border-zinc-200
                                   bg-zinc-50/50
                                   px-4 py-3.5
                                   text-sm sm:text-base
                                   leading-normal
                                   text-zinc-900
                                   placeholder:text-zinc-400
                                   focus:bg-white focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-900
                                   transition-all duration-200" />
                    </div>

                    {{-- EMAIL --}}
                    <div>
                        <label class="mb-2 block
                                       text-xs sm:text-sm
                                       font-semibold
                                       text-zinc-800">
                            {{ strip_tags(setting('contact_label_email_form', 'Email')) }}
                        </label>
                        <input type="email" name="email" required
                            placeholder="{{ strip_tags(setting('contact_placeholder_email', 'contoh@mail.com')) }}"
                            class="w-full rounded-xl border border-zinc-200
                                   bg-zinc-50/50
                                   px-4 py-3.5
                                   text-sm sm:text-base
                                   leading-normal
                                   text-zinc-900
                                   placeholder:text-zinc-400
                                   focus:bg-white focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-900
                                   transition-all duration-200" />
                    </div>

                    {{-- WHATSAPP --}}
                    <div>
                        <label class="mb-2 block
                                       text-xs sm:text-sm
                                       font-semibold
                                       text-zinc-800">
                            {{ strip_tags(setting('contact_label_whatsapp_form', 'Nomor WhatsApp')) }}
                        </label>
                        <input type="tel" name="whatsapp_number" required
                            placeholder="{{ strip_tags(setting('contact_placeholder_whatsapp', '+6281234567890')) }}"
                            class="w-full rounded-xl border border-zinc-200
                                   bg-zinc-50/50
                                   px-4 py-3.5
                                   text-sm sm:text-base
                                   leading-normal
                                   text-zinc-900
                                   placeholder:text-zinc-400
                                   focus:bg-white focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-900
                                   transition-all duration-200" />
                    </div>

                    {{-- SUBJECT --}}
                    <div>
                        <label class="mb-2 block
                                       text-xs sm:text-sm
                                       font-semibold
                                       text-zinc-800">
                            {{ strip_tags(setting('contact_label_subject', 'Subjek')) }}
                        </label>
                        <input type="text" name="subject"
                            placeholder="{{ strip_tags(setting('contact_placeholder_subject', 'Contoh: Kerja sama, Konsultasi')) }}"
                            class="w-full rounded-xl border border-zinc-200
                                   bg-zinc-50/50
                                   px-4 py-3.5
                                   text-sm sm:text-base
                                   leading-normal
                                   text-zinc-900
                                   placeholder:text-zinc-400
                                   focus:bg-white focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-900
                                   transition-all duration-200" />
                    </div>

                    {{-- MESSAGE --}}
                    <div>
                        <label class="mb-2 block
                                       text-xs sm:text-sm
                                       font-semibold
                                       text-zinc-800">
                            {{ strip_tags(setting('contact_label_message', 'Pesan')) }}
                        </label>
                        <textarea name="message" rows="5" required
                            placeholder="{{ strip_tags(setting('contact_placeholder_message', 'Tulis pesan Anda di sini...')) }}"
                            class="w-full resize-none rounded-xl border border-zinc-200
                                   bg-zinc-50/50
                                   px-4 py-3.5
                                   text-sm sm:text-base
                                   leading-normal
                                   text-zinc-900
                                   placeholder:text-zinc-400
                                   focus:bg-white focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-900
                                   transition-all duration-200"></textarea>
                    </div>

                    {{-- SUBMIT BUTTON --}}
                    <button type="submit" class="w-full inline-flex items-center justify-center gap-2
                                rounded-xl
                                px-5 py-3
                                text-sm sm:text-base font-bold
                                text-white
                                shadow-md shadow-primary-900/15
                                hover:brightness-90 hover:shadow-lg hover:-translate-y-0.5
                                active:translate-y-0
                                transition-all duration-200"
                        style="background-color: {{ setting('primary_color', '#F5A21C') }};">
                        {{ strip_tags(setting('contact_button_submit', 'Kirim Pesan')) }}
                        <x-heroicon-o-arrow-right class="h-4 w-4" />
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
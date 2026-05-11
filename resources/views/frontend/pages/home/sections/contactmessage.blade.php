<section class="py-14 sm:py-20 lg:py-24 bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-start">

            {{-- LEFT --}}
            <div class="flex flex-col justify-center">

                {{-- BADGE --}}
                <span class="mb-5 sm:mb-6 inline-flex w-fit rounded-full
                               bg-primary-100
                               px-3 py-1
                               text-xs font-medium tracking-wide
                               text-primary-800">
                    {{ strip_tags(setting('contact_badge', 'Hubungi Kami')) }}
                </span>

                {{-- TITLE --}}
                <h2 class="text-2xl sm:text-3xl lg:text-4xl
                           font-bold tracking-tight
                           leading-snug sm:leading-tight
                           text-zinc-900">
                    {{ strip_tags(setting('contact_title', 'Mari Terhubung')) }}
                </h2>

                {{-- DESC --}}
                <p class="mt-3 sm:mt-4 max-w-md
                           text-sm sm:text-base
                           leading-relaxed sm:leading-loose
                           text-zinc-600">
                    {{ strip_tags(
                        setting(
                            'contact_description',
                            'Pertanyaan, masukan, atau peluang kolaborasi? Kirim pesan dan tim kami akan menghubungi Anda.'
                        )
                    ) }}
                </p>

                {{-- INFO --}}
                <!-- <div class="mt-10 lg:mt-12">
                    <h3 class="mb-4 text-base sm:text-lg
                               font-semibold tracking-tight
                               text-zinc-900">
                        {{ strip_tags(setting('contact_info_title', 'Informasi Kontak')) }}
                    </h3>

                    <ul class="space-y-3 sm:space-y-4
                               text-sm sm:text-base
                               leading-relaxed
                               text-zinc-700">
                        <li>
                            <span class="font-medium">
                                {{ strip_tags(setting('contact_label_whatsapp', 'WhatsApp')) }}:
                            </span>
                            {!! setting('whatsapp_number') !!}
                        </li>
                        <li>
                            <span class="font-medium">
                                {{ strip_tags(setting('contact_label_email', 'Email')) }}:
                            </span>
                            {!! setting('email') !!}
                        </li>
                        <li>
                            <span class="font-medium">
                                {{ strip_tags(setting('contact_label_address', 'Alamat')) }}:
                            </span>
                            {!! setting('address') !!}
                        </li>
                    </ul>
                </div> -->

                {{-- BRANCH CARDS --}}
                <div class="mt-10 grid grid-cols-1 gap-4">
                    @foreach([1, 2, 3] as $branch)
                        <div class="rounded-xl border border-zinc-200 bg-white p-4 shadow-sm hover:shadow-md transition-shadow">
                            <div class="flex flex-col sm:flex-row gap-4">
                                {{-- MAP --}}
                                <div class="flex-shrink-0 w-full sm:w-32 h-24 rounded-lg overflow-hidden">
                                    @php
                                        $mapUrl = setting_src('branch_'.$branch.'_map_url');
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
                                        {{ strip_tags(setting('branch_'.$branch.'_name', 'Cabang Kami')) }}
                                    </h4>
                                    <p class="text-xs sm:text-sm text-zinc-600 mb-2">
                                        {{ strip_tags(setting('branch_'.$branch.'_address', 'Alamat cabang')) }}
                                    </p>
                                    <div class="space-y-1">
                                        <p class="text-xs sm:text-sm text-zinc-700">
                                            <span class="font-medium">WhatsApp:</span>
                                            {{ strip_tags(setting('branch_'.$branch.'_whatsapp', '-')) }}
                                        </p>
                                        <p class="text-xs sm:text-sm text-zinc-700">
                                            <span class="font-medium">Email:</span>
                                            {{ strip_tags(setting('branch_'.$branch.'_email', '-')) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- RIGHT — FORM --}}
            <div class="rounded-2xl border
                       border-zinc-200
                       bg-white
                       p-6 sm:p-8 lg:p-10
                       shadow-lg">

                <form
                    id="contactForm"
                    method="POST"
                    action="{{ route('contact.store') }}"
                    class="space-y-5 sm:space-y-6">
                    @csrf

                    {{-- NAMA --}}
                    <div>
                        <label class="mb-1.5 block
                                       text-xs sm:text-sm
                                       font-medium
                                       text-zinc-700">
                            {{ strip_tags(setting('contact_label_name', 'Nama')) }}
                        </label>
                        <input
                            type="text"
                            name="name"
                            required
                            placeholder="{{ strip_tags(setting('contact_placeholder_name', 'Nama lengkap Anda')) }}"
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

                    {{-- EMAIL --}}
                    <div>
                        <label class="mb-1.5 block
                                       text-xs sm:text-sm
                                       font-medium
                                       text-zinc-700">
                            {{ strip_tags(setting('contact_label_email_form', 'Email')) }}
                        </label>
                        <input
                            type="email"
                            name="email"
                            required
                            placeholder="{{ strip_tags(setting('contact_placeholder_email', 'contoh@mail.com')) }}"
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

                    {{-- WHATSAPP --}}
                    <div>
                        <label class="mb-1.5 block
                                       text-xs sm:text-sm
                                       font-medium
                                       text-zinc-700">
                            {{ strip_tags(setting('contact_label_whatsapp_form', 'Nomor WhatsApp')) }}
                        </label>
                        <input
                            type="tel"
                            name="whatsapp_number"
                            required
                            placeholder="{{ strip_tags(setting('contact_placeholder_whatsapp', '+6281234567890')) }}"
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

                    {{-- SUBJECT --}}
                    <div>
                        <label class="mb-1.5 block
                                       text-xs sm:text-sm
                                       font-medium
                                       text-zinc-700">
                            {{ strip_tags(setting('contact_label_subject', 'Subjek')) }}
                        </label>
                        <input
                            type="text"
                            name="subject"
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
                        <label class="mb-1.5 block
                                       text-xs sm:text-sm
                                       font-medium
                                       text-zinc-700">
                            {{ strip_tags(setting('contact_label_message', 'Pesan')) }}
                        </label>
                        <textarea
                            name="message"
                            rows="5"
                            required
                            placeholder="{{ strip_tags(setting('contact_placeholder_message', 'Tulis pesan Anda di sini...')) }}"
                            class="w-full resize-none rounded-lg border border-zinc-300
                                   bg-white
                                   px-4 py-3.5
                                   text-sm sm:text-base
                                   leading-normal
                                   text-zinc-900
                                   placeholder:text-zinc-400
                                   focus:outline-none focus:ring-2 focus:ring-primary-500/30
                                   transition"></textarea>
                    </div>

                    {{-- SUBMIT BUTTON --}}
                    <button
                        type="submit"
                        class="w-full inline-flex items-center justify-center gap-2
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

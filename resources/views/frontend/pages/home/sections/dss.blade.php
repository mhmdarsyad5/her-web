<style>
    :root {
        --primary-color:
            {{ $primaryColor ?? '#ff7f00' }}
        ;
        --color-text-secondary: #71717a;
        --color-border-tertiary: #f4f4f5;
        --font-sans: inherit;
    }

    #dssAlertModal {
        z-index: 999999 !important;
    }

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        font-family: var(--font-sans);
    }

    .dss-wrap {
        padding: 0 0 2.5rem 0;
        max-width: 900px;
        margin: 0 auto;
    }

    .step-bar {
        display: flex;
        align-items: center;
        gap: 0;
        margin-bottom: 3rem;
        background: #ffffff;
        padding: 1.5rem;
        border-radius: 16px;
        border: 1px solid #f4f4f5;
        box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.04);
    }

    .step-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        flex: 1;
        position: relative;
    }

    .step-item:not(:last-child)::after {
        content: '';
        position: absolute;
        top: 16px;
        left: 55%;
        width: 90%;
        height: 2px;
        background: #f4f4f5;
        z-index: 0;
    }

    .step-item:not(:last-child).active::after,
    .step-item:not(:last-child).done::after {
        background: var(--primary-color);
    }

    .step-circle {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        border: 2px solid #e4e4e7;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        font-weight: 700;
        color: #a1a1aa;
        position: relative;
        z-index: 1;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
    }

    .step-circle.active {
        background: var(--primary-color);
        border-color: var(--primary-color);
        color: white;
        box-shadow: 0 4px 12px rgba(255, 127, 0, 0.25);
    }

    .step-circle.done {
        background: var(--primary-color);
        border-color: var(--primary-color);
        color: white;
    }

    .step-label {
        font-size: 11px;
        color: #71717a;
        margin-top: 8px;
        text-align: center;
        max-width: 90px;
        font-weight: 500;
        transition: color 0.3s ease;
    }

    .step-label.active {
        color: var(--primary-color);
        font-weight: 700;
    }

    .form-card {
        background: #ffffff;
        border: 1px solid #f4f4f5;
        border-radius: 20px;
        padding: 2.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.02), 0 8px 10px -6px rgba(0, 0, 0, 0.02);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .form-card:hover {
        border-color: #e4e4e7;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.04), 0 10px 10px -5px rgba(0, 0, 0, 0.03);
    }

    .form-title {
        font-size: 20px;
        font-weight: 700;
        color: #09090b;
        margin-bottom: 0.5rem;
        letter-spacing: -0.025em;
    }

    .form-sub {
        font-size: 14px;
        color: #71717a;
        margin-bottom: 2rem;
        line-height: 1.6;
    }

    .field-group {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .field {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .field.full {
        grid-column: 1 / -1;
    }

    label {
        font-size: 13px;
        color: #27272a;
        font-weight: 600;
        margin-bottom: 2px;
    }

    select,
    input {
        width: 100%;
        padding: 12px 14px;
        font-size: 14px;
        font-family: var(--font-sans);
        background: #fafafa;
        border: 1px solid #e4e4e7;
        border-radius: 10px;
        color: #18181b;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }

    select:hover,
    input:hover {
        border-color: #d4d4d8;
        background: #ffffff;
    }

    select:focus,
    input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 4px rgba(255, 127, 0, 0.1);
        background: #ffffff;
    }

    .btn-row {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
        margin-top: 2.5rem;
    }

    .btn {
        padding: 12px 28px;
        border-radius: 10px;
        border: 1px solid #e4e4e7;
        font-size: 14px;
        cursor: pointer;
        font-family: var(--font-sans);
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .btn-secondary {
        background: #ffffff;
        color: #3f3f46;
        border-color: #e4e4e7;
    }

    .btn-secondary:hover {
        background: #f4f4f5;
        border-color: #d4d4d8;
    }

    .btn-primary {
        background: var(--primary-color);
        border-color: var(--primary-color);
        color: white;
        box-shadow: 0 4px 12px rgba(255, 127, 0, 0.15);
    }

    .btn-primary:hover {
        background: #e67e00;
        border-color: #e67e00;
        box-shadow: 0 4px 16px rgba(255, 127, 0, 0.3);
        transform: translateY(-1px);
    }

    .btn-primary:active {
        transform: translateY(0);
    }

    .btn-primary:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    .result-header {
        font-size: 18px;
        font-weight: 700;
        color: #09090b;
        margin-bottom: 6px;
        letter-spacing: -0.02em;
    }

    .result-sub {
        font-size: 14px;
        color: #71717a;
        margin-bottom: 2rem;
    }

    .no-result {
        text-align: center;
        padding: 3rem 1.5rem;
        color: #71717a;
        font-size: 14px;
        background: #fafafa;
        border: 1px dashed #e4e4e7;
        border-radius: 12px;
        line-height: 1.6;
    }

    .dss-loading {
        display: none;
        text-align: center;
        padding: 4rem 1.5rem;
        color: #71717a;
    }

    .dss-loading.active {
        display: block;
    }

    .dss-loading p {
        margin: 0;
        font-size: 14px;
        font-weight: 500;
    }

    #cityDropdown {
        border-radius: 12px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.08);
        border: 1px solid #e4e4e7;
        background: #ffffff;
    }

    #cityDropdown div:hover {
        background-color: rgba(255, 127, 0, 0.05);
        color: var(--primary-color);
    }

    @media (max-width: 768px) {
        .dss-wrap {
            padding: 0 0 1.5rem 0;
        }

        .form-card {
            padding: 1.25rem;
        }

        .field-group {
            grid-template-columns: 1fr;
            gap: 16px;
        }

        .step-bar {
            padding: 1rem;
            gap: 4px;
            margin-bottom: 1.5rem;
        }

        .step-label {
            font-size: 10px;
            max-width: 80px;
        }

        .btn-row {
            flex-direction: column-reverse;
            gap: 10px;
        }

        .btn {
            width: 100%;
        }
    }

    /* Hide HTML5 number spinners to prevent overlapping with units text */
    input[type=number]::-webkit-outer-spin-button,
    input[type=number]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    input[type=number] {
        -moz-appearance: textfield;
    }

    /* Premium Success Checkmark Animation */
    .checkmark-wrapper {
        width: 80px;
        height: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .checkmark-svg {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: block;
        stroke-width: 3;
        stroke: #22c55e;
        stroke-miterlimit: 10;
        box-shadow: inset 0px 0px 0px #22c55e;
        animation: fill-checkmark .4s ease-in-out .4s forwards, scale-checkmark .3s ease-in-out .9s forwards;
    }

    .checkmark-circle {
        stroke-dasharray: 166;
        stroke-dashoffset: 166;
        stroke-width: 3;
        stroke-miterlimit: 10;
        stroke: #22c55e;
        fill: none;
        animation: stroke-checkmark 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
    }

    .checkmark-check {
        transform-origin: 50% 50%;
        stroke-dasharray: 48;
        stroke-dashoffset: 48;
        stroke: #ffffff;
        animation: stroke-checkmark 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.6s forwards;
    }

    @keyframes stroke-checkmark {
        100% {
            stroke-dashoffset: 0;
        }
    }

    @keyframes scale-checkmark {
        0%, 100% {
            transform: none;
        }
        50% {
            transform: scale3d(1.1, 1.1, 1);
        }
    }

    @keyframes fill-checkmark {
        100% {
            box-shadow: inset 0px 0px 0px 40px #22c55e;
        }
    }
</style>

@php
    $isHome = request()->routeIs('home');
    $dssBgClass = $isHome ? 'bg-zinc-50' : 'bg-white';
@endphp
<section class="pt-6 pb-12 sm:pt-10 sm:pb-16 {{ $dssBgClass }} relative overflow-hidden" id="dssSection" data-whatsapp="{{ preg_replace('/[^0-9]/', '', setting('whatsapp_number', '6281234567890')) }}">

    {{-- Decorative Background Glows --}}
    <div class="absolute top-1/3 left-0 w-96 h-96 bg-primary-900/5 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute bottom-1/3 right-0 w-96 h-96 bg-primary-900/5 rounded-full blur-[120px] pointer-events-none">
    </div>

    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 relative z-10">

        {{-- HEADER --}}
        <div class="mx-auto max-w-2xl text-center mb-4 sm:mb-10 fade-slide opacity-0 translate-y-4">
            @if (setting('dss_badge', 'Rekomendasi Alat'))
                <span class="inline-flex items-center rounded-full
                                   bg-zinc-100 border border-zinc-200/40
                                   px-3.5 py-1
                                   text-xs font-semibold tracking-wide
                                   text-zinc-900">
                    {!! strip_tags(setting('dss_badge', 'Rekomendasi Alat')) !!}
                </span>
            @endif

            @if (setting('dss_title', 'Temukan Unit yang Tepat'))
                <h2 class="mt-5
                               text-2xl sm:text-3xl lg:text-4xl
                               font-extrabold tracking-tight leading-tight
                               text-zinc-955">
                    {!! strip_tags(setting('dss_title', 'Temukan Unit yang Tepat')) !!}
                </h2>
            @endif

            @if (setting('dss_subtitle'))
                <div class="mt-4
                               text-sm sm:text-base
                               leading-relaxed
                               text-zinc-650">
                    {!! setting('dss_subtitle', 'Gunakan asisten rekomendasi kami untuk menemukan unit forklift atau reach truck yang ideal sesuai kebutuhan operasional Anda.') !!}
                </div>
            @endif
        </div>

        <div class="dss-wrap">
            {{-- Step bar - 4 steps --}}
            <div class="step-bar fade-slide opacity-0 translate-y-4" id="stepBar">
                <div class="step-item">
                    <div class="step-circle active" id="sc1">1</div>
                    <div class="step-label active" id="sl1">Industri & Kota</div>
                </div>
                <div class="step-item">
                    <div class="step-circle" id="sc2">2</div>
                    <div class="step-label" id="sl2">Spesifikasi</div>
                </div>
                <div class="step-item">
                    <div class="step-circle" id="sc3">3</div>
                    <div class="step-label" id="sl3">Hasil Rekomendasi</div>
                </div>
                <div class="step-item">
                    <div class="step-circle" id="sc4">4</div>
                    <div class="step-label" id="sl4">Minta Penawaran</div>
                </div>
            </div>

            {{-- Step 1 --}}
            <div id="step1" class="form-card fade-slide opacity-0 translate-y-4">
                <div class="form-title">Industri & Lokasi</div>
                <div class="form-sub">Tentukan sektor usaha Anda dan lokasi kota operasional Anda.</div>
                <div class="field-group">
                    <div class="field">
                        <label for="industri">Sektor Industri Anda</label>
                        <select id="industri">
                            <option value="">-- Pilih Industri --</option>
                            @foreach($industries as $ind)
                                <option value="{{ $ind['code'] }}">{{ $ind['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field relative">
                        <label for="kota">Lokasi Kota Operasional</label>
                        <input type="text" id="kota" placeholder="Cari kota di Indonesia..." autocomplete="off">
                        <div id="cityDropdown" class="absolute top-full left-0 w-full bg-white border border-zinc-200 rounded-xl shadow-lg mt-1 max-h-48 overflow-y-auto z-50 hidden">
                            <!-- Populated dynamically via JS -->
                        </div>
                    </div>
                </div>
                <div class="btn-row">
                    <button class="btn btn-primary" onclick="goStep2()">Lanjut &rarr;</button>
                </div>
            </div>

            {{-- Step 2 --}}
            <div id="step2" class="form-card" style="display:none">
                <div class="form-title">Spesifikasi Kebutuhan</div>
                <div class="form-sub">Tentukan beban maksimum yang akan diangkat dan jangkauan tinggi angkat yang dibutuhkan.</div>
                <div class="field-group">
                    <div class="field">
                        <label for="berat" class="flex items-center gap-1.5">
                            <span>Kapasitas Beban (Load Capacity)</span>
                        </label>
                        <div class="relative">
                            <input type="number" id="berat" placeholder="Contoh: 2000" min="1" step="50" required
                                class="w-full px-4 py-3 pr-12 rounded-xl border border-zinc-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent text-sm">
                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-sm text-zinc-400 font-medium">kg</span>
                        </div>
                        <p class="text-xs text-zinc-400 mt-1">Masukkan berat maksimal beban dalam satuan kilogram (kg).</p>
                    </div>
                    <div class="field">
                        <label for="tinggi" class="flex items-center gap-1.5">
                            <span>Tinggi Angkat (Lifting Height)</span>
                        </label>
                        <div class="relative">
                            <input type="number" id="tinggi" placeholder="Contoh: 4.5 atau 6" min="0" step="0.1" required
                                class="w-full px-4 py-3 pr-12 rounded-xl border border-zinc-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent text-sm">
                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-sm text-zinc-400 font-medium">meter</span>
                        </div>
                        <p class="text-xs text-zinc-400 mt-1">Masukkan tinggi angkat maksimal dalam satuan meter (bisa desimal).</p>
                    </div>
                </div>
                <div class="btn-row">
                    <button class="btn btn-secondary" onclick="goStep(1)">&larr; Kembali</button>
                    <button class="btn btn-primary" onclick="runDSS()">Cari Rekomendasi &rarr;</button>
                </div>
            </div>

            {{-- Step 3 --}}
            <div id="step3" style="display:none">
                <div class="form-card" id="resultSection">
                    <div class="dss-loading active">
                        <p>Mencari rekomendasi unit terbaik untuk Anda...</p>
                    </div>
                </div>
                <div class="flex justify-center mt-6">
                    <button class="btn btn-secondary" onclick="reset()">Mulai Ulang Pencarian</button>
                </div>
            </div>

            {{-- Step 4 --}}
            <div id="step4" class="form-card" style="display:none">
                <!-- Form Area -->
                <div id="leadFormArea">
                    <div class="form-title">Minta Penawaran Resmi</div>
                    <div class="form-sub">Lengkapi formulir di bawah ini untuk menerima surat penawaran harga resmi dari tim kami.</div>
                    
                    <div class="field-group">
                        <div class="field">
                            <label for="lead_name">Nama Lengkap *</label>
                            <input type="text" id="lead_name" placeholder="Masukkan nama lengkap Anda..." required>
                        </div>
                        <div class="field">
                            <label for="lead_company">Nama Perusahaan *</label>
                            <input type="text" id="lead_company" placeholder="Masukkan nama perusahaan..." required>
                        </div>
                        <div class="field">
                            <label for="lead_email">Alamat Email *</label>
                            <input type="email" id="lead_email" placeholder="Contoh: nama@perusahaan.com..." required>
                        </div>
                        <div class="field">
                            <label for="lead_whatsapp">Nomor WhatsApp *</label>
                            <input type="tel" id="lead_whatsapp" placeholder="Contoh: 0812XXXXXXXX..." required>
                        </div>
                        <div class="field">
                            <label for="lead_industry">Industri (Dari Step 1)</label>
                            <input type="text" id="lead_industry" readonly disabled class="bg-zinc-100 cursor-not-allowed">
                        </div>
                        <div class="field">
                            <label for="lead_location">Lokasi Kota (Dari Step 1)</label>
                            <input type="text" id="lead_location" readonly disabled class="bg-zinc-100 cursor-not-allowed">
                        </div>
                    </div>

                    <div class="btn-row">
                        <button class="btn btn-secondary" onclick="goStep(3)">&larr; Kembali</button>
                        <button class="btn btn-primary" onclick="submitLeadForm()" id="btnSubmitLead">Kirim & Dapatkan Penawaran &rarr;</button>
                    </div>
                </div>

                <!-- Thank You Area (Hidden by default) -->
                <div id="thankYouArea" style="display:none" class="flex flex-col items-center justify-center p-4 text-center">
                    <!-- Premium checkmark success drawing animation -->
                    <div class="checkmark-wrapper mb-6 mx-auto">
                        <svg class="checkmark-svg" viewBox="0 0 52 52">
                            <circle class="checkmark-circle" cx="26" cy="26" r="25" fill="none"/>
                            <path class="checkmark-check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                        </svg>
                    </div>

                    <h3 class="text-xl sm:text-2xl font-extrabold text-zinc-900 mb-3 tracking-tight">Permintaan Penawaran Terkirim!</h3>
                    <p class="text-sm sm:text-base text-zinc-650 mb-8 max-w-lg leading-relaxed">
                        Terima kasih <strong id="thanks_name" class="text-zinc-900"></strong>! Permintaan penawaran harga Anda telah sukses direkam oleh sistem kami. Tim kami akan segera menghubungi Anda melalui email (<span id="thanks_email" class="font-semibold text-zinc-900"></span>) atau WhatsApp secepatnya.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto justify-center">
                        <a href="#" id="wa_direct_btn" target="_blank" class="inline-flex items-center justify-center gap-2 rounded-xl bg-green-600 hover:bg-green-700 text-white px-6 py-3.5 text-sm font-bold shadow-lg transition duration-200">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.746.953 3.71 1.455 5.703 1.456h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            Hubungi via WhatsApp (Respon Cepat)
                        </a>
                        <button onclick="reset()" class="inline-flex items-center justify-center gap-2 rounded-xl bg-zinc-100 hover:bg-zinc-200 border border-zinc-200 text-zinc-800 px-6 py-3.5 text-sm font-bold transition duration-200">
                            Mulai Ulang Pencarian
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Custom Premium Alert Modal -->
        <div id="dssAlertModal" class="fixed inset-0 z-[99999] flex items-center justify-center p-4 bg-zinc-950/60 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300">
            <div class="bg-white rounded-2xl max-w-sm w-full p-6 shadow-2xl border border-zinc-150 transform scale-95 transition-transform duration-300" id="dssAlertContent">
                <div class="flex items-center gap-3 text-amber-500 mb-3">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <h4 class="text-base font-extrabold text-zinc-900">Validasi Input</h4>
                </div>
                <p class="text-xs sm:text-sm text-zinc-650 mb-5 leading-relaxed" id="dssAlertMessage">Pesan alert di sini</p>
                <div class="flex justify-end">
                    <button onclick="closeDssAlert()" class="px-5 py-2 text-xs font-bold text-white rounded-xl shadow-lg transition duration-200" style="background-color: var(--primary-color);">OK</button>
                </div>
            </div>
        </div>

    </div>
</section>
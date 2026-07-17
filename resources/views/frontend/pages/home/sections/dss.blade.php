<style>
    :root {
        --primary-color:
            {{ $primaryColor ?? '#ff7f00' }}
        ;
        --color-text-secondary: #71717a;
        --color-border-tertiary: #f4f4f5;
        --font-sans: inherit;
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

    .chip-group {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 4px;
    }

    .chip {
        padding: 10px 18px;
        border-radius: 9999px;
        border: 1px solid #e4e4e7;
        font-size: 13px;
        cursor: pointer;
        color: #3f3f46;
        background: #ffffff;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        font-weight: 500;
    }

    .chip:hover {
        border-color: var(--primary-color);
        color: var(--primary-color);
        background: rgba(255, 127, 0, 0.04);
    }

    .chip.selected {
        background: var(--primary-color);
        border-color: var(--primary-color);
        color: white;
        font-weight: 600;
        box-shadow: 0 4px 12px rgba(255, 127, 0, 0.2);
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

    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 20px;
    }

    .product-card {
        background: #ffffff;
        border: 1px solid #e4e4e7;
        border-radius: 16px;
        padding: 1.5rem;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .product-card:hover {
        border-color: var(--primary-color);
        box-shadow: 0 12px 24px -10px rgba(255, 127, 0, 0.2);
        transform: translateY(-2px);
    }

    .product-card.top {
        border: 2px solid var(--primary-color);
        background: linear-gradient(180deg, #fffaf5 0%, #ffffff 100%);
        box-shadow: 0 12px 30px -10px rgba(255, 127, 0, 0.25);
    }

    .badge {
        display: inline-block;
        font-size: 11px;
        padding: 4px 12px;
        border-radius: 9999px;
        margin-bottom: 12px;
        font-weight: 600;
    }

    .badge-top {
        background: rgba(255, 127, 0, 0.1);
        color: var(--primary-color);
    }

    .badge-match {
        background: #f4f4f5;
        color: #3f3f46;
    }

    .badge-type {
        background: #eff6ff;
        color: #1e40af;
    }

    .product-name {
        font-size: 15px;
        font-weight: 700;
        color: #09090b;
        margin-bottom: 12px;
        line-height: 1.4;
    }

    .product-meta {
        font-size: 13px;
        color: #71717a;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .meta-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px dashed #f4f4f5;
        padding-bottom: 4px;
    }

    .meta-val {
        color: var(--primary-color);
        font-weight: 700;
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

        .product-grid {
            grid-template-columns: 1fr;
        }

        .btn-row {
            flex-direction: column-reverse;
            gap: 10px;
        }

        .btn {
            width: 100%;
        }
    }
</style>

@php
    $isHome = request()->routeIs('home');
    $dssBgClass = $isHome ? 'bg-zinc-50' : 'bg-white';
@endphp
<section class="pt-6 pb-12 sm:pt-10 sm:pb-16 {{ $dssBgClass }} relative overflow-hidden" id="dssSection">

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
            {{-- Step bar simplified to 3 steps --}}
            <div class="step-bar fade-slide opacity-0 translate-y-4" id="stepBar">
                <div class="step-item">
                    <div class="step-circle active" id="sc1">1</div>
                    <div class="step-label active" id="sl1">Industri & Unit</div>
                </div>
                <div class="step-item">
                    <div class="step-circle" id="sc2">2</div>
                    <div class="step-label" id="sl2">Spesifikasi</div>
                </div>
                <div class="step-item">
                    <div class="step-circle" id="sc3">3</div>
                    <div class="step-label" id="sl3">Hasil Rekomendasi</div>
                </div>
            </div>

            {{-- Step 1 --}}
            <div id="step1" class="form-card fade-slide opacity-0 translate-y-4">
                <div class="form-title">Industri & Jenis Unit</div>
                <div class="form-sub">Tentukan sektor usaha Anda dan tipe alat material handling yang ingin Anda cari.
                </div>
                <div class="field-group">
                    <div class="field">
                        <label>Sektor Industri Anda</label>
                        <select id="industri">
                            <option value="">-- Pilih Industri --</option>
                            @foreach($industries as $ind)
                                <option value="{{ $ind['code'] }}">{{ $ind['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field">
                        <label>Jenis Unit yang Dibutuhkan</label>
                        <select id="product_type">
                            <option value="">-- Pilih Jenis Unit --</option>
                            @foreach($productTypes as $pt)
                                <option value="{{ $pt['code'] }}">{{ $pt['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="btn-row">
                    <button class="btn btn-primary" onclick="goStep(2)">Lanjut &rarr;</button>
                </div>
            </div>

            {{-- Step 2 --}}
            <div id="step2" class="form-card" style="display:none">
                <div class="form-title">Spesifikasi Produk</div>
                <div class="form-sub">Tentukan preferensi energi penggerak, estimasi beban maksimum, dan jangkauan
                    angkat unit.</div>
                <div class="field-group">
                    <div class="field">
                        <label>Energi Penggerak (Drive Type)</label>
                        <select id="energi">
                            <option value="">-- Pilih Tipe Energi --</option>
                            @foreach($energies as $energy)
                                <option value="{{ $energy['code'] }}">{{ $energy['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field">
                        <label class="flex items-center gap-1.5">
                            <span>Kapasitas Beban (Load Capacity)</span>
                            <span class="group/tip relative cursor-help">
                                <span class="flex items-center justify-center w-4 h-4 rounded-full bg-zinc-100 border border-zinc-200 text-[10px] text-zinc-500 font-extrabold hover:bg-primary-50 hover:text-primary-900 hover:border-primary-200 transition-all">?</span>
                                <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-60 p-3 rounded-xl bg-zinc-900 text-zinc-100 text-xs font-normal normal-case text-left shadow-xl border border-zinc-800 opacity-0 group-hover/tip:opacity-100 transition-all duration-200 pointer-events-none z-50">
                                    Pilih kapasitas maksimum berat barang yang akan diangkat forklift.
                                </span>
                            </span>
                        </label>
                        <select id="berat">
                            <option value="">-- Pilih Kapasitas Beban --</option>
                            @foreach($weights as $weight)
                                <option value="{{ $weight['code'] }}">{{ $weight['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field full">
                        <label class="flex items-center gap-1.5">
                            <span>Tinggi Angkat yang Dibutuhkan (Lifting Height)</span>
                            <span class="group/tip relative cursor-help">
                                <span class="flex items-center justify-center w-4 h-4 rounded-full bg-zinc-100 border border-zinc-200 text-[10px] text-zinc-500 font-extrabold hover:bg-primary-50 hover:text-primary-900 hover:border-primary-200 transition-all">?</span>
                                <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-64 p-3 rounded-xl bg-zinc-900 text-zinc-100 text-xs font-normal normal-case text-left shadow-xl border border-zinc-800 opacity-0 group-hover/tip:opacity-100 transition-all duration-200 pointer-events-none z-50">
                                    Tentukan jangkauan vertikal tiang mast forklift (tinggi rak gudang tertinggi Anda).
                                </span>
                            </span>
                        </label>
                        <select id="tinggi">
                            <option value="">-- Pilih Tinggi Angkat --</option>
                            @foreach($heights as $height)
                                <option value="{{ $height['code'] }}">{{ $height['name'] }}</option>
                            @endforeach
                        </select>
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
        </div>

    </div>
</section>

<script>
    let currentStep = 1;

    // Load criteria lists from PHP with equipment_map values
    const rawEnergies = @json($energies);
    const rawWeights = @json($weights);
    const rawHeights = @json($heights);

    // Dynamic dropdown filtering
    function filterDssDropdown(fieldId, criteriaList, selectedUnitType) {
        const selectEl = document.getElementById(fieldId);
        if (!selectEl) return;

        const currentValue = selectEl.value;
        selectEl.innerHTML = '';

        // Add default placeholder option
        const placeholderOpt = document.createElement('option');
        placeholderOpt.value = '';
        if (fieldId === 'energi') {
            placeholderOpt.textContent = '-- Pilih Tipe Energi --';
        } else if (fieldId === 'berat') {
            placeholderOpt.textContent = '-- Pilih Kapasitas Beban --';
        } else {
            placeholderOpt.textContent = '-- Pilih Tinggi Angkat --';
        }
        selectEl.appendChild(placeholderOpt);

        criteriaList.forEach(opt => {
            // Option is allowed if:
            // 1. selectedUnitType is empty (show all)
            // 2. opt.equipment_map is null or empty array (no restriction)
            // 3. opt.equipment_map includes selectedUnitType
            const isAllowed = !selectedUnitType || 
                              !opt.equipment_map || 
                              opt.equipment_map.length === 0 || 
                              opt.equipment_map.includes(selectedUnitType);

            if (isAllowed) {
                const newOpt = document.createElement('option');
                newOpt.value = opt.code;
                newOpt.textContent = opt.name;
                selectEl.appendChild(newOpt);
            }
        });

        // Restore previously selected value if still valid
        if (Array.from(selectEl.options).some(opt => opt.value === currentValue)) {
            selectEl.value = currentValue;
        } else {
            selectEl.value = '';
        }
    }

    // Attach listener to product_type selection change
    document.addEventListener("DOMContentLoaded", () => {
        const productTypeSelect = document.getElementById('product_type');
        if (productTypeSelect) {
            productTypeSelect.addEventListener('change', function() {
                const selectedType = this.value;
                filterDssDropdown('energi', rawEnergies, selectedType);
                filterDssDropdown('berat', rawWeights, selectedType);
                filterDssDropdown('tinggi', rawHeights, selectedType);
            });
        }
    });

    function goStep(n) {
        document.getElementById('step' + currentStep).style.display = 'none';
        currentStep = n;
        const el = document.getElementById('step' + n);
        if (el) el.style.display = 'block';

        // Update Step Bar UI (3 steps total)
        [1, 2, 3].forEach(i => {
            const c = document.getElementById('sc' + i), l = document.getElementById('sl' + i);
            if (c) {
                c.className = 'step-circle' + (i < n ? ' done' : i === n ? ' active' : '');
                if (l) {
                    l.className = 'step-label' + (i === n ? ' active' : '');
                }
            }
        });
    }

    function runDSS() {
        const userInput = {
            industri: document.getElementById('industri').value || null,
            product_type: document.getElementById('product_type').value || null,
            energi: document.getElementById('energi').value || null,
            berat: document.getElementById('berat').value || null,
            tinggi: document.getElementById('tinggi').value || null,
        };

        goStep(3);
        const resultSection = document.getElementById('resultSection');
        resultSection.innerHTML = '<div class="dss-loading active"><p>Mencari rekomendasi unit terbaik untuk Anda...</p></div>';

        const token = document.querySelector('meta[name="csrf-token"]')?.content || '';

        fetch('/dss/process', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json',
            },
            body: JSON.stringify(userInput)
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success && data.results) {
                    renderResults(
                        data.results.utama,
                        data.results.alternatif,
                        data.results.total_found || 0
                    );
                } else if (data.errors) {
                    resultSection.innerHTML = '<div class="no-result text-red-500">Error: ' + data.errors.join(', ') + '</div>';
                } else {
                    resultSection.innerHTML = '<div class="no-result">Tidak ada rekomendasi yang ditemukan.</div>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                resultSection.innerHTML = '<div class="no-result">Terjadi kesalahan: ' + error.message + '</div>';
            });
    }

    function renderResults(utama, alternatif, totalFound) {
        const sec = document.getElementById('resultSection');
        let html = '';

        if (!utama) {
            sec.innerHTML = '<div class="no-result">Tidak ada unit yang cocok dengan kriteria spesifikasi ini.<br><span style="font-size:12px">Coba ubah tipe energi penggerak atau kapasitas beban Anda.</span></div>';
            return;
        }

        html += '<div class="result-header">Ditemukan rekomendasi unit yang sesuai</div>';
        html += '<div class="result-sub" style="margin-bottom:2rem">Berikut adalah unit terbaik dan alternatif untuk kebutuhan Anda:</div>';

        // Grid Container
        html += '<div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-stretch">';

        // 1. Rekomendasi Utama Card
        html += renderUnitCard(utama, 'Rekomendasi Utama', 'border-2 border-primary-500 bg-gradient-to-b from-amber-500/5 via-white to-white');

        // 2. Rekomendasi Alternatif Card
        if (alternatif) {
            html += renderUnitCard(alternatif, 'Rekomendasi Alternatif', 'border border-zinc-200 bg-white');
        } else {
            // Placeholder empty card if no alternative
            html += '<div class="flex flex-col items-center justify-center p-8 rounded-2xl border border-dashed border-zinc-300 bg-zinc-50 text-zinc-400 text-center">';
            html += '<svg class="w-12 h-12 mb-3 text-zinc-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>';
            html += '<p class="text-sm font-semibold text-zinc-500">Tidak ada unit alternatif</p>';
            html += '<p class="text-xs text-zinc-400 mt-1">Seluruh kriteria Anda sangat spesifik dan paling cocok dengan pilihan utama.</p>';
            html += '</div>';
        }

        html += '</div>'; // End Grid

        sec.innerHTML = html;
    }

    function renderUnitCard(eq, badgeTitle, classes) {
        const isUtama = badgeTitle === 'Rekomendasi Utama';
        const badgeClass = isUtama ? 'bg-primary-900 text-white' : 'bg-zinc-200 text-zinc-800';

        // Generate WhatsApp link
        const waNumber = '{{ preg_replace('/[^0-9]/', '', setting('whatsapp_number', '6281234567890')) }}';
        const productMessage = encodeURIComponent("Halo Herro Equipment Rentals, saya tertarik untuk menyewa unit rekomendasi SPK: " + eq.name + ".");
        const waUrl = "https://wa.me/" + waNumber + "?text=" + productMessage;

        let cardHtml = '<div class="flex flex-col h-full rounded-[1.5rem] p-6 shadow-xl transition-all duration-300 hover:shadow-2xl ' + classes + '">';

        // Header Row (Badge)
        cardHtml += '<div class="flex items-center justify-between mb-4">';
        cardHtml += '<span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider ' + badgeClass + '">' + badgeTitle + '</span>';
        cardHtml += '</div>';

        // Image representation
        if (eq.image) {
            cardHtml += '<div class="aspect-[4/3] w-full rounded-2xl overflow-hidden bg-zinc-50 border border-zinc-100 flex items-center justify-center mb-4">';
            cardHtml += '<img src="' + eq.image + '" alt="' + eq.name + '" class="w-full h-full object-cover">';
            cardHtml += '</div>';
        } else {
            // Default placeholder if image not set
            cardHtml += '<div class="aspect-[4/3] w-full rounded-2xl overflow-hidden bg-zinc-100 border border-zinc-150 flex flex-col items-center justify-center mb-4 text-zinc-400">';
            cardHtml += '<svg class="w-8 h-8 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>';
            cardHtml += '<span class="text-[10px]">Belum ada gambar</span>';
            cardHtml += '</div>';
        }

        // Title info
        cardHtml += '<div class="flex-1">';
        cardHtml += '<h3 class="text-sm sm:text-base font-bold text-zinc-955 line-clamp-2 leading-snug">' + eq.name + '</h3>';
        cardHtml += '<p class="text-[10px] sm:text-xs text-zinc-500 font-semibold mt-1">' + eq.category + ' | ' + eq.type + '</p>';

        // Specs list
        cardHtml += '<div class="mt-4 space-y-2 border-t border-zinc-100 pt-3 text-xs text-zinc-650">';
        cardHtml += '<div class="flex justify-between"><span>Kapasitas Beban</span><strong class="text-zinc-900">' + eq.capacity + '</strong></div>';
        cardHtml += '<div class="flex justify-between"><span>Tinggi Mast</span><strong class="text-zinc-900">' + eq.mast_height + '</strong></div>';
        cardHtml += '<div class="flex justify-between"><span>Baterai / Engine</span><strong class="text-zinc-900">' + eq.battery + '</strong></div>';
        cardHtml += '</div>';
        cardHtml += '</div>';

        // Action Buttons Row (WhatsApp + Detail Page)
        cardHtml += '<div class="mt-6 pt-4 border-t border-zinc-100 flex flex-col sm:flex-row gap-3">';

        // WhatsApp button
        cardHtml += '<a href="' + waUrl + '" target="_blank" class="inline-flex items-center justify-center gap-1.5 flex-1 rounded-xl bg-green-600 hover:bg-green-700 text-white py-3 text-xs font-bold transition duration-200">';
        cardHtml += '<svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.746.953 3.71 1.455 5.703 1.456h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>';
        cardHtml += 'Sewa Unit</a>';

        // Detail page button
        if (eq.slug) {
            const detailUrl = "/produk/" + eq.slug;
            cardHtml += '<a href="' + detailUrl + '" class="inline-flex items-center justify-center gap-1.5 flex-1 rounded-xl bg-zinc-50 border border-zinc-200 text-zinc-800 hover:bg-zinc-100 py-3 text-xs font-bold transition duration-200">';
            cardHtml += '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>';
            cardHtml += 'Detail Unit</a>';
        }

        cardHtml += '</div>'; // End Actions
        cardHtml += '</div>'; // End Card

        return cardHtml;
    }

    function reset() {
        document.getElementById('industri').value = '';
        document.getElementById('product_type').value = '';
        document.getElementById('berat').value = '';
        document.getElementById('tinggi').value = '';
        document.getElementById('energi').value = '';
        document.getElementById('step3').style.display = 'none';

        // Reset dynamic dropdown filters
        filterDssDropdown('energi', rawEnergies, '');
        filterDssDropdown('berat', rawWeights, '');
        filterDssDropdown('tinggi', rawHeights, '');

        goStep(1);
    }
</script>
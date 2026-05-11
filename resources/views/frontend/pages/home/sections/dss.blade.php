<style>
:root {
    --primary-color: {{ $primaryColor ?? '#ff7f00' }};
    --color-text-secondary: #6b7280;
    --color-border-tertiary: #e5e7eb;
    --font-sans: inherit;
}

* { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: var(--font-sans); }

.dss-wrap {
    padding: 2rem 0;
    max-width: 900px;
    margin: 0 auto;
}

.step-bar {
    display: flex;
    align-items: center;
    gap: 0;
    margin-bottom: 2.5rem;
    background: #f9fafb;
    padding: 1.5rem;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
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
    top: 14px;
    left: 60%;
    width: 80%;
    height: 2px;
    background: #e5e7eb;
    z-index: 0;
}

.step-item:not(:last-child).active::after,
.step-item:not(:last-child).done::after {
    background: var(--primary-color);
}

.step-circle {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: 2px solid #d1d5db;
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    font-weight: 600;
    color: #6b7280;
    position: relative;
    z-index: 1;
    transition: all 0.3s ease;
}

.step-circle.active {
    background: var(--primary-color);
    border-color: var(--primary-color);
    color: white;
}

.step-circle.done {
    background: var(--primary-color);
    border-color: var(--primary-color);
    color: white;
}

.step-label {
    font-size: 12px;
    color: #6b7280;
    margin-top: 6px;
    text-align: center;
    max-width: 80px;
    font-weight: 500;
}

.step-label.active {
    color: var(--primary-color);
    font-weight: 600;
}

.form-card {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 2rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    transition: all 0.2s ease;
}

.form-card:hover {
    border-color: #d1d5db;
    box-shadow: 0 2px 6px rgba(0,0,0,0.08);
}

.form-title {
    font-size: 18px;
    font-weight: 600;
    color: #111827;
    margin-bottom: 0.5rem;
}

.form-sub {
    font-size: 14px;
    color: #6b7280;
    margin-bottom: 1.5rem;
    line-height: 1.5;
}

.field-group {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}

.field {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.field.full {
    grid-column: 1 / -1;
}

label {
    font-size: 14px;
    color: #374151;
    font-weight: 500;
    margin-bottom: 2px;
}

select, input {
    width: 100%;
    padding: 10px 12px;
    font-size: 14px;
    font-family: var(--font-sans);
    background: white;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    color: #111827;
    transition: all 0.2s ease;
}

select:hover, input:hover {
    border-color: #9ca3af;
}

select:focus, input:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(255, 127, 0, 0.1);
    background: white;
}

.chip-group {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 4px;
}

.chip {
    padding: 8px 16px;
    border-radius: 24px;
    border: 1.5px solid #d1d5db;
    font-size: 13px;
    cursor: pointer;
    color: #374151;
    background: white;
    transition: all 0.2s ease;
    font-weight: 500;
}

.chip:hover {
    border-color: var(--primary-color);
    color: var(--primary-color);
    background: rgba(29, 158, 117, 0.08);
}

.chip.selected {
    background: var(--primary-color);
    border-color: var(--primary-color);
    color: white;
    font-weight: 600;
}

.btn-row {
    display: flex;
    gap: 12px;
    justify-content: flex-end;
    margin-top: 2rem;
}

.btn {
    padding: 10px 24px;
    border-radius: 8px;
    border: 1px solid #d1d5db;
    font-size: 14px;
    cursor: pointer;
    font-family: var(--font-sans);
    font-weight: 500;
    transition: all 0.2s ease;
}

.btn-secondary {
    background: white;
    color: #374151;
    border-color: #d1d5db;
}

.btn-secondary:hover {
    background: #f3f4f6;
    border-color: #9ca3af;
}

.btn-primary {
    background: var(--primary-color);
    border-color: var(--primary-color);
    color: white;
    font-weight: 600;
}

.btn-primary:hover {
    background: #e67e00;
    border-color: #e67e00;
    box-shadow: 0 4px 12px rgba(255, 127, 0, 0.3);
}

.btn-primary:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.result-header {
    font-size: 16px;
    font-weight: 600;
    color: #111827;
    margin-bottom: 6px;
}

.result-sub {
    font-size: 14px;
    color: #6b7280;
    margin-bottom: 1.5rem;
}

.product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 16px;
}

.product-card {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 1.25rem;
    cursor: pointer;
    transition: all 0.2s ease;
}

.product-card:hover {
    border-color: var(--primary-color);
    box-shadow: 0 4px 12px rgba(255, 127, 0, 0.15);
}

.product-card.top {
    border: 2px solid var(--primary-color);
    background: #fff8f0;
    box-shadow: 0 2px 8px rgba(255, 127, 0, 0.12);
}

.badge {
    display: inline-block;
    font-size: 11px;
    padding: 4px 12px;
    border-radius: 20px;
    margin-bottom: 10px;
    font-weight: 600;
}

.badge-top {
    background: rgba(255, 127, 0, 0.1);
    color: var(--primary-color);
}

.badge-match {
    background: #f3f4f6;
    color: #374151;
}

.badge-type {
    background: #eff6ff;
    color: #1e40af;
}

.product-name {
    font-size: 14px;
    font-weight: 600;
    color: #111827;
    margin-bottom: 8px;
    line-height: 1.4;
}

.product-meta {
    font-size: 13px;
    color: #6b7280;
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.meta-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.meta-val {
    color: var(--primary-color);
    font-weight: 600;
}

.no-result {
    text-align: center;
    padding: 2.5rem 1.5rem;
    color: #6b7280;
    font-size: 14px;
    background: #f9fafb;
    border: 1px dashed #d1d5db;
    border-radius: 8px;
}

.dss-loading {
    display: none;
    text-align: center;
    padding: 3rem 1.5rem;
    color: #6b7280;
}

.dss-loading.active {
    display: block;
}

.dss-loading p {
    margin: 0;
    font-size: 14px;
}

@media (max-width: 640px) {
    .dss-wrap {
        padding: 1rem 0;
    }

    .form-card {
        padding: 1.5rem;
    }

    .field-group {
        grid-template-columns: 1fr;
        gap: 12px;
    }

    .step-bar {
        padding: 1rem;
        gap: 4px;
    }

    .step-label {
        font-size: 10px;
        max-width: 70px;
    }

    .product-grid {
        grid-template-columns: 1fr;
    }

    .btn-row {
        flex-direction: column;
    }

    .btn {
        width: 100%;
    }
}
</style>

<section class="py-20 sm:py-24 bg-white" id="dssSection">
    <div class="mx-auto max-w-7xl px-6 sm:px-12 lg:px-20">

        {{-- HEADER --}}
        <div class="mx-auto max-w-2xl text-center mb-16">
            <span class="inline-flex items-center rounded-full
                           bg-primary-100
                           px-3 py-1.5
                           text-xs font-medium tracking-wide
                           text-primary-800">
                Rekomendasi Equipment
            </span>

            <h2 class="mt-4
                       text-xl sm:text-2xl lg:text-3xl
                       font-semibold tracking-tight leading-tight
                       text-zinc-900">
                Temukan Peralatan yang Tepat untuk Bisnis Anda
            </h2>

            <p class="mt-4
                       text-sm sm:text-base
                       leading-relaxed
                       text-zinc-600">
                Isi formulir di bawah dan dapatkan rekomendasi equipment yang sesuai dengan kebutuhan operasional Anda.
            </p>
        </div>

        <div class="dss-wrap">
            <div class="step-bar" id="stepBar">
                <div class="step-item"><div class="step-circle active" id="sc1">1</div><div class="step-label active" id="sl1">Lokasi & Industri</div></div>
                <div class="step-item"><div class="step-circle" id="sc2">2</div><div class="step-label" id="sl2">Muatan & Berat</div></div>
                <div class="step-item"><div class="step-circle" id="sc3">3</div><div class="step-label" id="sl3">Kondisi Operasional</div></div>
                <div class="step-item"><div class="step-circle" id="sc4">4</div><div class="step-label" id="sl4">Hasil Rekomendasi</div></div>
            </div>

            <div id="step1" class="form-card">
                <div class="form-title">Lokasi & Industri</div>
                <div class="form-sub">Lokasi operasional dan jenis industri menentukan regulasi dan tipe unit yang sesuai.</div>
                <div class="field-group">
                    <div class="field">
                        <label>Lokasi operasional</label>
                        <select id="lokasi">
                            <option value="">-- Pilih lokasi --</option>
                            @foreach($locations as $loc)
                                <option value="{{ $loc['code'] }}">{{ $loc['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field">
                        <label>Jenis industri</label>
                        <select id="industri">
                            <option value="">-- Pilih industri --</option>
                            @foreach($industries as $ind)
                                <option value="{{ $ind['code'] }}">{{ $ind['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="btn-row"><button class="btn btn-primary" onclick="goStep(2)">Lanjut &rarr;</button></div>
            </div>

            <div id="step2" class="form-card" style="display:none">
                <div class="form-title">Muatan & Kapasitas</div>
                <div class="form-sub">Pilih jenis barang yang diangkut dan estimasi berat maksimum sekali angkat.</div>
                <div class="field full" style="margin-bottom:1rem">
                    <label>Jenis barang yang diangkut (pilih semua yang sesuai)</label>
                    <div class="chip-group" id="muatanChips">
                        @foreach($cargoTypes as $cargo)
                            <div class="chip" data-val="{{ $cargo['code'] }}" onclick="toggleChip(this)">{{ $cargo['name'] }}</div>
                        @endforeach
                    </div>
                </div>
                <div class="field-group">
                    <div class="field">
                        <label>Berat maksimum sekali angkat</label>
                        <select id="berat">
                            <option value="">-- Pilih berat --</option>
                            @foreach($weights as $weight)
                                <option value="{{ $weight['code'] }}">{{ $weight['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field">
                        <label>Ketinggian angkat yang dibutuhkan</label>
                        <select id="tinggi">
                            <option value="">-- Pilih ketinggian --</option>
                            @foreach($heights as $height)
                                <option value="{{ $height['code'] }}">{{ $height['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="btn-row">
                    <button class="btn btn-secondary" onclick="goStep(1)">&larr; Kembali</button>
                    <button class="btn btn-primary" onclick="goStep(3)">Lanjut &rarr;</button>
                </div>
            </div>

            <div id="step3" class="form-card" style="display:none">
                <div class="form-title">Kondisi Operasional</div>
                <div class="form-sub">Detail operasional untuk menentukan tipe energi dan fitur spesifik unit.</div>
                <div class="field-group">
                    <div class="field">
                        <label>Lebar lorong / aisle tersempit</label>
                        <select id="aisle">
                            <option value="">-- Pilih --</option>
                            @foreach($aisles as $aisle)
                                <option value="{{ $aisle['code'] }}">{{ $aisle['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field">
                        <label>Preferensi sumber energi</label>
                        <select id="energi">
                            <option value="">-- Pilih --</option>
                            @foreach($energies as $energy)
                                <option value="{{ $energy['code'] }}">{{ $energy['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field">
                        <label>Unit yang dipakai sekarang</label>
                        <select id="unitSekarang">
                            <option value="">-- Pilih --</option>
                            @foreach($units as $unit)
                                <option value="{{ $unit['code'] }}">{{ $unit['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field">
                        <label>Operator (posisi berkendara)</label>
                        <select id="operator">
                            <option value="">-- Pilih --</option>
                            @foreach($operators as $op)
                                <option value="{{ $op['code'] }}">{{ $op['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="btn-row">
                    <button class="btn btn-secondary" onclick="goStep(2)">&larr; Kembali</button>
                    <button class="btn btn-primary" onclick="runDSS()">Cari Rekomendasi &rarr;</button>
                </div>
            </div>

            <div id="step4" style="display:none">
                <div class="form-card" id="resultSection">
                    <div class="dss-loading active">
                        <p>Mencari rekomendasi equipment yang sesuai dengan kriteria Anda...</p>
                    </div>
                </div>
                <div style="text-align:center; margin-top: 0.5rem;">
                    <button class="btn btn-secondary" onclick="reset()">Mulai ulang pencarian</button>
                </div>
            </div>
        </div>

    </div>
</section>

<script>
let currentStep = 1;

function toggleChip(el) {
    el.classList.toggle('selected');
}

function muatanSelected() {
    return [...document.querySelectorAll('#muatanChips .chip.selected')].map(c => c.dataset.val);
}

function goStep(n) {
    document.getElementById('step' + currentStep).style.display = 'none';
    currentStep = n;
    const el = document.getElementById('step' + n);
    if (el) el.style.display = 'block';
    [1, 2, 3, 4].forEach(i => {
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
        lokasi: document.getElementById('lokasi').value || null,
        industri: document.getElementById('industri').value || null,
        muatan: muatanSelected(),
        berat: document.getElementById('berat').value || null,
        tinggi: document.getElementById('tinggi').value || null,
        aisle: document.getElementById('aisle').value || null,
        energi: document.getElementById('energi').value || null,
        operator: document.getElementById('operator').value || null,
        unitSekarang: document.getElementById('unitSekarang').value || null,
    };

    goStep(4);
    const resultSection = document.getElementById('resultSection');
    resultSection.innerHTML = '<div class="dss-loading active"><p>Mencari rekomendasi equipment yang sesuai dengan kriteria Anda...</p></div>';

    // Send AJAX request
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
                data.results.top_recommendations || [],
                data.results.other_recommendations || [],
                data.results.total_found || 0
            );
        } else if (data.errors) {
            resultSection.innerHTML = '<div class="no-result">Error: ' + data.errors.join(', ') + '</div>';
        } else {
            resultSection.innerHTML = '<div class="no-result">Tidak ada hasil ditemukan</div>';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        resultSection.innerHTML = '<div class="no-result">Terjadi kesalahan: ' + error.message + '</div>';
    });
}

function renderResults(topRecs, otherRecs, totalFound) {
    const sec = document.getElementById('resultSection');

    let html = '';

    if (topRecs.length === 0 && otherRecs.length === 0) {
        sec.innerHTML = '<div class="no-result">Tidak ada equipment yang cocok dengan kriteria ini.<br><span style="font-size:12px">Coba ubah preferensi energi atau berat muatan.</span></div>';
        return;
    }

    html += '<div class="result-header">Ditemukan ' + totalFound + ' equipment yang sesuai</div>';
    html += '<div class="result-sub" style="margin-bottom:1rem">Rekomendasi utama berdasarkan kecocokan kriteria:</div>';
    html += '<div class="product-grid">';

    topRecs.forEach((eq, i) => {
        const isTop = i === 0;
        html += '<div class="product-card ' + (isTop ? 'top' : '') + '">';
        html += isTop ? '<span class="badge badge-top">Rekomendasi Utama</span>' : '<span class="badge badge-match">Cocok</span>';
        html += '<div class="product-name">' + eq.name + '</div>';
        html += '<div class="product-meta">';
        html += '<div class="meta-row"><span>Tipe</span><span class="meta-val" style="font-size:11px;text-align:right;max-width:60%">' + eq.type + '</span></div>';
        html += '<div class="meta-row"><span>Kapasitas</span><span class="meta-val">' + (eq.capacity.display || '0kg') + '</span></div>';
        html += '<div class="meta-row"><span>Energi</span><span class="meta-val">' + (eq.energy === 'lithium' ? 'Lithium' : eq.energy === 'diesel' ? 'Diesel' : 'Electric') + '</span></div>';
        html += '<div class="meta-row"><span>Operator</span><span class="meta-val">' + eq.operator_type + '</span></div>';
        html += '</div>';
        html += '</div>';
    });

    html += '</div>';

    if (otherRecs.length > 0) {
        html += '<div style="margin-top:1.25rem;font-size:13px;font-weight:500;color:var(--color-text-secondary);margin-bottom:0.75rem">' + otherRecs.length + ' equipment lain yang memenuhi kriteria:</div>';
        html += '<div class="product-grid">';
        otherRecs.forEach(eq => {
            html += '<div class="product-card">';
            html += '<span class="badge badge-type">' + eq.category + '</span>';
            html += '<div class="product-name">' + eq.name + '</div>';
            html += '<div class="product-meta">';
            html += '<div class="meta-row"><span>Kapasitas</span><span class="meta-val">' + (eq.capacity.display || '0kg') + '</span></div>';
            html += '<div class="meta-row"><span>Energi</span><span class="meta-val">' + (eq.energy === 'lithium' ? 'Lithium' : eq.energy === 'diesel' ? 'Diesel' : 'Electric') + '</span></div>';
            html += '</div>';
            html += '</div>';
        });
        html += '</div>';
    }

    html += '<div style="margin-top:1.25rem;padding-top:1rem;border-top:0.5px solid var(--color-border-tertiary);text-align:center">';
    html += '<button class="btn btn-primary" onclick="sendPrompt(\'Saya tertarik dengan rekomendasi equipment ini, bisa jelaskan lebih detail dan hubungi tim Herro Equipment Rental?\')">Hubungi kami untuk konsultasi &nearr;</button>';
    html += '</div>';

    sec.innerHTML = html;
}

function sendPrompt(message) {
    // Scroll to contact form and prefill subject + message
    const form = document.getElementById('contactForm');
    if (form) {
        form.scrollIntoView({ behavior: 'smooth', block: 'center' });

        const subjectField = form.querySelector('[name="subject"]');
        const messageField = form.querySelector('[name="message"]');
        if (subjectField) subjectField.value = 'Konsultasi Equipment dari DSS';
        if (messageField) messageField.value = message;

        // Highlight the message field briefly
        if (messageField) {
            messageField.classList.add('ring-2', 'ring-primary-500/40');
            setTimeout(() => messageField.classList.remove('ring-2', 'ring-primary-500/40'), 1500);
        }
    }
}

function reset() {
    document.getElementById('lokasi').value = '';
    document.getElementById('industri').value = '';
    document.getElementById('berat').value = '';
    document.getElementById('tinggi').value = '';
    document.getElementById('aisle').value = '';
    document.getElementById('energi').value = '';
    document.getElementById('operator').value = '';
    document.getElementById('unitSekarang').value = '';
    document.querySelectorAll('#muatanChips .chip').forEach(c => c.classList.remove('selected'));
    document.getElementById('step4').style.display = 'none';
    goStep(1);
}
</script>

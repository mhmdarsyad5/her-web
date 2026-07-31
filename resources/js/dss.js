let currentStep = 1;
let cities = [];
let currentRecommendedProducts = [];

// Fetch Indonesia cities list dynamically and setup modal placement
document.addEventListener("DOMContentLoaded", () => {
    // Only run if the dssSection is on the page
    const dssSec = document.getElementById('dssSection');
    if (!dssSec) return;

    // Move alert modal to body to break out of CSS stacking context restriction
    const modal = document.getElementById('dssAlertModal');
    if (modal) {
        document.body.appendChild(modal);
    }

    fetch('/js/indonesia-cities.json')
        .then(response => response.json())
        .then(data => {
            cities = data;
            initCityAutocomplete();
        })
        .catch(err => console.error('Error loading cities:', err));
});

function initCityAutocomplete() {
    const input = document.getElementById('kota');
    const dropdown = document.getElementById('cityDropdown');
    if (!input || !dropdown) return;

    input.addEventListener('input', function() {
        const val = this.value.trim().toLowerCase();
        dropdown.innerHTML = '';
        if (!val) {
            dropdown.classList.add('hidden');
            return;
        }

        const filtered = cities.filter(c => c.toLowerCase().includes(val)).slice(0, 10);
        if (filtered.length === 0) {
            dropdown.classList.add('hidden');
            return;
        }

        filtered.forEach(city => {
            const item = document.createElement('div');
            item.className = 'px-4 py-2 hover:bg-zinc-50 cursor-pointer text-sm text-zinc-700 transition-colors';
            item.textContent = city;
            item.addEventListener('click', function() {
                input.value = city;
                dropdown.classList.add('hidden');
            });
            dropdown.appendChild(item);
        });
        dropdown.classList.remove('hidden');
    });

    document.addEventListener('click', function(e) {
        if (!input.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.classList.add('hidden');
        }
    });
}

function goStep(n) {
    document.getElementById('step' + currentStep).style.display = 'none';
    currentStep = n;
    const el = document.getElementById('step' + n);
    if (el) el.style.display = 'block';

    // Update Step Bar UI (4 steps total)
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

function goStep2() {
    const industri = document.getElementById('industri').value;
    const kota = document.getElementById('kota').value.trim();

    if (!industri) {
        showDssAlert('Silakan pilih sektor industri Anda.');
        return;
    }
    if (!kota) {
        showDssAlert('Silakan masukkan lokasi kota Anda.');
        return;
    }

    // If user selects "others" (Lainnya), we still let them proceed to Stage 2 to specify specs
    goStep(2);
}

function runDSS() {
    const beratVal = document.getElementById('berat').value;
    const tinggiVal = document.getElementById('tinggi').value;

    if (!beratVal || parseFloat(beratVal) <= 0) {
        showDssAlert('Silakan masukkan berat beban yang valid (min. 1 kg).');
        return;
    }
    if (tinggiVal === '' || parseFloat(tinggiVal) < 0) {
        showDssAlert('Silakan masukkan tinggi angkat yang valid (min. 0 meter).');
        return;
    }

    const userInput = {
        industri: document.getElementById('industri').value || null,
        kota: document.getElementById('kota').value || null,
        berat: beratVal,
        tinggi: tinggiVal,
    };

    goStep(3);
    const resultSection = document.getElementById('resultSection');
    resultSection.innerHTML = '<div class="dss-loading active"><p>Mencari rekomendasi unit terbaik untuk Anda...</p></div>';

    // Scroll smoothly to top of dssSection immediately
    const dssSec = document.getElementById('dssSection');
    if (dssSec) {
        dssSec.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

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
                renderResults(data.results.products, data.results.total_found || 0);
            } else if (data.errors) {
                resultSection.innerHTML = '<div class="no-result text-red-500 font-semibold">Error: ' + data.errors.join(', ') + '</div>';
            } else {
                renderEmptyState();
            }

            // Scroll smoothly to top of dssSection again to align with the loaded content height
            if (dssSec) {
                dssSec.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            resultSection.innerHTML = '<div class="no-result text-red-500 font-semibold">Terjadi kesalahan: ' + error.message + '</div>';

            // Scroll smoothly to top of dssSection on error
            if (dssSec) {
                dssSec.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
}

function renderResults(products, totalFound) {
    const sec = document.getElementById('resultSection');
    let html = '';

    if (!products || products.length === 0) {
        currentRecommendedProducts = [];
        renderEmptyState();
        return;
    }

    currentRecommendedProducts = products;

    html += '<div class="result-header">Ditemukan rekomendasi unit yang sesuai</div>';
    html += '<div class="result-sub" style="margin-bottom:2rem">Berikut adalah unit terbaik yang memenuhi spesifikasi kebutuhan Anda:</div>';

    // Group products by product_type_name
    const grouped = {};
    products.forEach(prod => {
        const typeName = prod.product_type_name || 'Lainnya';
        if (!grouped[typeName]) {
            grouped[typeName] = [];
        }
        grouped[typeName].push(prod);
    });

    // Loop through each group and render them
    for (const [typeName, items] of Object.entries(grouped)) {
        html += '<div class="group-section mb-10">';
        
        // Group Header (Elegant and premium styling)
        html += '  <div class="flex items-center gap-2.5 mb-5 border-b border-zinc-150 pb-3">';
        html += '    <span class="w-1.5 h-6 rounded-full" style="background-color: var(--primary-color);"></span>';
        html += '    <h3 class="text-base sm:text-lg font-extrabold text-zinc-900 tracking-tight">' + typeName + '</h3>';
        html += '    <span class="inline-flex items-center justify-center px-2 py-0.5 text-xs font-semibold rounded-full" style="color: var(--primary-color); background-color: rgba(255, 127, 0, 0.08);">' + items.length + ' Unit</span>';
        html += '  </div>';

        // Grid Container for this group
        html += '  <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-stretch">';
        items.forEach((prod) => {
            html += renderUnitCard(prod);
        });
        html += '  </div>'; // End Grid for this group
        html += '</div>'; // End Group Section
    }

    // Add the CTA banner to request official quote (Stage 4)
    html += '<div class="mt-12 p-6 sm:p-8 rounded-2xl bg-zinc-50 border border-zinc-200/60 text-center flex flex-col items-center justify-center shadow-sm">';
    html += '  <h4 class="text-base sm:text-lg font-extrabold text-zinc-900 mb-1.5 tracking-tight">Tertarik dengan unit rekomendasi di atas?</h4>';
    html += '  <p class="text-xs sm:text-sm text-zinc-500 mb-5 max-w-md leading-relaxed">Lengkapi data kontak Anda untuk meminta dokumen penawaran harga resmi secara gratis dari tim sales kami.</p>';
    html += '  <button onclick="goToQuoteForm()" class="btn btn-primary w-full sm:w-auto px-8 py-3.5 text-xs sm:text-sm">Minta Penawaran Resmi &rarr;</button>';
    html += '</div>';

    sec.innerHTML = html;
}

function renderEmptyState() {
    const sec = document.getElementById('resultSection');
    const dssSec = document.getElementById('dssSection');
    const waNumber = dssSec ? dssSec.getAttribute('data-whatsapp') : '6281234567890';
    
    const beratVal = document.getElementById('berat').value;
    const tinggiVal = document.getElementById('tinggi').value;
    const kotaVal = document.getElementById('kota').value;
    
    const message = encodeURIComponent(`Halo Herro Equipment Rentals, saya membutuhkan rekomendasi unit khusus untuk kota ${kotaVal} dengan spesifikasi kapasitas ${beratVal} kg and tinggi ${tinggiVal} meter.`);
    const waUrl = "https://wa.me/" + waNumber + "?text=" + message;

    let html = '<div class="no-result flex flex-col items-center justify-center p-8 text-center">';
    html += '<svg class="w-16 h-16 mb-4 text-zinc-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>';
    html += '<p class="text-base font-bold text-zinc-800 mb-2">Spesifikasi Tidak Ditemukan</p>';
    html += '<p class="text-sm text-zinc-500 mb-6 max-w-md">Maaf, tidak ada unit standard kami yang cocok dengan kriteria spesifikasi ini secara tepat. Silakan konsultasikan langsung dengan tim ahli kami untuk solusi khusus.</p>';
    html += '<a href="' + waUrl + '" target="_blank" class="inline-flex items-center justify-center gap-2 rounded-xl bg-green-600 hover:bg-green-700 text-white px-6 py-3.5 text-sm font-bold shadow-lg transition duration-200">';
    html += '<svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.746.953 3.71 1.455 5.703 1.456h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>';
    html += 'Hubungi Tim Ahli Kami</a>';
    html += '</div>';
    
    sec.innerHTML = html;
}

function renderUnitCard(prod) {
    // Generate WhatsApp link
    const dssSec = document.getElementById('dssSection');
    const waNumber = dssSec ? dssSec.getAttribute('data-whatsapp') : '6281234567890';
    const kotaVal = document.getElementById('kota').value;
    const productMessage = encodeURIComponent(`Halo Herro Equipment Rentals, saya tertarik untuk menyewa unit rekomendasi: ${prod.name} untuk operasional di kota ${kotaVal}.`);
    const waUrl = "https://wa.me/" + waNumber + "?text=" + productMessage;

    let cardHtml = '<div class="relative flex flex-col h-full rounded-[1.5rem] p-6 shadow-xl border ' + (prod.is_featured ? 'border-orange-400 ring-2 ring-orange-400/20' : 'border-zinc-150') + ' bg-white transition-all duration-300 hover:shadow-2xl hover:border-primary-300">';

    if (prod.is_featured) {
        cardHtml += '<div class="absolute -top-3.5 left-6 flex items-center gap-1.5 text-white text-[10px] font-extrabold px-3 py-1.5 rounded-xl tracking-wider shadow-md z-10 select-none uppercase" style="background: linear-gradient(135deg, #ff9f00 0%, #ff6f00 100%); border: 1px solid rgba(255,255,255,0.15);">';
        cardHtml += '  <svg class="w-3.5 h-3.5 fill-current text-white" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>';
        cardHtml += '  rekomendasi utama';
        cardHtml += '</div>';
    }

    // Image representation
    if (prod.image) {
        cardHtml += '<div class="aspect-[4/3] w-full rounded-2xl overflow-hidden bg-zinc-50 border border-zinc-100 flex items-center justify-center mb-4">';
        cardHtml += '<img src="' + prod.image + '" alt="' + prod.name + '" class="w-full h-full object-cover">';
        cardHtml += '</div>';
    } else {
        cardHtml += '<div class="aspect-[4/3] w-full rounded-2xl overflow-hidden bg-zinc-100 border border-zinc-150 flex flex-col items-center justify-center mb-4 text-zinc-400">';
        cardHtml += '<svg class="w-8 h-8 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>';
        cardHtml += '<span class="text-[10px]">Belum ada gambar</span>';
        cardHtml += '</div>';
    }

    // Title info
    cardHtml += '<div class="flex-1">';
    cardHtml += '<h3 class="text-sm sm:text-base font-bold text-zinc-955 line-clamp-2 leading-snug">' + prod.name + '</h3>';
    cardHtml += '<p class="text-[10px] sm:text-xs text-zinc-500 font-semibold mt-1">' + (prod.type || '-') + '</p>';
    if (prod.tagline) {
        cardHtml += '<p class="text-[11px] text-zinc-500 italic mt-2 leading-relaxed">' + prod.tagline + '</p>';
    }

    // Specs list
    cardHtml += '<div class="mt-4 space-y-2 border-t border-zinc-100 pt-3 text-xs text-zinc-650">';
    cardHtml += '<div class="flex justify-between"><span>Kapasitas Beban</span><strong class="text-zinc-900">' + prod.capacity + '</strong></div>';
    cardHtml += '<div class="flex justify-between"><span>Tinggi Maksimal</span><strong class="text-zinc-900">' + prod.lift_height + '</strong></div>';
    cardHtml += '<div class="flex justify-between"><span>Tipe Operator</span><strong class="text-zinc-900">' + (prod.operator_type || '-') + '</strong></div>';
    cardHtml += '</div>';
    cardHtml += '</div>';

    // Action Buttons Row (WhatsApp + Detail Page)
    cardHtml += '<div class="mt-6 pt-4 border-t border-zinc-100 flex flex-col sm:flex-row gap-3">';

    // WhatsApp button
    cardHtml += '<a href="' + waUrl + '" target="_blank" class="inline-flex items-center justify-center gap-1.5 flex-1 rounded-xl bg-green-600 hover:bg-green-700 text-white py-3 text-xs font-bold transition duration-200">';
    cardHtml += '<svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.746.953 3.71 1.455 5.703 1.456h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" /></svg>';
    cardHtml += 'Sewa Unit</a>';

    // Detail page button
    if (prod.slug) {
        const detailUrl = "/produk/" + prod.slug;
        cardHtml += '<a href="' + detailUrl + '" class="inline-flex items-center justify-center gap-1.5 flex-1 rounded-xl bg-zinc-50 border border-zinc-200 text-zinc-800 hover:bg-zinc-100 py-3 text-xs font-bold transition duration-200">';
        cardHtml += '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>';
        cardHtml += 'Detail Unit</a>';
    }

    cardHtml += '</div>'; // End Actions
    cardHtml += '</div>'; // End Card

    return cardHtml;
}

function goToQuoteForm() {
    const indSelect = document.getElementById('industri');
    const indName = indSelect.options[indSelect.selectedIndex]?.text || '';
    const kotaVal = document.getElementById('kota').value.trim();

    document.getElementById('lead_industry').value = indName;
    document.getElementById('lead_location').value = kotaVal;

    // Reset form area and hide thank you area
    document.getElementById('leadFormArea').style.display = 'block';
    document.getElementById('thankYouArea').style.display = 'none';

    // Clear values
    document.getElementById('lead_name').value = '';
    document.getElementById('lead_company').value = '';
    document.getElementById('lead_email').value = '';
    document.getElementById('lead_whatsapp').value = '';

    goStep(4);

    // Scroll smoothly to top of dssSection
    const dssSec = document.getElementById('dssSection');
    if (dssSec) {
        dssSec.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
}

function submitLeadForm() {
    const name = document.getElementById('lead_name').value.trim();
    const company = document.getElementById('lead_company').value.trim();
    const email = document.getElementById('lead_email').value.trim();
    const whatsapp = document.getElementById('lead_whatsapp').value.trim();

    if (!name) {
        showDssAlert('Silakan masukkan nama lengkap Anda.');
        return;
    }
    if (!company) {
        showDssAlert('Silakan masukkan nama perusahaan Anda.');
        return;
    }
    if (!email || !email.includes('@')) {
        showDssAlert('Silakan masukkan alamat email yang valid.');
        return;
    }
    if (!whatsapp) {
        showDssAlert('Silakan masukkan nomor WhatsApp Anda.');
        return;
    }

    const btn = document.getElementById('btnSubmitLead');
    btn.disabled = true;
    btn.innerText = 'Mengirim...';

    const payload = {
        name: name,
        company_name: company,
        email: email,
        whatsapp_number: whatsapp,
        industri: document.getElementById('industri').value || '',
        kota: document.getElementById('kota').value || '',
        berat: document.getElementById('berat').value || 0,
        tinggi: document.getElementById('tinggi').value || 0,
        recommended_products: currentRecommendedProducts.map(p => ({ name: p.name, slug: p.slug }))
    };

    const token = document.querySelector('meta[name="csrf-token"]')?.content || '';

    fetch('/dss/submit-lead', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json',
        },
        body: JSON.stringify(payload)
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Pre-fill thanks message placeholders
                document.getElementById('thanks_name').textContent = name;
                document.getElementById('thanks_email').textContent = email;

                // Set WA direct link
                const waBtn = document.getElementById('wa_direct_btn');
                if (waBtn) {
                    waBtn.href = data.whatsapp_url;
                }

                // Hide form and show thank you screen
                document.getElementById('leadFormArea').style.display = 'none';
                document.getElementById('thankYouArea').style.display = 'flex';

                // Scroll to top
                const dssSec = document.getElementById('dssSection');
                if (dssSec) {
                    dssSec.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            } else {
                showDssAlert('Gagal mengirim data prospek.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showDssAlert('Terjadi kesalahan koneksi server: ' + error.message);
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerText = 'Kirim & Dapatkan Penawaran \u2192';
        });
}

function reset() {
    document.getElementById('industri').value = '';
    document.getElementById('kota').value = '';
    document.getElementById('berat').value = '';
    document.getElementById('tinggi').value = '';
    document.getElementById('step3').style.display = 'none';
    document.getElementById('step4').style.display = 'none';
    goStep(1);

    // Scroll smoothly to top of dssSection
    const dssSec = document.getElementById('dssSection');
    if (dssSec) {
        dssSec.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
}

function showDssAlert(message) {
    const modal = document.getElementById('dssAlertModal');
    const msgEl = document.getElementById('dssAlertMessage');
    const content = document.getElementById('dssAlertContent');
    if (!modal || !msgEl || !content) return;

    msgEl.textContent = message;
    modal.classList.remove('opacity-0', 'pointer-events-none');
    modal.classList.add('opacity-100');
    content.classList.remove('scale-95');
    content.classList.add('scale-100');
}

function closeDssAlert() {
    const modal = document.getElementById('dssAlertModal');
    const content = document.getElementById('dssAlertContent');
    if (!modal || !content) return;

    modal.classList.add('opacity-0', 'pointer-events-none');
    modal.classList.remove('opacity-100');
    content.classList.add('scale-95');
    content.classList.remove('scale-100');
}

// Expose functions globally for HTML onclick handlers
window.goStep = goStep;
window.goStep2 = goStep2;
window.runDSS = runDSS;
window.goToQuoteForm = goToQuoteForm;
window.submitLeadForm = submitLeadForm;
window.reset = reset;
window.closeDssAlert = closeDssAlert;
window.showDssAlert = showDssAlert;

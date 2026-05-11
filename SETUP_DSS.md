# DSS (Decision Support System) Implementation - Setup Guide

Panduan lengkap untuk menyelesaikan setup DSS feature pada Herro Equipment Rental website.

## Prerequisites

- PHP 8.4+ (Laravel 12 requirement)
- MySQL database
- Composer
- Laravel CLI

## Setup Steps

### 1. Verify PHP Version

```bash
php --version
```

**Jika PHP < 8.4:** Update Laragon atau gunakan PHP 8.4+ dari command line.

### 2. Run Database Migrations

Jalankan migration untuk membuat DSS tables:

```bash
php artisan migrate
```

Ini akan membuat:
- `dss_criteria` table (menyimpan form field options)
- `dss_rules` table (menyimpan rule conditions dan equipment recommendations)

### 3. Seed DSS Criteria

Populate DSS criteria dengan semua form field options:

```bash
php artisan db:seed --class=DSSCriteriaSeeder
```

Output yang diharapkan:
```
✓ DSS Criteria seeded successfully!
```

**Data yang di-seed:**
- 7 Lokasi (indoor, outdoor, rough, cold, hazardous, port, height)
- 9 Industri (warehouse, manufacturing, FMCG, mining, dll)
- 8 Jenis Barang (pallet, drum, coil, container, dll)
- 7 Berat Range (<1t hingga >50t)
- 4 Ketinggian (low, medium, high, very high)
- 4 Aisle Width (VNA, narrow, normal, wide)
- 4 Energy Types (lithium, electric, diesel, any)
- 6 Current Units (none, forklift diesel, electric, dll)
- 4 Operator Positions (seated, standing, pedestrian, any)

### 4. Import Equipment from HTML

Import 365+ equipment items dari dss_herro_equipment_rental.html:

```bash
php artisan import:equipment-from-html dss_herro_equipment_rental.html
```

**Output yang diharapkan:**
```
✓ Starting equipment import from: dss_herro_equipment_rental.html

┌────────────┬───────┐
│ Metric     │ Count │
├────────────┼───────┤
│ Created    │ 365   │
│ Updated    │ 0     │
│ Skipped    │ 0     │
│ Total ...  │ 365   │
└────────────┴───────┘

✓ Equipment import completed successfully!
```

**Catatan:** Jika ada duplikasi, sistem akan skip/update equipment yang sudah ada.

### 5. Create Equipment Categories (if needed)

Jika import menghasilkan banyak new categories, review di Filament:
- Login to: `/admin`
- Navigate to: Equipment Category

### 6. Generate DSS Rules from Equipment

Auto-generate initial DSS rules dari specifications equipment yang sudah di-import:

```bash
php artisan db:seed --class=DSSRuleSeeder
```

**Output yang diharapkan:**
```
✓ DSS Rules seeded: 365 created, 0 updated
```

**Apa yang di-generate:**
- Setiap equipment akan mendapat 1+ rules berdasarkan specifications-nya
- Rules automatically map equipment properties (energy, location, capacity) ke user input criteria
- Priority di-calculate berdasarkan specificity (lebih specific = lebih high priority)

### 7. Clear Cache

Cache Laravel config agar DSS data fresh:

```bash
php artisan config:cache
php artisan cache:clear
```

### 8. Test di Admin Panel

1. **Login ke Filament Admin:**
   - URL: `/admin`
   - Username/Password: your admin credentials

2. **Verify DSS Criteria:**
   - Navigate ke: **DSS Management → DSS Criteria (Form Options)**
   - Harusnya terlihat semua form field options yang di-seed
   - Status: All "Active" ✓

3. **Verify DSS Rules:**
   - Navigate ke: **DSS Management → DSS Rules**
   - Harusnya ada ~365 rules (satu per equipment)
   - Tekan "Edit" untuk lihat rule conditions JSON

4. **Verify Equipment:**
   - Navigate ke: **Equipment**
   - Harusnya semua ~365 equipment terimport
   - Cek `specifications` field untuk lihat energy, capacity, locations, dll

### 9. Test DSS Form on Homepage

1. **Clear browser cache** (Ctrl+Shift+Delete or Cmd+Shift+Delete)

2. **Go to homepage:** `/`

3. **Scroll ke section "Temukan Peralatan yang Tepat"** (di bawah Services)

4. **Test DSS Form:**
   
   **Step 1: Lokasi & Industri**
   - Select: Lokasi = "Indoor (gudang, pabrik)"
   - Select: Industri = "Pergudangan & logistik"
   - Click: "Lanjut →"
   
   **Step 2: Muatan & Kapasitas**
   - Click chips: "Palet & karton", "Drum & cairan"
   - Select: Berat = "1 – 3 ton"
   - Select: Ketinggian = "Sedang (3 – 6 meter)"
   - Click: "Lanjut →"
   
   **Step 3: Kondisi Operasional**
   - Select: Aisle = "Normal (3 – 4 meter)"
   - Select: Energi = "Listrik Lithium"
   - Select: Operator = "Duduk (seated)"
   - Unit sekarang: Leave blank (optional)
   - Click: "Cari Rekomendasi →"
   
   **Step 4: Results**
   - Harusnya tampil equipment recommendations
   - Top 3 marked sebagai "Rekomendasi Utama"
   - Others sebagai "equipment lain..."
   - Click "Hubungi kami untuk konsultasi" button

5. **Test Reset:**
   - Click "Mulai ulang pencarian"
   - Form should clear and return to Step 1 ✓

### 10. Manual Rule Refinement (Optional)

Pada Filament admin, Anda bisa:

1. **Edit existing rules:**
   - Go to: DSS Management → DSS Rules
   - Click edit rule
   - Adjust `conditions` JSON
   - Change `priority` atau `relevance_score`
   - Save

2. **Create new rules:**
   - Go to: DSS Management → DSS Rules
   - Click "Create"
   - Select Equipment
   - Define custom conditions JSON
   - Example:
   ```json
   {
     "location": ["indoor"],
     "cargo_type": ["pallet"],
     "energy": "lithium"
   }
   ```

3. **Disable weak rules:**
   - If a rule is not relevant, toggle `is_active` OFF
   - Does NOT delete rule, just hides it

## Troubleshooting

### 1. "File not found: dss_herro_equipment_rental.html"

**Solution:**
- Ensure file exists at: `c:\laragon\www\her_web\dss_herro_equipment_rental.html`
- Use absolute or relative path:
  ```bash
  php artisan import:equipment-from-html "dss_herro_equipment_rental.html"
  php artisan import:equipment-from-html "resources/dss_herro_equipment_rental.html"
  ```

### 2. "No products found in HTML file"

**Possible causes:**
- HTML file doesn't contain `const DB = [...]` JavaScript array
- Array is malformed or incompletely extracted
- Check HTML file is valid

**Solution:**
- Open `dss_herro_equipment_rental.html` in text editor
- Verify it contains `const DB = [ ... ]` with equipment data
- Ensure closing bracket `]` exists

### 3. DSS Form not showing on homepage

**Possible causes:**
- Cache not cleared
- Blade template not reloaded
- DSSCriteria not seeded

**Solution:**
```bash
php artisan cache:clear
php artisan view:clear
php artisan config:cache
```

Then refresh homepage in browser (Ctrl+F5).

### 4. No results returned from DSS /dss/process

**Possible causes:**
- DSSRules not seeded
- Equipment specifications missing
- Rules not matching user input

**Solution:**
1. Verify rules exist:
   ```bash
   php artisan tinker
   >>> App\Models\DSSRule::count()
   => 365 (or similar number)
   ```

2. Check equipment has specifications:
   ```bash
   >>> $eq = App\Models\Equipment::first();
   >>> dd($eq->specifications);
   ```

3. Verify criteria are active:
   ```bash
   >>> App\Models\DSSCriteria::where('is_active', true)->count()
   => ~50 (most criteria should be active)
   ```

### 5. AJAX POST /dss/process returns empty

**Check:**
- Is CSRF token being sent? (check browser console)
- Are form values being sent properly?
- Check Network tab in DevTools for request/response

**To debug:**
1. Open Browser DevTools (F12)
2. Go to Network tab
3. Submit DSS form
4. Click /dss/process request
5. Check Request payload and Response
6. Check for error messages in Response

## File Structure

Semua files yang di-create untuk DSS feature:

```
app/
├── Models/
│   ├── DSSCriteria.php (NEW)
│   └── DSSRule.php (NEW)
├── Services/
│   ├── DSSService.php (NEW)
│   └── EquipmentImporter.php (NEW)
├── Http/Controllers/
│   └── DSSController.php (NEW - modified)
├── Console/Commands/
│   └── ImportEquipmentFromHTML.php (NEW)
├── Filament/Resources/
│   ├── DSSCriteriaResource.php (NEW)
│   ├── DSSCriteriaResource/Pages/ (NEW)
│   │   ├── ListDSSCriteria.php
│   │   ├── CreateDSSCriteria.php
│   │   └── EditDSSCriteria.php
│   ├── DSSRuleResource.php (NEW)
│   └── DSSRuleResource/Pages/ (NEW)
│       ├── ListDSSRules.php
│       ├── CreateDSSRule.php
│       └── EditDSSRule.php

database/
├── migrations/
│   └── 2026_04_14_000001_create_dss_tables.php (NEW)
└── seeders/
    ├── DSSCriteriaSeeder.php (NEW)
    └── DSSRuleSeeder.php (NEW)

resources/views/
├── frontend/pages/home/
│   ├── index.blade.php (MODIFIED - added DSS section include)
│   └── sections/
│       └── dss.blade.php (NEW - DSS form view)

routes/
└── web.php (MODIFIED - added DSS routes)

Config/
└── app.php (NO CHANGES - uses existing)
```

## API Reference

### POST /dss/process

**Request:**
```json
{
  "lokasi": "indoor",
  "industri": "warehouse",
  "muatan": ["pallet", "drum"],
  "berat": "1to3t",
  "tinggi": "medium",
  "aisle": "normal",
  "energi": "lithium",
  "operator": "seated",
  "unitSekarang": "none"
}
```

**Response (Success):**
```json
{
  "success": true,
  "results": {
    "total_found": 25,
    "top_recommendations": [
      {
        "id": 1,
        "name": "XE Series 1.5~4.0t Electric Lithium Counterbalance Forklift",
        "type": "E-Trucks Lithium",
        "category": "Equipment",
        "capacity": { "min": 1500, "max": 4000 },
        "energy": "lithium",
        "locations": ["indoor", "outdoor"],
        "operator_type": "seated",
        "daily_rate": null,
        "match_score": 85,
        "match_summary": { ... }
      },
      ...
    ],
    "other_recommendations": [ ... ]
  }
}
```

**Response (Error):**
```json
{
  "success": false,
  "errors": ["Silakan isi setidaknya satu kriteria"]
}
```

### GET /dss/criteria/{field_type}

**Response:**
```json
{
  "field_type": "location",
  "criteria": [
    { "code": "indoor", "name": "Indoor (gudang, pabrik)", "sort_order": 1 },
    { "code": "outdoor", "name": "Outdoor (lapangan terbuka)", "sort_order": 2 },
    ...
  ]
}
```

## Next Steps

1. ✅ Complete all setup steps above
2. ✅ Test DSS form on homepage
3. ✅ Review/refine rules in Filament admin
4. 📈 Monitor which equipment is recommended most (future analytics)
5. 🎯 Adjust rule priorities based on business needs
6. 📱 Consider mobile responsiveness improvements if needed

## Support

Jika ada issues:
1. Check Troubleshooting section di atas
2. Review Laravel logs: `storage/logs/laravel.log`
3. Check browser console (F12 → Console)
4. Verify database: `php artisan tinker`

---

**Implementation Date:** 2026-04-14  
**Framework:** Laravel 12.52.0  
**Language:** Indonesian Only  
**Database:** MySQL (her_db)

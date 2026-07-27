<?php

namespace App\Http\Controllers;

use App\Models\DSSCriteria;
use App\Services\DSSService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DSSController extends Controller
{
    protected DSSService $dssService;

    public function __construct(DSSService $dssService)
    {
        $this->dssService = $dssService;
    }

    /**
     * Process DSS form submission
     */
    public function processForm(Request $request): JsonResponse
    {
        // Validate inputs
        $validated = $request->validate([
            'industri' => 'required|string',
            'kota' => 'required|string',
            'berat' => 'required|numeric|min:1',
            'tinggi' => 'required|numeric|min:0',
        ]);

        // Map form input to DSS field names
        $userInput = [
            'industry' => $validated['industri'] ?? null,
            'city' => $validated['kota'] ?? null,
            'weight' => $validated['berat'] ?? null,
            'height' => $validated['tinggi'] ?? null,
        ];

        // Filter out null and empty values
        $userInput = array_filter($userInput, function ($value) {
            if ($value === null || $value === '') {
                return false;
            }

            return true;
        });

        // Get recommendations dynamically matching product specs
        $results = $this->dssService->getFormattedResults($userInput);

        return response()->json($results);
    }

    /**
     * Get criteria options by field type (for dynamic form loading)
     */
    public function getCriteria(string $fieldType): JsonResponse
    {
        $criteria = DSSCriteria::getByFieldType($fieldType);

        return response()->json([
            'field_type' => $fieldType,
            'criteria' => $criteria->map(fn ($c) => [
                'code' => $c->code,
                'name' => $c->name,
                'sort_order' => $c->sort_order,
            ])->values(),
        ]);
    }

    /**
     * Submit lead data
     */
    public function submitLead(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'whatsapp_number' => 'required|string|max:50',
            'industri' => 'required|string',
            'kota' => 'required|string',
            'berat' => 'required|numeric|min:1',
            'tinggi' => 'required|numeric|min:0',
            'recommended_products' => 'required|array',
        ]);

        $lead = \App\Models\Lead::create([
            'name' => $validated['name'],
            'company_name' => $validated['company_name'] ?? null,
            'email' => $validated['email'],
            'whatsapp_number' => $validated['whatsapp_number'],
            'industry' => $validated['industri'],
            'location' => $validated['kota'],
            'requested_load_capacity' => (int) $validated['berat'],
            'requested_lift_height' => (float) $validated['tinggi'],
            'recommended_products' => $validated['recommended_products'],
        ]);

        // Construct WA Link
        $waNumber = preg_replace('/[^0-9]/', '', setting('whatsapp_number', '6281234567890'));

        $productsText = '';
        foreach ($validated['recommended_products'] as $idx => $prod) {
            $num = $idx + 1;
            $productsText .= "{$num}. {$prod['name']}\n";
            if (! empty($prod['slug'])) {
                $productsText .= '   Link: '.url('/produk/'.$prod['slug'])."\n";
            }
        }

        $waMessage = "Halo, saya tertarik dengan penawaran forklift dari website. Berikut data kebutuhan saya:\n\n"
            ."*PROFIL PELANGGAN*\n"
            ."- Nama: {$lead->name}\n"
            .'- Perusahaan: '.($lead->company_name ?? '-')."\n"
            ."- Email: {$lead->email}\n"
            ."- No. WhatsApp: {$lead->whatsapp_number}\n"
            ."- Lokasi: {$lead->location}\n"
            ."- Industri: {$lead->industry}\n\n"
            ."*SPESIFIKASI KEBUTUHAN (DSS)*\n"
            ."- Kapasitas Beban: {$lead->requested_load_capacity} kg\n"
            ."- Tinggi Angkat: {$lead->requested_lift_height} meter\n\n"
            ."*UNIT REKOMENDASI UTAMA*\n"
            ."{$productsText}\n"
            .'Mohon segera hubungi saya untuk proses penawaran harga. Terima kasih.';

        $whatsappUrl = "https://wa.me/{$waNumber}?text=".rawurlencode($waMessage);

        return response()->json([
            'success' => true,
            'message' => 'Data prospek berhasil disimpan.',
            'whatsapp_url' => $whatsappUrl,
        ]);
    }
}

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
        // Validate simplified inputs
        $validated = $request->validate([
            'industri' => 'nullable|string',
            'product_type' => 'nullable|string',
            'energi' => 'nullable|string',
            'berat' => 'nullable|string',
            'tinggi' => 'nullable|string',
        ]);

        // Map form input to DSS field names
        $userInput = [
            'industry' => $validated['industri'] ?? null,
            'product_type' => $validated['product_type'] ?? null,
            'energy' => $validated['energi'] ?? null,
            'weight' => $validated['berat'] ?? null,
            'height' => $validated['tinggi'] ?? null,
        ];

        // Remove null and empty values
        $userInput = array_filter($userInput, function ($value) {
            if ($value === null || $value === '') return false;
            return true;
        });

        // Get recommendations (1 Utama & 1 Alternatif)
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
}

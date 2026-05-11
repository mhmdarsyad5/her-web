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
        // Validate input structure
        $validated = $request->validate([
            'lokasi' => 'nullable|string',
            'industri' => 'nullable|string',
            'muatan' => 'nullable|array',
            'muatan.*' => 'string',
            'berat' => 'nullable|string',
            'tinggi' => 'nullable|string',
            'aisle' => 'nullable|string',
            'energi' => 'nullable|string',
            'operator' => 'nullable|string',
            'unitSekarang' => 'nullable|string',
        ]);

        // Map form input to DSS field names
        $userInput = [
            'location' => $validated['lokasi'] ?? null,
            'industry' => $validated['industri'] ?? null,
            'cargo_type' => $validated['muatan'] ?? [],
            'weight' => $validated['berat'] ?? null,
            'height' => $validated['tinggi'] ?? null,
            'aisle' => $validated['aisle'] ?? null,
            'energy' => $validated['energi'] ?? null,
            'operator' => $validated['operator'] ?? null,
            'unit' => $validated['unitSekarang'] ?? null,
        ];

        // Remove null and empty values
        $userInput = array_filter($userInput, function ($value) {
            if ($value === null || $value === '') return false;
            if (is_array($value) && count($value) === 0) return false;  // Remove empty arrays
            return true;
        });

        // Get recommendations
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

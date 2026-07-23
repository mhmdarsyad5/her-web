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
}

<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Collection;

class DSSService
{
    protected $userInput = [];

    /**
     * Parse specification range strings (e.g. "1.5 - 3.8 ton" or "3.0 - 6.0 m")
     * to standard units (kg for weight, mm for height).
     */
    public static function parseRange(?string $string, string $defaultUnit): array
    {
        if (empty($string)) {
            return [0, 0];
        }

        $string = strtolower(trim($string));

        // Determine units
        $isTon = str_contains($string, 'ton') || str_contains($string, 't');
        $isMeter = str_contains($string, 'm') && ! str_contains($string, 'mm');

        // Extract all numbers (integers or decimals)
        preg_match_all('/[0-9]+(?:\.[0-9]+)?/', $string, $matches);
        $numbers = array_map('floatval', $matches[0]);

        if (empty($numbers)) {
            return [0, 0];
        }

        $min = $numbers[0];
        $max = isset($numbers[1]) ? $numbers[1] : $numbers[0];

        // Normalize units
        if ($defaultUnit === 'kg') {
            if ($isTon || $min < 100) {
                $min *= 1000;
                $max *= 1000;
            }
        } elseif ($defaultUnit === 'mm') {
            if ($isMeter || $min < 50) {
                $min *= 1000;
                $max *= 1000;
            }
        }

        // If it is a single value, allow range from 0 to the specified value
        if ($min === $max) {
            $min = 0;
        }

        return [$min, $max];
    }

    /**
     * Filter products dynamically by user specification inputs and industry pivot relation.
     */
    public function filterByUserInputs(array $userInput): Collection
    {
        $this->userInput = $userInput;

        $weightKg = isset($userInput['weight']) ? floatval($userInput['weight']) : null;
        $heightM = isset($userInput['height']) ? floatval($userInput['height']) : null;
        $heightMm = $heightM !== null ? $heightM * 1000 : null;
        $userIndustry = isset($userInput['industry']) ? $userInput['industry'] : null;

        // Query active products
        $query = Product::where('is_active', true);

        // Apply industry relation filter if specified and not "others"
        if ($userIndustry !== null && $userIndustry !== 'others') {
            $query->whereHas('dssCriteria', function ($q) use ($userIndustry) {
                $q->where('code', $userIndustry);
            });
        }

        $products = $query->get();

        return $products->filter(function ($product) use ($weightKg, $heightMm) {
            // 1. Capacity Range Match
            if ($weightKg !== null) {
                // Use new numeric columns if available, otherwise fallback to parsing
                if ($product->max_capacity_kg !== null) {
                    $minCap = $product->min_capacity_kg ?? 0;
                    $maxCap = $product->max_capacity_kg;
                } else {
                    [$minCap, $maxCap] = self::parseRange($product->load_capacity, 'kg');
                }

                if ($minCap > 0 && $maxCap > 0) {
                    if ($weightKg < $minCap || $weightKg > $maxCap) {
                        return false;
                    }
                } elseif ($maxCap > 0) {
                    if ($weightKg > $maxCap) {
                        return false;
                    }
                }
            }

            // 2. Height Match (Product must be able to reach the requested height)
            if ($heightMm !== null) {
                // Use new numeric column if available, otherwise fallback to parsing
                if ($product->max_lift_height_mm !== null) {
                    $maxHeight = $product->max_lift_height_mm;
                } else {
                    [, $maxHeight] = self::parseRange($product->lift_height, 'mm');
                }

                // If user requests a positive lifting height, but product cannot lift (maxHeight is 0), exclude it!
                if ($heightMm > 0 && $maxHeight <= 0) {
                    return false;
                }

                if ($maxHeight > 0) {
                    if ($heightMm > $maxHeight) {
                        return false;
                    }
                }
            }

            return true;
        })->sortBy('sort_order')->values();
    }

    /**
     * Validate user input fields.
     */
    public function validateInput(?array $userInput = null): array
    {
        $errors = [];
        $input = $userInput ?? $this->userInput;

        if (empty($input['weight'])) {
            $errors[] = 'Silakan isi kapasitas beban yang dibutuhkan';
        }
        if (empty($input['height'])) {
            $errors[] = 'Silakan isi tinggi angkat yang dibutuhkan';
        }

        return ['valid' => empty($errors), 'errors' => $errors];
    }

    /**
     * Get Formatted Results for API response
     */
    public function getFormattedResults(array $userInput): array
    {
        $this->userInput = $userInput;
        $validation = $this->validateInput($userInput);

        if (! $validation['valid']) {
            return ['success' => false, 'errors' => $validation['errors']];
        }

        $matchingProducts = $this->filterByUserInputs($userInput);

        return [
            'success' => true,
            'results' => [
                'products' => $matchingProducts->map(fn ($p) => $this->formatProductResponse($p))->toArray(),
                'total_found' => $matchingProducts->count(),
            ],
        ];
    }

    /**
     * Format Product model details for API response
     */
    protected function formatProductResponse(Product $product): array
    {
        $productTypeName = $product->typeRelation?->name ?? '-';

        return [
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'image' => $product->thumbnail ? asset('storage/'.$product->thumbnail) : null,
            'type' => $product->energy_type ?? '-',
            'product_type' => $product->product_type,
            'product_type_name' => $productTypeName,
            'capacity' => $product->load_capacity ?? '-',
            'lift_height' => $product->lift_height ?? '-',
            'operator_type' => $product->operator_type ?? '-',
            'tagline' => $product->tagline,
            'description' => str($product->description)->stripTags()->limit(120)->toString(),
        ];
    }
}

<?php

namespace App\Services;

use App\Models\DSSRule;
use Illuminate\Support\Collection;

class DSSService
{
    protected $userInput = [];

    /**
     * Get recommendations using Standalone DSSRule (rule-centric)
     */
    public function filterByUserInputs(array $userInput): Collection
    {
        $this->userInput = $userInput;

        // Eager load product relation
        $rules = DSSRule::where('is_active', true)->with('product')->get();

        // Tier 1: Strict Match ALL input fields
        $tier1 = $rules->filter(fn ($rule) => $rule->matchesInput($userInput));
        if ($tier1->isNotEmpty()) {
            return $tier1->sortByDesc('priority')->values();
        }

        // Tier 2: Core fields Match (product_type, energy, weight)
        $coreFields = ['product_type', 'energy', 'weight'];
        $coreInput = array_intersect_key($userInput, array_flip($coreFields));

        if (! empty($coreInput)) {
            $tier2 = $rules->filter(fn ($rule) => $this->matchesSubset($rule, $coreInput));
            if ($tier2->isNotEmpty()) {
                return $tier2->sortByDesc('priority')->values();
            }
        }

        // Tier 3: Crucial fields Match (product_type, weight)
        $crucialFields = ['product_type', 'weight'];
        $crucialInput = array_intersect_key($userInput, array_flip($crucialFields));

        if (! empty($crucialInput)) {
            $tier3 = $rules->filter(fn ($rule) => $this->matchesSubset($rule, $crucialInput));
            if ($tier3->isNotEmpty()) {
                return $tier3->sortByDesc('priority')->values();
            }
        }

        return collect();
    }

    protected function matchesSubset(DSSRule $rule, array $subsetInput): bool
    {
        if (empty($subsetInput)) {
            return false;
        }

        foreach ($subsetInput as $field => $userValue) {
            if (! $rule->matchesSingleField($field, $userValue)) {
                return false;
            }
        }

        return true;
    }

    public function validateInput(?array $userInput = null): array
    {
        $errors = [];
        $filledFields = array_filter($userInput ?? $this->userInput, function ($value) {
            if ($value === null || $value === '') {
                return false;
            }
            if (is_array($value) && count($value) === 0) {
                return false;
            }

            return true;
        });

        if (empty($filledFields)) {
            $errors[] = 'Silakan isi setidaknya satu kriteria pencarian';
        }

        return ['valid' => empty($errors), 'errors' => $errors];
    }

    /**
     * Get Formatted Results: 1 Utama & 1 Alternatif
     */
    public function getFormattedResults(array $userInput): array
    {
        $this->userInput = $userInput;
        $validation = $this->validateInput($userInput);

        if (! $validation['valid']) {
            return ['success' => false, 'errors' => $validation['errors']];
        }

        $allRules = $this->filterByUserInputs($userInput);
        $utama = $allRules->first();
        $alternatif = $allRules->slice(1)->first();

        return [
            'success' => true,
            'results' => [
                'utama' => $utama ? $this->formatRuleResponse($utama) : null,
                'alternatif' => $alternatif ? $this->formatRuleResponse($alternatif) : null,
                'total_found' => $allRules->count(),
            ],
        ];
    }

    /**
     * Format Standalone Rule for API response
     */
    protected function formatRuleResponse(DSSRule $rule): array
    {
        $conditions = $rule->conditions ?? [];
        $displaySpecs = $rule->display_specifications ?? [];

        $product = $rule->product;

        return [
            'id' => $rule->id,
            'name' => $product ? $product->name : $rule->product_name,
            'slug' => $product ? $product->slug : null,
            'image' => $product ? asset('storage/'.$product->thumbnail) : null,
            'type' => $rule->model ?? ($rule->category_name ?? 'Equipment'),
            'category' => $rule->category_name,
            'capacity' => $product && $product->load_capacity ? $product->load_capacity : ($displaySpecs['capacity'] ?? '0kg'),
            'mast_height' => $product && $product->lift_height ? $product->lift_height : ($displaySpecs['mast_height'] ?? '-'),
            'battery' => $product && $product->energy_type ? $product->energy_type : ($displaySpecs['battery'] ?? ($displaySpecs['engine'] ?? '-')),
            'energy' => $conditions['energy'] ?? 'electric',
            'match_score' => $rule->getMatchScore($this->userInput),
        ];
    }
}

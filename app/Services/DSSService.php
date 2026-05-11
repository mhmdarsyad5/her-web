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

        $rules = DSSRule::where('is_active', true)->get();

        // Tier 1: Strict Match ALL
        $tier1 = $rules->filter(fn($rule) => $rule->matchesInput($userInput));
        if ($tier1->isNotEmpty()) {
            return $tier1->sortByDesc('priority')->values();
        }

        // Tier 2: Core + Important Match
        $coreFields = ['location', 'weight', 'cargo_type', 'height', 'aisle'];
        $coreInput = array_intersect_key($userInput, array_flip($coreFields));
        
        if (!empty($coreInput)) {
            $tier2 = $rules->filter(fn($rule) => $this->matchesSubset($rule, $coreInput));
            if ($tier2->isNotEmpty()) {
                return $tier2->sortByDesc('priority')->values();
            }
        }

        // Tier 3: Crucial Match Only
        $crucialFields = ['location', 'weight'];
        $crucialInput = array_intersect_key($userInput, array_flip($crucialFields));

        if (!empty($crucialInput)) {
            $tier3 = $rules->filter(fn($rule) => $this->matchesSubset($rule, $crucialInput));
            if ($tier3->isNotEmpty()) {
                return $tier3->sortByDesc('priority')->values();
            }
        }

        return collect();
    }

    protected function matchesSubset(DSSRule $rule, array $subsetInput): bool
    {
        if (empty($subsetInput)) return false;

        foreach ($subsetInput as $field => $userValue) {
            if (!$rule->matchesSingleField($field, $userValue)) {
                return false;
            }
        }

        return true;
    }

    public function getTopRecommendations(array $userInput, int $limit = 3): Collection
    {
        return $this->filterByUserInputs($userInput)->take($limit);
    }

    public function validateInput(array $userInput = null): array
    {
        $errors = [];
        $filledFields = array_filter($userInput ?? $this->userInput, function ($value) {
            if ($value === null || $value === '') return false;
            if (is_array($value) && count($value) === 0) return false;
            return true;
        });

        if (empty($filledFields)) {
            $errors[] = 'Silakan isi setidaknya satu kriteria';
        }

        return ['valid' => empty($errors), 'errors' => $errors];
    }

    public function getFormattedResults(array $userInput, int $topLimit = 3): array
    {
        $this->userInput = $userInput;
        $validation = $this->validateInput($userInput);

        if (!$validation['valid']) {
            return ['success' => false, 'errors' => $validation['errors']];
        }

        $allRules = $this->filterByUserInputs($userInput);
        $topRecommendations = $allRules->take($topLimit);
        $otherRecommendations = $allRules->slice($topLimit);

        return [
            'success' => true,
            'results' => [
                'total_found' => $allRules->count(),
                'top_recommendations' => $topRecommendations->map(fn ($rule) => $this->formatRuleResponse($rule))->values(),
                'other_recommendations' => $otherRecommendations->map(fn ($rule) => $this->formatRuleResponse($rule))->values(),
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

        return [
            'id' => $rule->id,
            'name' => $rule->product_name,
            'type' => $rule->model ?? ($rule->category_name ?? 'Equipment'),
            'category' => $rule->category_name,
            'capacity' => [
                'display' => $displaySpecs['capacity'] ?? '0kg',
                'min' => 0,
                'max' => $this->extractNumberFromCode($conditions['weight'][0] ?? ''),
            ],
            'energy' => $conditions['energy'] ?? 'electric',
            'locations' => $conditions['location'] ?? [],
            'operator_type' => $conditions['operator'] ?? 'seated',
            'match_score' => $rule->getMatchScore($this->userInput),
            'spec_details' => $displaySpecs,
        ];
    }

    protected function extractNumberFromCode(string $code): int
    {
        preg_match('/\d+/', $code, $matches);
        return isset($matches[0]) ? (int) $matches[0] * 1000 : 0;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DSSRule extends Model
{
    protected $table = 'dss_rules';

    protected $fillable = [
        'product_id',
        'product_name',
        'category_name',
        'brand',
        'model',
        'name',
        'conditions',
        'display_specifications',
        'priority',
        'is_active',
    ];

    protected $casts = [
        'conditions' => 'array',
        'display_specifications' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Virtual attribute for editing conditions as JSON string
     */
    public function getConditionsRawAttribute(): string
    {
        return json_encode($this->conditions ?? [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function setConditionsRawAttribute(string $value): void
    {
        $decoded = json_decode($value, true);
        $this->attributes['conditions'] = json_encode($decoded ?? []);
    }

    /**
     * Display attribute for conditions in table (human readable)
     */
    public function getConditionsDisplayAttribute(): string
    {
        $conditions = $this->conditions ?? [];
        $labels = [];

        $fieldLabels = [
            'location' => 'Lokasi',
            'industry' => 'Industri',
            'product_type' => 'Jenis Unit',
            'cargo_type' => 'Barang',
            'weight' => 'Berat',
            'height' => 'Tinggi',
            'aisle' => 'Aisle',
            'energy' => 'Energi',
            'unit' => 'Unit',
            'operator' => 'Operator',
        ];

        foreach ($conditions as $key => $value) {
            $label = $fieldLabels[$key] ?? ucfirst($key);
            if (is_array($value)) {
                $labels[] = "$label: " . implode(', ', $value);
            } else {
                $labels[] = "$label: $value";
            }
        }

        return implode(' | ', $labels) ?: '-';
    }

    /**
     * Get the product that this rule recommends
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the equipment that this rule recommends
     */
    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }

    /**
     * Check if this rule matches the user input strictly
     */
    public function matchesInput(array $userInput): bool
    {
        if (empty($this->conditions)) return false;

        foreach ($this->conditions as $field => $expectedValue) {
            if (!isset($userInput[$field])) continue;

            if (!$this->matchesSingleField($field, $userInput[$field])) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check if a single field matches strictly (Yes/No)
     */
    public function matchesSingleField(string $field, $userValue): bool
    {
        $expectedValue = $this->conditions[$field] ?? null;

        if ($expectedValue === null) return true; // Rule doesn't care about this field
        if ($userValue === null || $userValue === '') return true; // User didn't provide input

        // Handle 'any' as a wildmatch
        if ($expectedValue === 'any' || $userValue === 'any') return true;

        // Handle array values for multi-select (user selections vs rule requirements)
        if (is_array($userValue)) {
            if (is_array($expectedValue)) {
                return count(array_intersect($userValue, $expectedValue)) > 0;
            }
            return in_array($expectedValue, $userValue);
        }

        if (is_array($expectedValue)) {
            return in_array($userValue, $expectedValue);
        }

        return $expectedValue === $userValue;
    }

    /**
     * Get match score for this rule against user input (0-100)
     */
    public function getMatchScore(array $userInput): int
    {
        if (empty($this->conditions)) return 0;

        $totalConditions = count($this->conditions);
        $matchedCount = 0;

        foreach ($this->conditions as $field => $expectedValue) {
            if (!isset($userInput[$field])) continue;

            if ($this->matchesSingleField($field, $userInput[$field])) {
                $matchedCount++;
            }
        }

        return (int) round(($matchedCount / $totalConditions) * 100);
    }

    /**
     * Get how many conditions matched
     */
    public function matchedConditionCount(array $userInput): int
    {
        if (empty($this->conditions)) {
            return 0;
        }

        $matchedCount = 0;

        foreach ($this->conditions as $field => $expectedValue) {
            if (!isset($userInput[$field])) {
                continue;
            }

            $userValue = $userInput[$field];

            if (is_array($userValue)) {
                if (is_array($expectedValue)) {
                    if (count(array_intersect($userValue, $expectedValue)) > 0) {
                        $matchedCount++;
                    }
                } else {
                    if (in_array($expectedValue, $userValue)) {
                        $matchedCount++;
                    }
                }
            } else {
                if (is_array($expectedValue)) {
                    if (in_array($userValue, $expectedValue)) {
                        $matchedCount++;
                    }
                } else {
                    if ($expectedValue === $userValue || $expectedValue === 'any' || $userValue === 'any') {
                        $matchedCount++;
                    }
                }
            }
        }

        return $matchedCount;
    }
}

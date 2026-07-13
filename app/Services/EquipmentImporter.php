<?php

namespace App\Services;

use App\Models\Equipment;
use App\Models\EquipmentCategory;
use Illuminate\Support\Facades\Log;

class EquipmentImporter
{
    protected $created = 0;

    protected $updated = 0;

    protected $skipped = 0;

    protected $errors = [];

    /**
     * Import equipment from HTML file containing JavaScript array
     */
    public function importFromHTML(string $filePath): array
    {
        if (! file_exists($filePath)) {
            throw new \Exception("File not found: {$filePath}");
        }

        $html = file_get_contents($filePath);

        // Extract the JavaScript DB array from <script> tag
        $products = $this->extractProductsFromHTML($html);

        if (empty($products)) {
            throw new \Exception('No products found in HTML file.');
        }

        // Upsert equipment records
        foreach ($products as $product) {
            try {
                $this->upsertEquipment($product);
            } catch (\Exception $e) {
                $this->errors[] = "Error importing {$product['name']}: ".$e->getMessage();
                $this->skipped++;
            }
        }

        return $this->getReport();
    }

    /**
     * Extract products from HTML <script> section
     */
    protected function extractProductsFromHTML(string $html): array
    {
        // Find the start of const DB = [
        $startPattern = '/const\s+DB\s*=\s*\[/';
        $startMatch = [];

        if (! preg_match($startPattern, $html, $startMatch, PREG_OFFSET_CAPTURE)) {
            return [];
        }

        $startPos = $startMatch[0][1] + strlen($startMatch[0][0]);

        // Find matching closing bracket
        $closeBracketPos = $this->findMatchingBracket($html, $startPos);
        if ($closeBracketPos === false) {
            return [];
        }

        // Extract the array content
        $arrayContent = substr($html, $startPos, $closeBracketPos - $startPos);

        // Parse JSON-like array content
        // Replace single quotes with double quotes for JSON compatibility
        $jsonContent = $this->convertJSArrayToJSON($arrayContent);

        try {
            $decoded = json_decode($jsonContent, true);

            return is_array($decoded) ? $decoded : [];
        } catch (\Exception $e) {
            Log::error('Failed to parse products from HTML: '.$e->getMessage());

            return [];
        }
    }

    /**
     * Find the position of matching closing bracket
     */
    protected function findMatchingBracket(string $html, int $startPos): int|bool
    {
        $depth = 1;
        $inString = false;
        $stringChar = null;

        for ($i = $startPos; $i < strlen($html); $i++) {
            $char = $html[$i];
            $prevChar = $i > 0 ? $html[$i - 1] : '';

            // Handle string boundaries
            if (($char === '"' || $char === "'" || $char === '`') && $prevChar !== '\\') {
                if (! $inString) {
                    $inString = true;
                    $stringChar = $char;
                } elseif ($char === $stringChar) {
                    $inString = false;
                }
            }

            // Count brackets outside strings
            if (! $inString) {
                if ($char === '[' || $char === '{') {
                    $depth++;
                } elseif ($char === ']' || $char === '}') {
                    $depth--;
                    if ($depth === 0) {
                        return $i;
                    }
                }
            }
        }

        return false;
    }

    /**
     * Convert JavaScript array syntax to JSON
     */
    protected function convertJSArrayToJSON(string $jsContent): string
    {
        // Remove trailing commas before ] or }
        $json = preg_replace('/,(\s*[}\]])/', '$1', $jsContent);

        // Replace object properties pattern: property:value with "property":value
        // Handle quoted properties
        $json = preg_replace_callback(
            '/([{,]\s*)([a-zA-Z_][a-zA-Z0-9_]*)\s*:/',
            function ($matches) {
                return $matches[1].'"'.$matches[2].'":';
            },
            $json
        );

        // Replace single quotes with double quotes (but be careful about escaped quotes)
        $json = str_replace("'", '"', $json);

        // Remove any trailing commas
        $json = preg_replace('/,(\s*[\]}])/', '$1', $json);

        return '['.$json.']';
    }

    /**
     * Upsert an equipment record
     */
    protected function upsertEquipment(array $product): void
    {
        // Extract data
        $name = $product['name'] ?? null;
        $type = $product['type'] ?? 'Other';
        $capacity = $product['cap'] ?? [0, 0];
        $locations = $product['loc'] ?? [];
        $operator = $product['op'] ?? 'seated';
        $energy = $product['energy'] ?? 'electric';

        if (! $name) {
            $this->skipped++;

            return;
        }

        // Find or create category based on type
        $category = EquipmentCategory::firstOrCreate(
            ['slug' => \Illuminate\Support\Str::slug($type)],
            [
                'name' => $type,
                'is_active' => true,
                'sort_order' => 0,
            ]
        );

        // Prepare specifications
        $specifications = [
            'energy' => $energy,
            'capacity_min' => $capacity[0] ?? 0,
            'capacity_max' => $capacity[1] ?? 0,
            'locations' => is_array($locations) ? $locations : [$locations],
            'operator_type' => $operator,
            'type' => $type,
        ];

        // Upsert equipment
        $equipment = Equipment::updateOrCreate(
            ['name' => $name],
            [
                'name' => $name,
                'category_id' => $category->id,
                'specifications' => $specifications,
                'status' => 'available',
                'condition' => 'excellent',
                'sort_order' => 0,
            ]
        );

        // Track result
        if ($equipment->wasRecentlyCreated) {
            $this->created++;
        } else {
            $this->updated++;
        }
    }

    /**
     * Get import report
     */
    public function getReport(): array
    {
        return [
            'created' => $this->created,
            'updated' => $this->updated,
            'skipped' => $this->skipped,
            'total' => $this->created + $this->updated + $this->skipped,
            'errors' => $this->errors,
        ];
    }
}

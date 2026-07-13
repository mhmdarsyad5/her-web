<?php

namespace App\Console\Commands;

use App\Models\DSSRule;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ImportDSSFromExcel extends Command
{
    protected $signature = 'import:dss-from-excel {jsonPath=dss_data.json}';
    protected $description = 'Import standalone DSS Rules from converted Excel JSON';

    public function handle()
    {
        $jsonPath = base_path($this->argument('jsonPath'));

        if (!file_exists($jsonPath)) {
            $this->error("JSON file not found: {$jsonPath}");
            return 1;
        }

        $items = json_decode(file_get_contents($jsonPath), true);
        if (!$items) {
            $this->error("Failed to decode JSON");
            return 1;
        }

        $this->info("Importing " . count($items) . " standalone rules...");

        $created = 0;
        $updated = 0;

        foreach ($items as $item) {
            $productName = $item['Product Name'];
            
            // Map Excel data to DSS conditions
            $conditions = $this->mapItemToConditions($item);
            
            // Collect display specs
            $displaySpecs = [
                'capacity' => $item['Load Capacity'] ?? '-',
                'lift_height' => $item['Lift Height'] ?? '-',
                'radius' => $item['Turning Radius'] ?? '-',
                'speed' => $item['Travel Speed'] ?? '-',
                'battery' => $item['Battery Voltage STD'] ?? '-',
            ];

            // Create/Update Standalone DSS Rule
            $rule = DSSRule::updateOrCreate(
                ['product_name' => $productName],
                [
                    'product_name' => $productName,
                    'category_name' => $item['Category'] ?? 'Equipment',
                    'brand' => 'HANGCHA',
                    'model' => $item['Type'] ?? '',
                    'name' => "Rule for " . $productName,
                    'conditions' => $conditions,
                    'display_specifications' => $displaySpecs,
                    'priority' => $this->calculatePriority($conditions),
                    'is_active' => true,
                ]
            );

            if ($rule->wasRecentlyCreated) {
                $created++;
            } else {
                $updated++;
            }
        }

        $this->info("✓ Done! Created: {$created}, Updated: {$updated}");
        return 0;
    }

    protected function mapItemToConditions(array $item): array
    {
        $conditions = [];

        // Capacity -> Weight
        if (!empty($item['Load Capacity'])) {
            $capacity = $this->parseMaxNumber($item['Load Capacity']);
            $conditions['weight'] = [$this->mapWeight($capacity)];
        }

        // Height -> Height
        if (!empty($item['Lift Height'])) {
            $heightMm = $this->parseMaxNumber($item['Lift Height']);
            $conditions['height'] = [$this->mapHeight($heightMm)];
        }

        // Turning Radius -> Aisle
        if (!empty($item['Turning Radius'])) {
            $radiusMm = $this->parseMaxNumber($item['Turning Radius']);
            $conditions['aisle'] = [$this->mapAisle($radiusMm)];
        }

        // Operator
        if (!empty($item['Operator Type'])) {
            $opType = strtolower($item['Operator Type']);
            if (str_contains($opType, 'seated')) $conditions['operator'] = 'seated';
            elseif (str_contains($opType, 'stand') || str_contains($opType, 'pedestrian')) $conditions['operator'] = 'standing';
        }

        // Energy (from Category or Type)
        $fullText = strtolower(($item['Category'] ?? '') . ' ' . ($item['Type'] ?? ''));
        if (str_contains($fullText, 'lithium')) $conditions['energy'] = 'lithium';
        elseif (str_contains($fullText, 'electric') || str_contains($fullText, 'lead acid')) $conditions['energy'] = 'electric';
        elseif (str_contains($fullText, 'diesel') || str_contains($fullText, 'ic')) $conditions['energy'] = 'diesel';

        // Locations (Heuristic)
        if (isset($conditions['energy'])) {
            if ($conditions['energy'] === 'diesel') {
                $conditions['location'] = ['outdoor', 'rough'];
            } else {
                $conditions['location'] = ['indoor'];
                if (str_contains($fullText, 'rough terrain')) $conditions['location'][] = 'rough';
                if ($conditions['energy'] === 'lithium') $conditions['location'][] = 'outdoor';
            }
        }

        // Specific mappings based on category strings
        if (str_contains($fullText, 'vna') || str_contains($fullText, 'narrow aisle')) {
            $conditions['aisle'] = ['vna'];
        }
        
        if (str_contains($fullText, 'pallet')) {
            $conditions['cargo_type'] = ['pallet'];
        } elseif (str_contains($fullText, 'container')) {
            $conditions['cargo_type'] = ['container'];
            $conditions['location'] = ['port'];
        } elseif (str_contains($fullText, 'aerial') || str_contains($fullText, 'boom') || str_contains($fullText, 'scissor')) {
            $conditions['cargo_type'] = ['person'];
            $conditions['location'] = ['height'];
        }

        return array_filter($conditions);
    }

    protected function parseMaxNumber($string): int
    {
        $string = str_replace('.', '', $string);
        preg_match_all('/\d+/', $string, $matches);
        if (empty($matches[0])) return 0;
        return (int) max($matches[0]);
    }

    protected function mapWeight(int $kg): string
    {
        if ($kg < 1000) return 'lt1t';
        if ($kg <= 3000) return '1to3t';
        if ($kg <= 5000) return '3to5t';
        if ($kg <= 10000) return '5to10t';
        if ($kg <= 20000) return '10to20t';
        if ($kg <= 50000) return '20to50t';
        return 'gt50t';
    }

    protected function mapHeight(int $mm): string
    {
        if ($mm <= 3000) return 'low';
        if ($mm <= 6000) return 'medium';
        if ($mm <= 12000) return 'high';
        return 'vhigh';
    }

    protected function mapAisle(int $radiusMm): string
    {
        $aisleMm = $radiusMm + 1000; 
        if ($aisleMm < 2000) return 'vna';
        if ($aisleMm <= 3000) return 'narrow';
        if ($aisleMm <= 4000) return 'normal';
        return 'wide';
    }

    protected function calculatePriority(array $conditions): int
    {
        return count($conditions) * 10;
    }
}

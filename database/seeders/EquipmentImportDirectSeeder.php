<?php

namespace Database\Seeders;

use App\Models\Equipment;
use App\Models\EquipmentCategory;
use Illuminate\Database\Seeder;

class EquipmentImportDirectSeeder extends Seeder
{
    /**
     * Run the database seeds - parse dari HTML langsung
     */
    public function run(): void
    {
        $htmlFile = base_path('dss_herro_equipment_rental.html');

        if (! file_exists($htmlFile)) {
            $this->command->error("File not found: {$htmlFile}");

            return;
        }

        $html = file_get_contents($htmlFile);

        // Extract data menggunakan simple regex
        if (! preg_match('/const\s+DB\s*=\s*\[(.*?)\];/s', $html, $matches)) {
            $this->command->error('No DB array found in HTML');

            return;
        }

        $arrayText = '['.$matches[1].']';

        // Parse JS objects ke array
        $products = $this->parseJSArray($arrayText);

        if (empty($products)) {
            $this->command->error('No products parsed');

            return;
        }

        $created = 0;
        $updated = 0;

        foreach ($products as $product) {
            try {
                $name = $product['name'] ?? null;
                $type = $product['type'] ?? 'Other';
                $capacity = $product['cap'] ?? [0, 0];
                $locations = $product['loc'] ?? [];
                $operator = $product['op'] ?? 'seated';
                $energy = $product['energy'] ?? 'electric';

                if (! $name) {
                    continue;
                }

                // Find or create category
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
                        'is_active' => true,
                        'sort_order' => 0,
                    ]
                );

                if ($equipment->wasRecentlyCreated) {
                    $created++;
                } else {
                    $updated++;
                }
            } catch (\Exception $e) {
                // Skip on error
                continue;
            }
        }

        $this->command->info("Equipment imported: {$created} created, {$updated} updated");
    }

    /**
     * Simple JS array parser
     */
    protected function parseJSArray(string $jsArray): array
    {
        $result = [];

        // Split by object
        $objects = [];
        $depth = 0;
        $current = '';

        for ($i = 0; $i < strlen($jsArray); $i++) {
            $char = $jsArray[$i];

            if ($char === '{') {
                $depth++;
            } elseif ($char === '}') {
                $depth--;
            }

            $current .= $char;

            if ($depth === 0 && $char === '}') {
                $objects[] = $current;
                $current = '';
            }
        }

        // Parse each object
        foreach ($objects as $obj) {
            $obj = trim(preg_replace('/^[^{]*{/', '{', $obj));  // Clean up
            $obj = preg_replace('/}[^}]*$/', '}', $obj);       // Clean up

            // Parse properties
            $data = [];

            // Extract quoted string values
            foreach (['name', 'type', 'cat', 'energy', 'op'] as $key) {
                if (preg_match('/'.$key.':"([^"]*)"/', $obj, $m)) {
                    $data[$key] = $m[1];
                }
            }

            // Extract array values (locations)
            if (preg_match('/loc:\[(.*?)\]/', $obj, $m)) {
                $locs = [];
                if (preg_match_all('/"([^"]*)"/', $m[1], $matches)) {
                    $locs = $matches[1];
                }
                $data['loc'] = $locs;
            }

            // Extract capacity array
            if (preg_match('/cap:\[(\d+),(\d+)\]/', $obj, $m)) {
                $data['cap'] = [(int) $m[1], (int) $m[2]];
            }

            if (! empty($data)) {
                $result[] = $data;
            }
        }

        return $result;
    }
}

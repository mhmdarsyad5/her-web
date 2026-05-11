<?php

namespace Database\Seeders;

use App\Models\DSSRule;
use Illuminate\Database\Seeder;

class DSSRuleSeeder extends Seeder
{
    /**
     * Run the database seeds - PURE STANDALONE
     */
    public function run(): void
    {
        // Clear existing rules to prevent duplicates
        DSSRule::query()->delete();

        $rules = [
            [
                'product_name' => 'Electric Pallet Truck HELI CBD20J-Li2',
                'category_name' => 'Electric Stacker',
                'brand' => 'HELI',
                'model' => 'CBD20J-Li2',
                'name' => 'Solusi Ringan untuk Retail & Pergudangan',
                'conditions' => [
                    'location' => ['indoor'],
                    'industry' => 'retail',
                    'weight' => ['1to2t'],
                    'height' => ['le0.125m'],
                    'energy' => 'lithium',
                ],
                'display_specifications' => [
                    'capacity' => '2000kg',
                    'mast_height' => '200mm',
                    'battery' => 'Lithium 48V/20Ah',
                ],
                'priority' => 100,
                'relevance_score' => 100,
            ],
            [
                'product_name' => 'Reach Truck HELI CQD16-GB2S (G-Series)',
                'category_name' => 'Reach Truck',
                'brand' => 'HELI',
                'model' => 'CQD16-GB2S',
                'name' => 'Ideal untuk Lorong Sempit & High Racking',
                'conditions' => [
                    'location' => ['indoor', 'cold'],
                    'industry' => 'logistics',
                    'weight' => ['1to2t'],
                    'height' => ['7to10m', '10to15.2m'],
                    'aisle' => 'narrow',
                    'energy' => 'electric',
                ],
                'display_specifications' => [
                    'capacity' => '1600kg',
                    'mast_height' => '9500mm',
                    'min_aisle' => '2700mm',
                ],
                'priority' => 90,
                'relevance_score' => 100,
            ],
            [
                'product_name' => 'Diesel Forklift CPCD35-G3',
                'category_name' => 'IC Forklift',
                'brand' => 'HELI',
                'model' => 'CPCD35-G3',
                'name' => 'Performa Tangguh untuk Pabrik & Outdoor',
                'conditions' => [
                    'location' => ['outdoor', 'rough'],
                    'industry' => 'factory',
                    'weight' => ['2to3.5t', '3.5to5t'],
                    'height' => ['2to5.5m'],
                    'energy' => 'diesel',
                ],
                'display_specifications' => [
                    'capacity' => '3500kg',
                    'mast_height' => '4700mm',
                    'engine' => 'Isuzu/Powerful Diesel',
                ],
                'priority' => 80,
                'relevance_score' => 100,
            ],
            [
                'product_name' => 'Electric Stacker CDD15J-Li',
                'category_name' => 'Electric Stacker',
                'brand' => 'HELI',
                'model' => 'CDD15J-Li',
                'name' => 'Sangat Hemat untuk Logistik & Farmasi',
                'conditions' => [
                    'location' => ['indoor'],
                    'industry' => 'food_pharma',
                    'weight' => ['le1t', '1to2t'],
                    'height' => ['2to5.5m'],
                    'energy' => 'lithium',
                ],
                'display_specifications' => [
                    'capacity' => '1500kg',
                    'mast_height' => '3000mm',
                    'battery' => 'Lithium-ion',
                ],
                'priority' => 85,
                'relevance_score' => 100,
            ],
        ];

        foreach ($rules as $ruleData) {
            DSSRule::create(array_merge($ruleData, ['is_active' => true]));
        }

        $this->command->info("DSS Standalone Rules seeded successfully with " . count($rules) . " sample cases.");
    }
}

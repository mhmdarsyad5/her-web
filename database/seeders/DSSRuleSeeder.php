<?php

namespace Database\Seeders;

use App\Models\DSSRule;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DSSRuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing rules to prevent duplicates and clean old data
        DSSRule::truncate();

        // Find products by slug to set up actual product_id
        $xeForkliftSmall = Product::where('slug', 'xe-series-forklift-elektrik-15-38t')->first();
        $xeForkliftLarge = Product::where('slug', 'xe-series-forklift-elektrik-4-5t')->first();
        $a2DieselForklift = Product::where('slug', 'a2-series-forklift-diesel')->first();
        $aReachTruck = Product::where('slug', 'a-series-reach-truck')->first();
        $aPalletStacker = Product::where('slug', 'a-series-stand-on-pallet-stacker-with-reach-fork')->first();

        $rules = [
            [
                'product_id' => $xeForkliftSmall?->id,
                'product_name' => 'XE Series Forklift Elektrik 1.5-3.8t',
                'category_name' => 'Forklift Elektrik',
                'brand' => 'HANGCHA',
                'model' => 'XE Series (1.5-3.8 Ton)',
                'name' => 'Solusi forklift elektrik cepat charge & efisiensi tinggi',
                'conditions' => [
                    'industry' => ['retail', 'food_pharma', 'logistics', 'factory'],
                    'product_type' => ['forklift'],
                    'energy' => 'lithium',
                    'weight' => ['1to2t', '2to3.5t'],
                    'height' => ['2to5.5m', '5.5to7m'],
                ],
                'display_specifications' => [
                    'capacity' => '1.5 - 3.8 Ton',
                    'mast_height' => '2.0 - 5.5 Meter',
                    'battery' => 'Lithium-Ion Technology',
                ],
                'priority' => 100,
                'relevance_score' => 100,
            ],
            [
                'product_id' => $xeForkliftLarge?->id,
                'product_name' => 'XE Series Forklift Elektrik 4-5t',
                'category_name' => 'Forklift Elektrik',
                'brand' => 'HANGCHA',
                'model' => 'XE Series (4-5 Ton)',
                'name' => 'Forklift elektrik ramah lingkungan untuk beban berat',
                'conditions' => [
                    'industry' => ['logistics', 'factory', 'chemical_energy'],
                    'product_type' => ['forklift'],
                    'energy' => 'lithium',
                    'weight' => ['3.5to5t', '5to10t'],
                    'height' => ['2to5.5m', '5.5to7m'],
                ],
                'display_specifications' => [
                    'capacity' => '4.0 - 5.0 Ton',
                    'mast_height' => '2.0 - 5.5 Meter',
                    'battery' => 'Lithium-Ion Heavy Duty',
                ],
                'priority' => 90,
                'relevance_score' => 100,
            ],
            [
                'product_id' => $a2DieselForklift?->id,
                'product_name' => 'A2 Series Forklift Diesel',
                'category_name' => 'Forklift IC/Diesel',
                'brand' => 'HANGCHA',
                'model' => 'A2 Series Diesel',
                'name' => 'Forklift diesel tangguh untuk area outdoor',
                'conditions' => [
                    'industry' => ['factory', 'chemical_energy'],
                    'product_type' => ['forklift'],
                    'energy' => 'diesel',
                    'weight' => ['2to3.5t', '3.5to5t', '5to10t'],
                    'height' => ['2to5.5m', '5.5to7m'],
                ],
                'display_specifications' => [
                    'capacity' => '2.0 - 10.0 Ton',
                    'mast_height' => '2.0 - 6.0 Meter',
                    'engine' => 'Powerful Japanese Diesel Engine',
                ],
                'priority' => 80,
                'relevance_score' => 100,
            ],
            [
                'product_id' => $aReachTruck?->id,
                'product_name' => 'A Series Reach Truck',
                'category_name' => 'Reach Truck',
                'brand' => 'HANGCHA',
                'model' => 'A Series Reach Truck',
                'name' => 'Reach truck andal untuk racking tinggi & lorong sempit',
                'conditions' => [
                    'industry' => ['retail', 'food_pharma', 'logistics'],
                    'product_type' => ['reach_truck'],
                    'energy' => 'electric',
                    'weight' => ['1to2t', '2to3.5t'],
                    'height' => ['5.5to7m', '7to10m', 'gt10m'],
                ],
                'display_specifications' => [
                    'capacity' => '1.5 - 3.5 Ton',
                    'mast_height' => '3.0 - 12.5 Meter',
                    'min_aisle' => 'Narrow Aisle Compatible',
                ],
                'priority' => 95,
                'relevance_score' => 100,
            ],
            [
                'product_id' => $aPalletStacker?->id,
                'product_name' => 'A Series Stand-On Pallet Stacker with Reach Fork',
                'category_name' => 'Electric Stacker',
                'brand' => 'HANGCHA',
                'model' => 'A Series Stacker',
                'name' => 'Stacker elektrik andal untuk penumpukan palet di gudang',
                'conditions' => [
                    'industry' => ['retail', 'food_pharma', 'logistics'],
                    'product_type' => ['electric_stacker', 'pallet_truck'],
                    'energy' => 'electric',
                    'weight' => ['le1t', '1to2t'],
                    'height' => ['2to5.5m', '5.5to7m'],
                ],
                'display_specifications' => [
                    'capacity' => '1.0 - 2.0 Ton',
                    'mast_height' => '2.0 - 5.5 Meter',
                    'battery' => 'Lead-Acid Maintenance Free',
                ],
                'priority' => 85,
                'relevance_score' => 100,
            ],
        ];

        foreach ($rules as $ruleData) {
            DSSRule::create(array_merge($ruleData, ['is_active' => true]));
        }

        $this->command->info("DSS Rules seeded successfully and mapped to real Products catalog!");
    }
}

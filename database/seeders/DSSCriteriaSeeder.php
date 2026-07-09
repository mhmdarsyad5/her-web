<?php

namespace Database\Seeders;

use App\Models\DSSCriteria;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DSSCriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing criteria to prevent duplicates and clean old data
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DSSCriteria::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $criteria = [
            // Industries (Jenis industri)
            ['field_type' => 'industry', 'code' => 'retail', 'name' => 'Ritel / Grosir', 'sort_order' => 1],
            ['field_type' => 'industry', 'code' => 'food_pharma', 'name' => 'Makanan / Farmasi', 'sort_order' => 2],
            ['field_type' => 'industry', 'code' => 'logistics', 'name' => 'Transportasi / Logistik', 'sort_order' => 3],
            ['field_type' => 'industry', 'code' => 'factory', 'name' => 'Manufaktur', 'sort_order' => 4],
            ['field_type' => 'industry', 'code' => 'automotive', 'name' => 'Otomotif', 'sort_order' => 5],
            ['field_type' => 'industry', 'code' => 'ports_terminals', 'name' => 'Pelabuhan / Terminal', 'sort_order' => 6],
            ['field_type' => 'industry', 'code' => 'chemical_energy', 'name' => 'Kimia / Energi', 'sort_order' => 7],
            ['field_type' => 'industry', 'code' => 'forestry_wood', 'name' => 'Kehutanan / Kayu', 'sort_order' => 8],
            ['field_type' => 'industry', 'code' => 'others', 'name' => 'Lainnya', 'sort_order' => 9],

            // Product Types (Jenis Unit Forklift/Reach Truck)
            ['field_type' => 'product_type', 'code' => 'forklift', 'name' => 'Forklift (Counterbalance)', 'sort_order' => 1],
            ['field_type' => 'product_type', 'code' => 'reach_truck', 'name' => 'Reach Truck', 'sort_order' => 2],
            ['field_type' => 'product_type', 'code' => 'electric_stacker', 'name' => 'Electric Stacker', 'sort_order' => 3],
            ['field_type' => 'product_type', 'code' => 'pallet_truck', 'name' => 'Electric Pallet Truck', 'sort_order' => 4],

            // Drive Type / Energy (Sumber Energi)
            ['field_type' => 'energy', 'code' => 'diesel', 'name' => 'Diesel / IC (Tangguh & Outdoor)', 'sort_order' => 1],
            ['field_type' => 'energy', 'code' => 'lithium', 'name' => 'Listrik Lithium-Ion (Eco & Cepat)', 'sort_order' => 2],
            ['field_type' => 'energy', 'code' => 'electric', 'name' => 'Listrik Lead-Acid (Ekonomis)', 'sort_order' => 3],

            // Load Capacity (Kapasitas Beban)
            ['field_type' => 'weight', 'code' => 'le1t', 'name' => '≤ 1 Ton', 'sort_order' => 1],
            ['field_type' => 'weight', 'code' => '1to2t', 'name' => '1 – 2 Ton', 'sort_order' => 2],
            ['field_type' => 'weight', 'code' => '2to3.5t', 'name' => '2 – 3,5 Ton', 'sort_order' => 3],
            ['field_type' => 'weight', 'code' => '3.5to5t', 'name' => '3,5 – 5 Ton', 'sort_order' => 4],
            ['field_type' => 'weight', 'code' => '5to10t', 'name' => '5 – 10 Ton', 'sort_order' => 5],
            ['field_type' => 'weight', 'code' => 'gt10t', 'name' => '> 10 Ton', 'sort_order' => 6],

            // Lift Height (Tinggi Angkat)
            ['field_type' => 'height', 'code' => 'le0.125m', 'name' => 'Tinggi Rendah (≤ 0.125 m)', 'sort_order' => 1],
            ['field_type' => 'height', 'code' => '0.126to2m', 'name' => 'Tinggi Sedang (0.126 – 2 m)', 'sort_order' => 2],
            ['field_type' => 'height', 'code' => '2to5.5m', 'name' => 'Tinggi Standar (2 – 5,5 m)', 'sort_order' => 3],
            ['field_type' => 'height', 'code' => '5.5to7m', 'name' => 'Tinggi Sedang (5,5 – 7 m)', 'sort_order' => 4],
            ['field_type' => 'height', 'code' => '7to10m', 'name' => 'Tinggi Tinggi (7 – 10 m)', 'sort_order' => 5],
            ['field_type' => 'height', 'code' => 'gt10m', 'name' => 'Sangat Tinggi (> 10 m)', 'sort_order' => 6],
        ];

        foreach ($criteria as $item) {
            DSSCriteria::create($item);
        }

        $this->command->info('DSS Criteria seeded successfully with clean new choices!');
    }
}

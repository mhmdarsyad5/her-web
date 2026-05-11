<?php

namespace Database\Seeders;

use App\Models\DSSCriteria;
use Illuminate\Database\Seeder;

class DSSCriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing criteria to prevent duplicates
        DSSCriteria::truncate();

        $criteria = [
            // Locations (Lokasi operasional)
            ['field_type' => 'location', 'code' => 'indoor', 'name' => 'Indoor (gudang, pabrik)', 'sort_order' => 1],
            ['field_type' => 'location', 'code' => 'outdoor', 'name' => 'Outdoor (lapangan terbuka)', 'sort_order' => 2],
            ['field_type' => 'location', 'code' => 'rough', 'name' => 'Outdoor medan berat (tambang, perkebunan)', 'sort_order' => 3],
            ['field_type' => 'location', 'code' => 'cold', 'name' => 'Cold storage / freezer', 'sort_order' => 4],
            ['field_type' => 'location', 'code' => 'hazardous', 'name' => 'Area berbahaya / berpotensi ledakan', 'sort_order' => 5],
            ['field_type' => 'location', 'code' => 'port', 'name' => 'Pelabuhan / container yard', 'sort_order' => 6],
            ['field_type' => 'location', 'code' => 'height', 'name' => 'Pekerjaan ketinggian (gedung, tower)', 'sort_order' => 7],

            // Industries (Jenis industri) - NEW LIST
            ['field_type' => 'industry', 'code' => 'retail', 'name' => 'Retail/Grosir', 'sort_order' => 1],
            ['field_type' => 'industry', 'code' => 'food_pharma', 'name' => 'Makanan/Farmasi', 'sort_order' => 2],
            ['field_type' => 'industry', 'code' => 'logistics', 'name' => 'Transport/Logistik', 'sort_order' => 3],
            ['field_type' => 'industry', 'code' => 'factory', 'name' => 'Pabrik', 'sort_order' => 4],
            ['field_type' => 'industry', 'code' => 'autonomous', 'name' => 'Autonomous', 'sort_order' => 5],
            ['field_type' => 'industry', 'code' => 'port_airport', 'name' => 'Pelabuhan/Bandara', 'sort_order' => 6],
            ['field_type' => 'industry', 'code' => 'chemical_energy', 'name' => 'Chemical/Energy', 'sort_order' => 7],
            ['field_type' => 'industry', 'code' => 'timber_mining', 'name' => 'Kayu/Tambang', 'sort_order' => 8],

            // Cargo types (Jenis barang yang diangkut)
            ['field_type' => 'cargo_type', 'code' => 'pallet', 'name' => 'Palet & karton', 'sort_order' => 1],
            ['field_type' => 'cargo_type', 'code' => 'drum', 'name' => 'Drum & cairan', 'sort_order' => 2],
            ['field_type' => 'cargo_type', 'code' => 'coil', 'name' => 'Koil / roll bahan', 'sort_order' => 3],
            ['field_type' => 'cargo_type', 'code' => 'container', 'name' => 'Container / peti kemas', 'sort_order' => 4],
            ['field_type' => 'cargo_type', 'code' => 'loose', 'name' => 'Barang curah / loose', 'sort_order' => 5],
            ['field_type' => 'cargo_type', 'code' => 'long', 'name' => 'Barang panjang (besi, kayu)', 'sort_order' => 6],
            ['field_type' => 'cargo_type', 'code' => 'person', 'name' => 'Orang / manpower di ketinggian', 'sort_order' => 7],
            ['field_type' => 'cargo_type', 'code' => 'tow', 'name' => 'Tarik/dorong rangkaian', 'sort_order' => 8],

            // Weight ranges (Load Capacity - 8 Pilihan)
            ['field_type' => 'weight', 'code' => 'le1t', 'name' => '≤ 1 ton', 'sort_order' => 1],
            ['field_type' => 'weight', 'code' => '1to2t', 'name' => '1 – 2 ton', 'sort_order' => 2],
            ['field_type' => 'weight', 'code' => '2to3.5t', 'name' => '2 – 3,5 ton', 'sort_order' => 3],
            ['field_type' => 'weight', 'code' => '3.5to5t', 'name' => '3,5 – 5 ton', 'sort_order' => 4],
            ['field_type' => 'weight', 'code' => '5to10t', 'name' => '5 – 10 ton', 'sort_order' => 5],
            ['field_type' => 'weight', 'code' => '10to16t', 'name' => '10 – 16 ton', 'sort_order' => 6],
            ['field_type' => 'weight', 'code' => '16to35t', 'name' => '16 – 35 ton', 'sort_order' => 7],
            ['field_type' => 'weight', 'code' => 'gt35t', 'name' => '> 35 ton', 'sort_order' => 8],

            // Height ranges (Lift Height - 7 Pilihan)
            ['field_type' => 'height', 'code' => 'le0.125m', 'name' => '≤ 0,125 m', 'sort_order' => 1],
            ['field_type' => 'height', 'code' => '0.126to2m', 'name' => '0,126 – 2 m', 'sort_order' => 2],
            ['field_type' => 'height', 'code' => '2to5.5m', 'name' => '2 – 5,5 m', 'sort_order' => 3],
            ['field_type' => 'height', 'code' => '5.5to7m', 'name' => '5,5 – 7 m', 'sort_order' => 4],
            ['field_type' => 'height', 'code' => '7to10m', 'name' => '7 – 10 m', 'sort_order' => 5],
            ['field_type' => 'height', 'code' => '10to15.2m', 'name' => '10 – 15,2 m', 'sort_order' => 6],
            ['field_type' => 'height', 'code' => 'gt15.2m', 'name' => '> 15,2 m', 'sort_order' => 7],

            // Aisle width (Lebar lorong / aisle tersempit)
            ['field_type' => 'aisle', 'code' => 'vna', 'name' => 'Sangat sempit (kurang 2 meter) – VNA', 'sort_order' => 1],
            ['field_type' => 'aisle', 'code' => 'narrow', 'name' => 'Sempit (2 – 3 meter)', 'sort_order' => 2],
            ['field_type' => 'aisle', 'code' => 'normal', 'name' => 'Normal (3 – 4 meter)', 'sort_order' => 3],
            ['field_type' => 'aisle', 'code' => 'wide', 'name' => 'Lebar (lebih 4 meter)', 'sort_order' => 4],

            // Energy sources (Preferensi sumber energi)
            ['field_type' => 'energy', 'code' => 'lithium', 'name' => 'Listrik Lithium (low emission, biaya operasional rendah)', 'sort_order' => 1],
            ['field_type' => 'energy', 'code' => 'electric', 'name' => 'Listrik Lead-Acid', 'sort_order' => 2],
            ['field_type' => 'energy', 'code' => 'diesel', 'name' => 'Diesel / IC (beban berat, outdoor)', 'sort_order' => 3],
            ['field_type' => 'energy', 'code' => 'any', 'name' => 'Tidak ada preferensi', 'sort_order' => 4],

            // Current units (Unit yang dipakai sekarang)
            ['field_type' => 'unit', 'code' => 'none', 'name' => 'Belum ada unit', 'sort_order' => 1],
            ['field_type' => 'unit', 'code' => 'forklift_diesel', 'name' => 'Forklift diesel', 'sort_order' => 2],
            ['field_type' => 'unit', 'code' => 'forklift_electric', 'name' => 'Forklift elektrik', 'sort_order' => 3],
            ['field_type' => 'unit', 'code' => 'hand_pallet', 'name' => 'Hand pallet manual', 'sort_order' => 4],
            ['field_type' => 'unit', 'code' => 'reach_truck', 'name' => 'Reach truck', 'sort_order' => 5],
            ['field_type' => 'unit', 'code' => 'other', 'name' => 'Peralatan lain', 'sort_order' => 6],

            // Operator position (Operator - posisi berkendara)
            ['field_type' => 'operator', 'code' => 'seated', 'name' => 'Duduk (seated)', 'sort_order' => 1],
            ['field_type' => 'operator', 'code' => 'standing', 'name' => 'Berdiri (standing/pedestrian)', 'sort_order' => 2],
            ['field_type' => 'operator', 'code' => 'pedestrian', 'name' => 'Pedestrian', 'sort_order' => 3],
            ['field_type' => 'operator', 'code' => 'any', 'name' => 'Tidak ada preferensi', 'sort_order' => 4],
        ];

        foreach ($criteria as $item) {
            DSSCriteria::updateOrCreate(
                ['field_type' => $item['field_type'], 'code' => $item['code']],
                $item
            );
        }

        $this->command->info('DSS Criteria seeded successfully!');
    }
}

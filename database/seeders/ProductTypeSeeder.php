<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\ProductType::updateOrCreate(
            ['slug' => 'electric'],
            ['name' => 'Forklift Elektrik', 'sort_order' => 1, 'is_active' => true]
        );

        \App\Models\ProductType::updateOrCreate(
            ['slug' => 'diesel'],
            ['name' => 'Forklift Diesel', 'sort_order' => 2, 'is_active' => true]
        );

        \App\Models\ProductType::updateOrCreate(
            ['slug' => 'pallet-truck'],
            ['name' => 'Pallet Truck', 'sort_order' => 3, 'is_active' => true]
        );

        \App\Models\ProductType::updateOrCreate(
            ['slug' => 'pallet-stacker'],
            ['name' => 'Pallet Stacker', 'sort_order' => 4, 'is_active' => true]
        );

        \App\Models\ProductType::updateOrCreate(
            ['slug' => 'warehouse'],
            ['name' => 'Warehouse & AGV', 'sort_order' => 5, 'is_active' => true]
        );
    }
}

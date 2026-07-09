<?php

use App\Models\Product;

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Specs for 1.5-3.8t
$specsSmall = [
    ['key' => 'Drive Type', 'value' => 'Li-Ion'],
    ['key' => 'Lifting Height', 'value' => '0~7000mm'],
    ['key' => 'Load Capacity', 'value' => '1,500~3,800kg'],
    ['key' => 'Travel Speed', 'value' => '17km/h'],
    ['key' => 'Dimensi', 'value' => '2500~2670*1225*2165~2180mm'],
    ['key' => 'Service Weight', 'value' => '3,450~5,050kg'],
    ['key' => 'Turning Radius', 'value' => '2200~2420mm'],
    ['key' => 'Operator Type', 'value' => 'Seated'],
    ['key' => 'Gradeability', 'value' => '18%'],
    ['key' => 'Battery Voltage STD', 'value' => '80V/230Ah'],
];

// Specs for 4-5t
$specsLarge = [
    ['key' => 'Drive Type', 'value' => 'Li-Ion'],
    ['key' => 'Lifting Height', 'value' => '0~7000mm'],
    ['key' => 'Load Capacity', 'value' => '4,000~5,000kg'],
    ['key' => 'Travel Speed', 'value' => '16km/h'],
    ['key' => 'Dimensi', 'value' => '2850~2980*1350*2220~2250mm'],
    ['key' => 'Service Weight', 'value' => '5,200~6,100kg'],
    ['key' => 'Turning Radius', 'value' => '2400~2600mm'],
    ['key' => 'Operator Type', 'value' => 'Seated'],
    ['key' => 'Gradeability', 'value' => '15%'],
    ['key' => 'Battery Voltage STD', 'value' => '80V/400Ah'],
];

// Specs for Diesel
$specsDiesel = [
    ['key' => 'Drive Type', 'value' => 'Diesel'],
    ['key' => 'Lifting Height', 'value' => '3000~6000mm'],
    ['key' => 'Load Capacity', 'value' => '2,000~3,500kg'],
    ['key' => 'Engine Model', 'value' => 'XinChai C490 / Isuzu C240'],
    ['key' => 'Travel Speed', 'value' => '19km/h'],
    ['key' => 'Dimensi', 'value' => '2700*1225*2090mm'],
    ['key' => 'Service Weight', 'value' => '3,400~4,800kg'],
    ['key' => 'Turning Radius', 'value' => '2240~2400mm'],
    ['key' => 'Operator Type', 'value' => 'Seated'],
    ['key' => 'Fuel Tank Capacity', 'value' => '60L'],
];

$updated = 0;

$p1 = Product::where('slug', 'xe-series-forklift-elektrik-15-38t')->first();
if ($p1) {
    $p1->update([
        'specifications' => $specsSmall,
        'product_type' => 'lithium'
    ]);
    $updated++;
}

$p2 = Product::where('slug', 'xe-series-forklift-elektrik-4-5t')->first();
if ($p2) {
    $p2->update([
        'specifications' => $specsLarge,
        'product_type' => 'electric'
    ]);
    $updated++;
}

$p3 = Product::where('slug', 'a2-series-forklift-diesel')->first();
if ($p3) {
    $p3->update([
        'specifications' => $specsDiesel,
        'product_type' => 'diesel'
    ]);
    $updated++;
}

echo "Successfully updated specifications and product types for {$updated} products!\n";

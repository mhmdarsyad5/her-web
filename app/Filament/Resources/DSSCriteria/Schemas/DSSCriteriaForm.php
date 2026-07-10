<?php

namespace App\Filament\Resources\DSSCriteria\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class DSSCriteriaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('field_type')
                ->label('Tipe Field')
                ->options([
                    'industry' => 'Industri',
                    'product_type' => 'Jenis Unit (Product Type)',
                    'energy' => 'Energi (Drive Type)',
                    'weight' => 'Berat (Load Capacity)',
                    'height' => 'Ketinggian (Lift Height)',
                    'location' => 'Lokasi',
                    'cargo_type' => 'Jenis Barang',
                    'aisle' => 'Lebar Lorong',
                    'unit' => 'Unit Sekarang',
                    'operator' => 'Posisi Operator',
                ])
                ->required(),

            TextInput::make('code')
                ->label('Kode')
                ->required(),

            TextInput::make('name')
                ->label('Nama (Indonesia)')
                ->required(),

            TextInput::make('sort_order')
                ->label('Urutan')
                ->numeric()
                ->default(0),

            Select::make('equipment_map')
                ->label('Tipe Unit yang Diizinkan')
                ->helperText('Tentukan unit mana saja yang boleh memilih kriteria ini di form SPK/DSS (kosongkan jika bisa dipilih semua unit).')
                ->multiple()
                ->options([
                    'forklift' => 'Forklift (Counterbalance)',
                    'reach_truck' => 'Reach Truck',
                    'electric_stacker' => 'Electric Stacker',
                    'pallet_truck' => 'Electric Pallet Truck',
                ])
                ->columnSpanFull(),

            Toggle::make('is_active')
                ->label('Aktif')
                ->default(true),
        ]);
    }
}

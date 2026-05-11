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
                    'location' => 'Lokasi',
                    'industry' => 'Industri',
                    'cargo_type' => 'Jenis Barang',
                    'weight' => 'Berat',
                    'height' => 'Ketinggian',
                    'aisle' => 'Lebar Lorong',
                    'energy' => 'Energi',
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

            Toggle::make('is_active')
                ->label('Aktif')
                ->default(true),
        ]);
    }
}

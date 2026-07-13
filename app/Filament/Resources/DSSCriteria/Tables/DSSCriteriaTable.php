<?php

namespace App\Filament\Resources\DSSCriteria\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DSSCriteriaTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('field_type')
                    ->label('Tipe Field')
                    ->sortable()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
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
                        default => $state,
                    }),
                TextColumn::make('code')->label('Kode')->searchable()->sortable(),
                TextColumn::make('name')->label('Nama')->searchable()->sortable(),
                IconColumn::make('is_active')->label('Aktif')->boolean(),
                TextColumn::make('sort_order')->label('Urutan')->numeric(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

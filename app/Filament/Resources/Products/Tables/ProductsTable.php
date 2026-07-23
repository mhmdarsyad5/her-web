<?php

namespace App\Filament\Resources\Products\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                /* =====================
                 * IMAGE (THUMBNAIL)
                 * ===================== */
                ImageColumn::make('images')
                    ->label('Image')
                    ->disk('public')
                    ->circular()
                    ->size(48)
                    ->getStateUsing(fn ($record) => $record->images[0] ?? null),

                /* =====================
                 * PRODUCT INFO
                 * ===================== */
                TextColumn::make('name_id')
                    ->label('Nama Produk')
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),

                TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->toggleable(),

                /* =====================
                 * TIPE / SEGMEN PRODUK
                 * ===================== */
                TextColumn::make('product_type')
                    ->label('Tipe / Segmen')
                    ->formatStateUsing(function ($state) {
                        return \App\Models\ProductType::where('slug', $state)->value('name') ?? $state;
                    })
                    ->badge()
                    ->color('primary')
                    ->sortable()
                    ->searchable(),

                /* =====================
                 * KRITERIA REKOMENDASI (DSS)
                 * ===================== */
                TextColumn::make('dssCriteria.name')
                    ->label('Sektor Industri')
                    ->badge()
                    ->color('success')
                    ->separator(', ')
                    ->toggleable(),

                TextColumn::make('max_lift_height_mm')
                    ->label('Tinggi Maks (mm)')
                    ->numeric()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('capacity_range')
                    ->label('Kapasitas Rekomendasi')
                    ->getStateUsing(function ($record) {
                        if ($record->min_capacity_kg === null && $record->max_capacity_kg === null) {
                            return '-';
                        }
                        $min = $record->min_capacity_kg ?? 0;
                        $max = $record->max_capacity_kg ?? 0;

                        return number_format($min, 0, ',', '.').' - '.number_format($max, 0, ',', '.').' kg';
                    })
                    ->toggleable(),

                /* =====================
                 * STATUS & ORDER
                 * ===================== */
                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),

                TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->numeric()
                    ->sortable(),

                /* =====================
                 * META
                 * ===================== */
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Diupdate')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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

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
                    ->getStateUsing(fn($record) => $record->images[0] ?? null),

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
                 * PRICING
                 * ===================== */
                TextColumn::make('price')
                    ->label('Harga')
                    ->money('IDR')
                    ->sortable(),

                TextColumn::make('sale_price')
                    ->label('Harga Promo')
                    ->money('IDR')
                    ->sortable()
                    ->placeholder('-'),

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

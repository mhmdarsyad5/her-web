<?php

namespace App\Filament\Resources\Galleries\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class GalleriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('thumbnail')
                    ->label('Thumbnail')
                    ->circular()
                    ->disk('public')
                    ->square(),

                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->limit(40)
                    ->sortable(),
                IconColumn::make('is_published')
                    ->label('Published')
                    ->boolean()
                    ->sortable(),

                TextColumn::make('order_column')
                    ->label('Urutan')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->date('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->date('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])

            ->filters([
                TernaryFilter::make('is_published')
                    ->label('Status Publikasi')
                    ->placeholder('Semua')
                    ->trueLabel('Published')
                    ->falseLabel('Draft'),
            ])

            ->recordActions([
                EditAction::make()
                    ->label('Edit'),
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

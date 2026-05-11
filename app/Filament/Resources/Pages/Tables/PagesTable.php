<?php

namespace App\Filament\Resources\Pages\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;

class PagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // ======================
                // THUMBNAIL
                // ======================
                ImageColumn::make('thumbnail')
                    ->disk('public')
                    ->circular()
                    ->size(50)
                    ->label('Thumbnail')
                    ->toggleable(),
                // ======================
                // TITLE ID (DEFAULT)
                // ======================
                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->limit(40),

                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('primary'),

                // ======================
                // SLUG
                // ======================
                TextColumn::make('slug')
                    ->searchable()
                    ->limit(40),

                // ======================
                // STATUS
                // ======================
                IconColumn::make('is_published')
                    ->boolean()
                    ->label('Published'),

                TextColumn::make('publish_at')
                    ->label('Publish At')
                    ->dateTime()
                    ->sortable(),

                // ======================
                // META
                // ======================
                TextColumn::make('creator.name')
                    ->label('Created By')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime()
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

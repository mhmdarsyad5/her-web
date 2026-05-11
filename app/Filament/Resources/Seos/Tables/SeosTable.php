<?php

namespace App\Filament\Resources\Seos\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SeosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('page')
                    ->label('Page')
                    ->searchable(),

                TextColumn::make('meta_title')
                    ->label('Meta Title')
                    ->limit(60)
                    ->searchable(),

                TextColumn::make('meta_description')
                    ->label('Meta Description')
                    ->limit(80)
                    ->toggleable(isToggledHiddenByDefault: true),

                ImageColumn::make('og_image')
                    ->label('OG Image')
                    ->disk('public')
                    ->height(40),

                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Updated At')
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

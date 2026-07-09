<?php

namespace App\Filament\Resources\HeroSections\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class HeroSectionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // IMAGE
                ImageColumn::make('image')
                    ->label('Images')
                    ->disk('public')
                    ->height(56)
                    ->circular()
                    ->stacked(),

                // TITLE
                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->wrap(),

                // BUTTON TEXT
                TextColumn::make('button_text')
                    ->label('Button')
                    ->searchable()
                    ->wrap(),

                // URL
                TextColumn::make('button_url')
                    ->label('URL')
                    ->limit(30)
                    ->copyable()
                    ->tooltip(fn($record) => $record->button_url),

                // META
                TextColumn::make('created_at')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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

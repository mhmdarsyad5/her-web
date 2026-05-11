<?php

namespace App\Filament\Resources\DSSRule\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DSSRulesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Rule')
                    ->searchable()
                    ->sortable()
                    ->limit(50),

                TextColumn::make('conditions_display')
                    ->label('Kondisi')
                    ->getStateUsing(function ($record) {
                        $conditions = $record->conditions ?? [];
                        $labels = [];
                        foreach ($conditions as $key => $value) {
                            if (is_array($value)) {
                                $labels[] = "$key: " . implode(', ', $value);
                            } else {
                                $labels[] = "$key: $value";
                            }
                        }
                        return implode(' | ', $labels) ?: '-';
                    })
                    ->limit(60),

                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
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

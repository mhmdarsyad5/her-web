<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('avatar')
                    ->label('Foto')
                    ->circular(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('is_online')
                    ->label('Status')
                    ->badge()
                    ->state(fn (\App\Models\User $record): string => $record->isOnline() ? 'Online' : 'Offline')
                    ->color(fn (\App\Models\User $record): string => $record->isOnline() ? 'success' : 'gray')
                    ->description(fn (\App\Models\User $record): ?string => $record->isOnline()
                        ? null
                        : ($record->last_seen_at ? 'Terakhir aktif: '.$record->last_seen_at->diffForHumans() : 'Belum pernah aktif')
                    ),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('roles.name')
                    ->badge()
                    ->label('Role')
                    ->color(fn () => collect([
                        'primary',
                        'success',
                        'warning',
                        'danger',
                        'info',
                    ])->random()),
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

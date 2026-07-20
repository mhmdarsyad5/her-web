<?php

namespace App\Filament\Resources\ActivityLogs;

use App\Filament\Resources\ActivityLogs\Pages\ListActivityLogs;
use App\Models\ActivityLog;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ActivityLogResource extends Resource
{
    protected static ?string $model = ActivityLog::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationLabel = 'Activity Logs';

    protected static ?string $title = 'Catatan Aktivitas Admin';

    protected static \UnitEnum|string|null $navigationGroup = 'System Settings';

    protected static ?int $navigationSort = 99;

    public static function canCreate(): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->label('Waktu')
                    ->dateTime('d M Y, H:i:s')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('user_name')
                    ->label('Pengguna')
                    ->badge()
                    ->color('gray')
                    ->searchable(),

                TextColumn::make('action')
                    ->label('Aksi')
                    ->badge()
                    ->color(fn (string $state): string => match (strtolower($state)) {
                        'create', 'upload', 'created' => 'success',
                        'update', 'move', 'updated' => 'info',
                        'delete', 'deleted' => 'danger',
                        default => 'warning',
                    })
                    ->formatStateUsing(fn (string $state): string => strtoupper($state))
                    ->sortable(),

                TextColumn::make('description')
                    ->label('Deskripsi Activity')
                    ->wrap()
                    ->searchable(),

                TextColumn::make('ip_address')
                    ->label('IP Address')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('action')
                    ->options([
                        'create' => 'Create / Tambah',
                        'update' => 'Update / Ubah',
                        'delete' => 'Delete / Hapus',
                        'upload' => 'Upload / Unggah',
                        'move' => 'Move / Pindah',
                    ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListActivityLogs::route('/'),
        ];
    }
}

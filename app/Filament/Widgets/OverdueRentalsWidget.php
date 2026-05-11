<?php

namespace App\Filament\Widgets;

use App\Models\Rental;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class OverdueRentalsWidget extends BaseWidget
{
    protected static ?string $heading = '⚠️ Penyewaan Terlambat';
    protected int|string|array $columnSpan = 'full';
    protected static ?int $sort = 3;

    public static function canView(): bool
    {
        return Rental::where('status', 'overdue')->exists();
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Rental::query()->where('status', 'overdue')->orderBy('rental_end'))
            ->columns([
                TextColumn::make('rental_code')
                    ->label('Kode Rental')
                    ->weight('bold'),

                TextColumn::make('equipment.name')
                    ->label('Alat')
                    ->description(fn ($record) => $record->equipment?->code ?? '—'),

                TextColumn::make('customer.name')
                    ->label('Pelanggan')
                    ->description(fn ($record) => $record->customer?->phone ?? '—'),

                TextColumn::make('rental_end')
                    ->label('Seharusnya Kembali')
                    ->date('d M Y')
                    ->color('danger'),

                TextColumn::make('days_overdue')
                    ->label('Terlambat')
                    ->getStateUsing(fn ($record) => $record->daysOverdue() . ' hari')
                    ->badge()
                    ->color('danger'),
            ]);
    }
}

<?php

namespace App\Filament\Widgets;

use App\Models\VisitorLog;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\DB;

class VisitorLocationsTable extends BaseWidget
{
    protected ?string $heading = '📍 Lokasi Pengunjung Terbanyak (90 Hari Terakhir)';

    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                VisitorLog::query()
                    ->select('city', 'region', 'country', DB::raw('count(distinct ip_address) as unique_visitors'))
                    ->whereNotNull('city')
                    ->where('city', '!=', 'Unknown')
                    ->groupBy('city', 'region', 'country')
                    ->orderBy('unique_visitors', 'desc')
            )
            ->columns([
                Tables\Columns\TextColumn::make('city')
                    ->label('Kota')
                    ->searchable()
                    ->default('Tidak Diketahui'),

                Tables\Columns\TextColumn::make('region')
                    ->label('Provinsi')
                    ->default('-'),

                Tables\Columns\TextColumn::make('country')
                    ->label('Negara')
                    ->default('-'),

                Tables\Columns\TextColumn::make('unique_visitors')
                    ->label('Jumlah Pengunjung (IP)')
                    ->badge()
                    ->color('primary')
                    ->alignEnd(),
            ])
            ->paginated([5])
            ->defaultPaginationPageOption(5);
    }
}

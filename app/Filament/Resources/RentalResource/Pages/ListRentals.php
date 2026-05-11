<?php

namespace App\Filament\Resources\RentalResource\Pages;

use App\Filament\Resources\RentalResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRentals extends ListRecords
{
    protected static string $resource = RentalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Buat Rental Baru'),
        ];
    }
}

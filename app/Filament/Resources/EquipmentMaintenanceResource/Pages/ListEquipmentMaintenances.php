<?php

namespace App\Filament\Resources\EquipmentMaintenanceResource\Pages;

use App\Filament\Resources\EquipmentMaintenanceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEquipmentMaintenances extends ListRecords
{
    protected static string $resource = EquipmentMaintenanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Tambah Maintenance'),
        ];
    }
}

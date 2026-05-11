<?php

namespace App\Filament\Resources\EquipmentMaintenanceResource\Pages;

use App\Filament\Resources\EquipmentMaintenanceResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEquipmentMaintenance extends CreateRecord
{
    protected static string $resource = EquipmentMaintenanceResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

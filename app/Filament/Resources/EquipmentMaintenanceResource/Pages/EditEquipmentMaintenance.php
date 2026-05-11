<?php

namespace App\Filament\Resources\EquipmentMaintenanceResource\Pages;

use App\Filament\Resources\EquipmentMaintenanceResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditEquipmentMaintenance extends EditRecord
{
    protected static string $resource = EquipmentMaintenanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

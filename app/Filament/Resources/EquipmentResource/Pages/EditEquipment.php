<?php

namespace App\Filament\Resources\EquipmentResource\Pages;

use App\Filament\Resources\EquipmentResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Resources\Pages\ViewRecord;

class EditEquipment extends EditRecord
{
    protected static string $resource = EquipmentResource::class;

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

<?php

namespace App\Filament\Resources\EquipmentCategoryResource\Pages;

use App\Filament\Resources\EquipmentCategoryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditEquipmentCategory extends EditRecord
{
    protected static string $resource = EquipmentCategoryResource::class;

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

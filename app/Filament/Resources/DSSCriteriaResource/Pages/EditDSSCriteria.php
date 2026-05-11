<?php

namespace App\Filament\Resources\DSSCriteriaResource\Pages;

use App\Filament\Resources\DSSCriteriaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDSSCriteria extends EditRecord
{
    protected static string $resource = DSSCriteriaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

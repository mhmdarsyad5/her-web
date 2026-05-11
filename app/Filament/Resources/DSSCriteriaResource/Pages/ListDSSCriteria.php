<?php

namespace App\Filament\Resources\DSSCriteriaResource\Pages;

use App\Filament\Resources\DSSCriteriaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDSSCriteria extends ListRecords
{
    protected static string $resource = DSSCriteriaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

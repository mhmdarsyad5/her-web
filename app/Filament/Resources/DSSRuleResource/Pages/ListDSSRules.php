<?php

namespace App\Filament\Resources\DSSRuleResource\Pages;

use App\Filament\Resources\DSSRuleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDSSRules extends ListRecords
{
    protected static string $resource = DSSRuleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

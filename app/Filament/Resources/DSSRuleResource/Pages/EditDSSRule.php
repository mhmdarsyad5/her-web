<?php

namespace App\Filament\Resources\DSSRuleResource\Pages;

use App\Filament\Resources\DSSRuleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDSSRule extends EditRecord
{
    protected static string $resource = DSSRuleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

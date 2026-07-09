<?php

namespace App\Filament\Resources\PartnerResource\Pages;

use App\Filament\Resources\PartnerResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Traits\RedirectsToIndex;

class EditPartner extends EditRecord
{
    use RedirectsToIndex;

    protected static string $resource = PartnerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

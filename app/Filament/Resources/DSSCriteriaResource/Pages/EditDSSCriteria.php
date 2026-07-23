<?php

namespace App\Filament\Resources\DSSCriteriaResource\Pages;

use App\Filament\Resources\DSSCriteriaResource;
use App\Traits\RedirectsToIndex;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDSSCriteria extends EditRecord
{
    use RedirectsToIndex;

    protected static string $resource = DSSCriteriaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['field_type'] = 'industry';

        return $data;
    }
}

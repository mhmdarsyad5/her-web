<?php

namespace App\Filament\Resources\DSSCriteriaResource\Pages;

use App\Filament\Resources\DSSCriteriaResource;
use App\Traits\RedirectsToIndex;
use Filament\Resources\Pages\CreateRecord;

class CreateDSSCriteria extends CreateRecord
{
    use RedirectsToIndex;

    protected static string $resource = DSSCriteriaResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['field_type'] = 'industry';

        return $data;
    }
}

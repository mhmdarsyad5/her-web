<?php

namespace App\Filament\Resources\Seos\Pages;

use App\Filament\Resources\Seos\SeoResource;
use App\Traits\RedirectsToIndex;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSeo extends EditRecord
{
    use RedirectsToIndex;

    protected static string $resource = SeoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

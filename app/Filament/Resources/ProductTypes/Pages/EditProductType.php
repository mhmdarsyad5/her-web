<?php

namespace App\Filament\Resources\ProductTypes\Pages;

use App\Filament\Resources\ProductTypes\ProductTypeResource;
use App\Traits\RedirectsToIndex;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditProductType extends EditRecord
{
    use RedirectsToIndex;

    protected static string $resource = ProductTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\ProductTypes\Pages;

use App\Filament\Resources\ProductTypes\ProductTypeResource;
use App\Traits\RedirectsToIndex;
use Filament\Resources\Pages\CreateRecord;

class CreateProductType extends CreateRecord
{
    use RedirectsToIndex;

    protected static string $resource = ProductTypeResource::class;
}

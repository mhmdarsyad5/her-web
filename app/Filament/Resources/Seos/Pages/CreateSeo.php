<?php

namespace App\Filament\Resources\Seos\Pages;

use App\Filament\Resources\Seos\SeoResource;
use App\Traits\RedirectsToIndex;
use Filament\Resources\Pages\CreateRecord;

class CreateSeo extends CreateRecord
{
    use RedirectsToIndex;

    protected static string $resource = SeoResource::class;
}

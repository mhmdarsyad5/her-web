<?php

namespace App\Filament\Resources\Seos\Pages;

use App\Filament\Resources\Seos\SeoResource;
use Filament\Resources\Pages\CreateRecord;
use App\Traits\RedirectsToIndex;


class CreateSeo extends CreateRecord
{
    use RedirectsToIndex;

    protected static string $resource = SeoResource::class;
}

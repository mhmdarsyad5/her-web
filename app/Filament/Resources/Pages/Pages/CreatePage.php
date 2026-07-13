<?php

namespace App\Filament\Resources\Pages\Pages;

use App\Filament\Resources\Pages\PageResource;
use App\Traits\RedirectsToIndex;
use Filament\Resources\Pages\CreateRecord;

class CreatePage extends CreateRecord
{
    use RedirectsToIndex;

    protected static string $resource = PageResource::class;
}

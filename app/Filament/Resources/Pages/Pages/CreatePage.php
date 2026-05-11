<?php

namespace App\Filament\Resources\Pages\Pages;

use App\Filament\Resources\Pages\PageResource;
use Filament\Resources\Pages\CreateRecord;
use App\Traits\RedirectsToIndex;

class CreatePage extends CreateRecord
{
    use RedirectsToIndex;
    protected static string $resource = PageResource::class;
}

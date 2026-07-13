<?php

namespace App\Filament\Resources\Services\Pages;

use App\Filament\Resources\Services\ServiceResource;
use App\Traits\RedirectsToIndex;
use Filament\Resources\Pages\CreateRecord;

class CreateService extends CreateRecord
{
    use RedirectsToIndex;

    protected static string $resource = ServiceResource::class;
}

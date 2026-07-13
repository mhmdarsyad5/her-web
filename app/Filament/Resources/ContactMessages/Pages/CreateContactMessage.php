<?php

namespace App\Filament\Resources\ContactMessages\Pages;

use App\Filament\Resources\ContactMessages\ContactMessageResource;
use App\Traits\RedirectsToIndex;
use Filament\Resources\Pages\CreateRecord;

class CreateContactMessage extends CreateRecord
{
    use RedirectsToIndex;

    protected static string $resource = ContactMessageResource::class;
}

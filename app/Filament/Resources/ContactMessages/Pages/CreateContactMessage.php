<?php

namespace App\Filament\Resources\ContactMessages\Pages;

use App\Filament\Resources\ContactMessages\ContactMessageResource;
use Filament\Resources\Pages\CreateRecord;
use App\Traits\RedirectsToIndex;

class CreateContactMessage extends CreateRecord
{
    use RedirectsToIndex;
    protected static string $resource = ContactMessageResource::class;
}

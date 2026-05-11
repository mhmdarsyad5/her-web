<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Resources\Pages\CreateRecord;
use App\Traits\RedirectsToIndex;

class CreateUser extends CreateRecord
{
    use RedirectsToIndex;
    protected static string $resource = UserResource::class;
}

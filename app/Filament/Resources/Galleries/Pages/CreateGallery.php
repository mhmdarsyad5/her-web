<?php

namespace App\Filament\Resources\Galleries\Pages;

use App\Filament\Resources\Galleries\GalleryResource;
use App\Traits\RedirectsToIndex;
use Filament\Resources\Pages\CreateRecord;

class CreateGallery extends CreateRecord
{
    use RedirectsToIndex;

    protected static string $resource = GalleryResource::class;
}

<?php

namespace App\Filament\Resources\Galleries\Pages;

use App\Filament\Resources\Galleries\GalleryResource;
use Filament\Resources\Pages\CreateRecord;
use App\Traits\RedirectsToIndex;

class CreateGallery extends CreateRecord
{
    use RedirectsToIndex;
    protected static string $resource = GalleryResource::class;
}

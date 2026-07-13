<?php

namespace App\Filament\Resources\Pages\PageCategories\Pages;

use App\Filament\Resources\Pages\PageCategories\PageCategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManagePageCategories extends ManageRecords
{
    protected static string $resource = PageCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getBreadcrumbs(): array
    {
        return [
            \App\Filament\Resources\Pages\PageResource::getUrl() => 'Artikel/Blog',
            '#' => 'Kategori',
        ];
    }
}

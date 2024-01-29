<?php

namespace App\Filament\Resources\MaterialsResource\Pages;

use App\Filament\Resources\MaterialsResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMaterials extends ListRecords
{
    protected static string $resource = MaterialsResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

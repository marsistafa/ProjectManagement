<?php

namespace App\Filament\Resources\MaterialsResource\Pages;

use App\Filament\Resources\MaterialsResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms;
use App\Filament\Resources\MaterialsResource\Pages\Model;
use App\Models\Material;
use Illuminate\Support\Facades\DB;
use Throwable;

class CreateMaterials extends CreateRecord
{
    protected static string $resource = MaterialsResource::class;

    protected function getActions(): array
    {
        return [
           //
        ];
    }

    // protected function afterCreate():void
    // {
    //         dd($this->form);
    //     MaterialDocument::create([
    //         'material_id' => $material->id,
    //         $type => $fileName,
    //         // other fields if necessary
    //     ]);
    // }
    
}

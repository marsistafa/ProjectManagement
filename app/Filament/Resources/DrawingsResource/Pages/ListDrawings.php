<?php

namespace App\Filament\Resources\DrawingsResource\Pages;

use App\Filament\Resources\DrawingsResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Models\Drawing;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Actions\DownloadBulkAction;

class ListDrawings extends ListRecords
{
    protected static string $resource = DrawingsResource::class;

    protected function getActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }

    protected function getTableQuery(): Builder
    {   
        $query = Drawing::query()
        ->join('projects', 'drawings.project_id', '=', 'projects.id')
        ->select('drawings.*', 'projects.name as name');

        return $query;
    }

}

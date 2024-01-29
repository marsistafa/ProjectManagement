<?php

namespace App\Filament\Resources\RequestForQuotationsResource\Pages;

use App\Filament\Resources\RequestForQuotationsResource;
use Filament\Pages\Actions;
use App\Models\RequestForQuotation;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListRequestForQuotations extends ListRecords
{
    protected static string $resource = RequestForQuotationsResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getTableQuery(): Builder
    {
        return RequestForQuotation::query()
            ->select('request_for_quotations.*') // Select all columns from request_for_quotations
            ->leftJoin('rfq_details', 'rfq_details.request_for_quotation_id', '=', 'request_for_quotations.id')
            ->groupBy('request_for_quotations.id')
            // Add any additional columns from rfq_details if needed
            // ->addSelect('rfq_details.some_column')
            ;
    }
}

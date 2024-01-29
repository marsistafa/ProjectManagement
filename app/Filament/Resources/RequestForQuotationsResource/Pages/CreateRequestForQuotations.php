<?php

namespace App\Filament\Resources\RequestForQuotationsResource\Pages;

use App\Filament\Resources\RequestForQuotationsResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateRequestForQuotations extends CreateRecord
{
    protected static string $resource = RequestForQuotationsResource::class;
    public $rfqDetailsSum=0;
}

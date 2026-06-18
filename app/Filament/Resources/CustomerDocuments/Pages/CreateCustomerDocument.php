<?php

namespace App\Filament\Resources\CustomerDocuments\Pages;

use App\Filament\Resources\CustomerDocuments\CustomerDocumentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCustomerDocument extends CreateRecord
{
    protected static string $resource = CustomerDocumentResource::class;
}

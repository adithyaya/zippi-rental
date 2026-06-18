<?php

namespace App\Filament\Resources\BikeModels\Pages;

use App\Filament\Resources\BikeModels\BikeModelResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBikeModel extends CreateRecord
{
    protected static string $resource = BikeModelResource::class;
}

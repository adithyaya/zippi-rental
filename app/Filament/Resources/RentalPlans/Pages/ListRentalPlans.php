<?php

namespace App\Filament\Resources\RentalPlans\Pages;

use App\Filament\Resources\RentalPlans\RentalPlanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRentalPlans extends ListRecords
{
    protected static string $resource = RentalPlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

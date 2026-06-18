<?php

namespace App\Filament\Resources\RentalPlans\Pages;

use App\Filament\Resources\RentalPlans\RentalPlanResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRentalPlan extends EditRecord
{
    protected static string $resource = RentalPlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

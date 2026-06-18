<?php

namespace App\Filament\Resources\RentalPlans;

use App\Filament\Resources\RentalPlans\Pages\CreateRentalPlan;
use App\Filament\Resources\RentalPlans\Pages\EditRentalPlan;
use App\Filament\Resources\RentalPlans\Pages\ListRentalPlans;
use App\Filament\Resources\RentalPlans\Schemas\RentalPlanForm;
use App\Filament\Resources\RentalPlans\Tables\RentalPlansTable;
use App\Models\RentalPlan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RentalPlanResource extends Resource
{
    protected static ?string $model = RentalPlan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return RentalPlanForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RentalPlansTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRentalPlans::route('/'),
            'create' => CreateRentalPlan::route('/create'),
            'edit' => EditRentalPlan::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources\BikeModels;

use App\Filament\Resources\BikeModels\Pages\CreateBikeModel;
use App\Filament\Resources\BikeModels\Pages\EditBikeModel;
use App\Filament\Resources\BikeModels\Pages\ListBikeModels;
use App\Filament\Resources\BikeModels\Schemas\BikeModelForm;
use App\Filament\Resources\BikeModels\Tables\BikeModelsTable;
use App\Models\BikeModel;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BikeModelResource extends Resource
{
    protected static ?string $model = BikeModel::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return BikeModelForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BikeModelsTable::configure($table);
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
            'index' => ListBikeModels::route('/'),
            'create' => CreateBikeModel::route('/create'),
            'edit' => EditBikeModel::route('/{record}/edit'),
        ];
    }
}

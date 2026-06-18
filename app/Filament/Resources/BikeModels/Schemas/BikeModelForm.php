<?php

namespace App\Filament\Resources\BikeModels\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class BikeModelForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('brand'),
                TextInput::make('type'),
                TextInput::make('hourly_rate')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('daily_rate')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}

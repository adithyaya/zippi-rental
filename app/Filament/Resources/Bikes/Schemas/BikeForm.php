<?php

namespace App\Filament\Resources\Bikes\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class BikeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('bike_model_id')
                    ->relationship('bikeModel', 'name')
                    ->required(),
                TextInput::make('bike_code')
                    ->required(),
                TextInput::make('registration_number')
                    ->required(),
                TextInput::make('imei'),
                TextInput::make('chassis_number'),
                TextInput::make('engine_number'),
                TextInput::make('color'),
                TextInput::make('current_odometer')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('battery_percentage')
                    ->numeric(),
                Select::make('status')
                    ->options([
            'available' => 'Available',
            'booked' => 'Booked',
            'rented' => 'Rented',
            'maintenance' => 'Maintenance',
            'inactive' => 'Inactive',
        ])
                    ->default('available')
                    ->required(),
                DatePicker::make('insurance_expiry'),
                DatePicker::make('pollution_expiry'),
                DatePicker::make('fitness_expiry'),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }
}

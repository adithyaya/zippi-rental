<?php

namespace App\Filament\Resources\MaintenanceRecords\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class MaintenanceRecordForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('bike_id')
    ->relationship('bike', 'bike_code')
    ->searchable()
    ->preload()
    ->required(),
                TextInput::make('maintenance_type')
                    ->required(),
                DatePicker::make('maintenance_date')
                    ->required(),
                TextInput::make('cost')
                    ->required()
                    ->numeric()
                    ->default(0.0)
                    ->prefix('$'),
                TextInput::make('odometer_reading')
                    ->numeric(),
                    Select::make('status')
    ->options([
        'scheduled' => 'Scheduled',
        'in_progress' => 'In Progress',
        'completed' => 'Completed',
        'cancelled' => 'Cancelled',
    ])
    ->default('scheduled')
    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                DatePicker::make('next_service_due'),
            ]);
    }
}

<?php

namespace App\Filament\Resources\Subscriptions\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SubscriptionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('customer_id')
                    ->label('Customer')
                    ->relationship('customer', 'name')
                    ->getOptionLabelFromRecordUsing(fn ($record) => trim($record->name . ($record->phone ? ' - ' . $record->phone : '')))
                    ->searchable(['name', 'phone'])
                    ->preload()
                    ->required(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('₹'),
                DatePicker::make('start_date')
                    ->required(),
                DatePicker::make('end_date')
                    ->required(),
                Select::make('status')
                    ->options(['active' => 'Active', 'expired' => 'Expired', 'cancelled' => 'Cancelled'])
                    ->default('active')
                    ->required(),
            ]);
    }
}

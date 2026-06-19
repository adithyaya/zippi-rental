<?php

namespace App\Filament\Resources\CustomerDocuments\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class CustomerDocumentForm
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
                    ->createOptionForm([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('phone')
                            ->tel()
                            ->maxLength(255),
                        Textarea::make('address')
                            ->columnSpanFull(),
                    ])
                    ->required(),
                Select::make('document_type')
                    ->options([
            'aadhaar' => 'Aadhaar',
            'driving_license' => 'Driving license',
            'passport' => 'Passport',
            'voter_id' => 'Voter id',
        ])
                    ->required(),
                TextInput::make('document_number')
                    ->required(),
                TextInput::make('document_file')
                    ->required(),
                Select::make('verification_status')
                    ->options(['pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected'])
                    ->default('pending')
                    ->required(),
                Textarea::make('remarks')
                    ->columnSpanFull(),
                DateTimePicker::make('verified_at'),
            ]);
    }
}

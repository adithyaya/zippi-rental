<?php

namespace App\Filament\Resources\CustomerDocuments\Schemas;

use App\Models\User;
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
                Select::make('user_id')
                    ->label('User')
                    ->options(User::pluck('name', 'id'))
                    ->searchable()
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

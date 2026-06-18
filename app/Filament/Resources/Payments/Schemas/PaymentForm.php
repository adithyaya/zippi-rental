<?php

namespace App\Filament\Resources\Payments\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PaymentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('booking_id')
                    ->required()
                    ->numeric(),
                TextInput::make('transaction_id'),
                TextInput::make('amount')
                    ->required()
                    ->numeric(),
                Select::make('payment_method')
                    ->options(['cash' => 'Cash', 'upi' => 'Upi', 'card' => 'Card', 'wallet' => 'Wallet'])
                    ->required(),
                Select::make('payment_type')
                    ->options(['rental' => 'Rental', 'deposit' => 'Deposit', 'refund' => 'Refund', 'penalty' => 'Penalty'])
                    ->required(),
                Select::make('status')
                    ->options(['pending' => 'Pending', 'success' => 'Success', 'failed' => 'Failed', 'refunded' => 'Refunded'])
                    ->required(),
                DateTimePicker::make('paid_at'),
            ]);
    }
}

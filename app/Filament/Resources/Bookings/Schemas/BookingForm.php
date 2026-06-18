<?php

namespace App\Filament\Resources\Bookings\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rule;

class BookingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
    ->relationship('user', 'name')
    ->required()
    ->rules([
        function () {
            return function (string $attribute, $value, \Closure $fail) {
                $hasActiveBooking = \App\Models\Booking::where('user_id', $value)
                    ->whereIn('status', ['pending', 'confirmed', 'active'])
                    ->exists();

                if ($hasActiveBooking) {
                    $fail('This customer already has an active booking.');
                }
            };
        },
    ])
    ->helperText('Customer must have approved KYC and no active booking.'),

    Select::make('bike_id')
    ->relationship(
        'bike',
        'bike_code',
        fn ($query, $record) => $record
            ? $query
            : $query->where('status', 'available')
    )
    ->getOptionLabelFromRecordUsing(fn ($record) => $record->bike_code)
    ->searchable()
    ->preload()
    ->required()
    ->helperText('Only available bikes can be selected for new bookings. Existing bookings show their assigned bike.'),

    Select::make('rental_plan_id')
    ->relationship('rentalPlan', 'name')
    ->required(),
                TextInput::make('booking_number')
                    ->required(),
                DateTimePicker::make('start_time')
                    ->required(),
                DateTimePicker::make('expected_end_time')
                    ->disabled()
                    ->dehydrated(false),
                DateTimePicker::make('actual_end_time')
    ->disabled()
    ->dehydrated(false),
                TextInput::make('start_odometer')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('end_odometer')
                    ->numeric(),
                TextInput::make('total_amount')
                    ->numeric()
                    ->prefix('₹')
                    ->disabled()
                    ->dehydrated(false),
                TextInput::make('security_deposit')
                    ->numeric()
                    ->prefix('₹')
                    ->disabled()
                    ->dehydrated(false),
                Select::make('status')
                    ->options([
                    'pending' => 'Pending',
                    'confirmed' => 'Confirmed',
                    'active' => 'Active',
                    'completed' => 'Completed',
                    'cancelled' => 'Cancelled',
                    ])
                    ->default('pending')
                    ->required(),
                Textarea::make('notes')
                    ->columnSpanFull(),
                TextInput::make('distance_travelled')
    ->numeric()
    ->disabled(),

TextInput::make('extra_km')
    ->numeric()
    ->disabled(),

TextInput::make('extra_km_fee')
    ->numeric()
    ->prefix('₹')
    ->disabled(),

TextInput::make('final_amount')
    ->numeric()
    ->prefix('₹')
    ->disabled(),

TextInput::make('refundable_deposit')
    ->numeric()
    ->prefix('₹')
    ->disabled(),
            ]);
    }

}

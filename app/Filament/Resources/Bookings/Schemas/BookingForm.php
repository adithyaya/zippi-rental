<?php

namespace App\Filament\Resources\Bookings\Schemas;

use App\Models\Bike;
use App\Models\Booking;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class BookingForm
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
    ->required()
    ->createOptionForm([
        TextInput::make('name')
            ->required()
            ->maxLength(255),
        TextInput::make('phone')
            ->tel()
            ->maxLength(255),
        TextInput::make('alternate_phone')
            ->tel()
            ->maxLength(255),
        Textarea::make('address')
            ->columnSpanFull(),
    ])
    ->rules([
        function () {
            return function (string $attribute, $value, \Closure $fail) {
                $hasActiveBooking = Booking::where('customer_id', $value)
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
    ->rules([
        function () {
            return function (string $attribute, $value, \Closure $fail) {
                $bike = Bike::find($value);

                if (! $bike) {
                    return;
                }

                if ($bike->status !== 'available') {
                    $fail('This bike is not available for a new booking.');
                }

                $hasActiveBooking = Booking::where('bike_id', $value)
                    ->whereIn('status', ['pending', 'confirmed', 'active'])
                    ->exists();

                if ($hasActiveBooking) {
                    $fail('This bike is already booked or rented.');
                }
            };
        },
    ])
    ->helperText('Only available bikes can be selected for new bookings. Existing bookings show their assigned bike.'),

    Select::make('rental_plan_id')
    ->relationship('rentalPlan', 'name')
    ->required(),
                TextInput::make('booking_number')
                    ->required()
                    ->unique(ignoreRecord: true),
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

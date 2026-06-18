<?php

namespace App\Filament\Resources\Bookings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BookingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('bike_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('rental_plan_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('booking_number')
                    ->searchable(),
                TextColumn::make('start_time')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('expected_end_time')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('actual_end_time')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('start_odometer')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('end_odometer')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('total_amount')
                    ->money('INR')
                    ->sortable(),
                TextColumn::make('security_deposit')
                    ->money('INR')
                    ->sortable(),
                TextColumn::make('status')
                    ->badge(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

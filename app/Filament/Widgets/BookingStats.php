<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BookingStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Bookings', Booking::count()),
            Stat::make('Pending', Booking::where('status', 'pending')->count()),
            Stat::make('Active', Booking::where('status', 'active')->count()),
            Stat::make('Completed', Booking::where('status', 'completed')->count()),
            Stat::make('Cancelled', Booking::where('status', 'cancelled')->count()),
        ];
    }
}
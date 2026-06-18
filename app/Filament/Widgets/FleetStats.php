<?php

namespace App\Filament\Widgets;

use App\Models\Bike;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class FleetStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Bikes', Bike::count()),
            Stat::make('Available Bikes', Bike::where('status', 'available')->count()),
            Stat::make('Booked Bikes', Bike::where('status', 'booked')->count()),
            Stat::make('Rented Bikes', Bike::where('status', 'rented')->count()),
            Stat::make('Maintenance Bikes', Bike::where('status', 'maintenance')->count()),
        ];
    }
}
<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class RevenueStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Revenue', '₹' . Booking::where('status', 'completed')->sum('final_amount')),
            Stat::make('Today Revenue', '₹' . Booking::whereDate('created_at', today())->sum('final_amount')),
            Stat::make('Deposits Held', '₹' . Booking::whereIn('status', ['confirmed', 'active'])->sum('security_deposit')),
            Stat::make('Refundable Deposits', '₹' . Booking::where('status', 'completed')->sum('refundable_deposit')),
        ];
    }
}
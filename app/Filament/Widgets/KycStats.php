<?php

namespace App\Filament\Widgets;

use App\Models\CustomerDocument;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class KycStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('KYC Pending', CustomerDocument::where('verification_status', 'pending')->count()),
            Stat::make('KYC Approved', CustomerDocument::where('verification_status', 'approved')->count()),
            Stat::make('KYC Rejected', CustomerDocument::where('verification_status', 'rejected')->count()),
        ];
    }
}
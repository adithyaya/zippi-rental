<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceRecord extends Model
{
    protected $fillable = [
        'bike_id',
        'maintenance_type',
        'maintenance_date',
        'cost',
        'odometer_reading',
        'description',
        'next_service_due',
        'status',
        'service_provider',
        'invoice_number',
    ];

    protected static function booted()
    {
        static::created(function ($maintenanceRecord) {
            $maintenanceRecord->bike?->update([
                'status' => 'maintenance',
            ]);
        });

        static::updated(function ($maintenanceRecord) {
            if ($maintenanceRecord->status === 'completed') {
                $maintenanceRecord->bike?->update([
                    'status' => 'available',
                ]);
            }
        });
    }

    public function bike()
    {
        return $this->belongsTo(Bike::class);
    }
}
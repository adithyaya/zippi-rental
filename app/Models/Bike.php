<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bike extends Model
{
    protected $fillable = [
        'bike_model_id',
        'bike_code',
        'registration_number',
        'imei',
        'chassis_number',
        'engine_number',
        'color',
        'current_odometer',
        'battery_percentage',
        'status',
        'insurance_expiry',
        'pollution_expiry',
        'fitness_expiry',
        'notes',
    ];

    public function bikeModel()
{
    return $this->belongsTo(BikeModel::class);
}

public function bookings()
{
    return $this->hasMany(Booking::class);
}

public function scopeAvailableForBooking($query)
{
    return $query
        ->where('status', 'available')
        ->whereDoesntHave('bookings', fn ($bookingQuery) => $bookingQuery
            ->whereIn('status', ['pending', 'confirmed', 'active']));
}
}

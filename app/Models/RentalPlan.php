<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentalPlan extends Model
{
    protected $fillable = [
        'name',
        'duration_type',
        'duration_value',
        'price',
        'security_deposit',
        'included_km',
        'extra_km_charge',
        'is_active',
        'description',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
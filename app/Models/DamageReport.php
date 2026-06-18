<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DamageReport extends Model
{
    protected $fillable = [
        'bike_id',
        'booking_id',
        'damage_type',
        'description',
        'estimated_cost',
        'status',
    ];

    public function bike()
    {
        return $this->belongsTo(Bike::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
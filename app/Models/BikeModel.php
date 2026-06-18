<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BikeModel extends Model
{
    protected $fillable = [
        'name',
        'brand',
        'type',
        'hourly_rate',
        'daily_rate',
        'is_active',
    ];

    public function bikes()
    {
        return $this->hasMany(Bike::class);
    }
}
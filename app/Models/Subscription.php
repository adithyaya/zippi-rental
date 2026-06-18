<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'plan_type',
        'price',
        'start_date',
        'end_date',
        'status',
        'rides_included',
        'free_minutes',
        'discount_percentage',
        'auto_renew',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
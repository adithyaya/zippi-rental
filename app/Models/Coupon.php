<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    //
    protected $fillable = [
        'code',
        'discount_type',
        'discount_value',
        'minimum_booking_amount',
        'maximum_discount',
        'usage_limit',
        'per_user_limit',
        'valid_from',
        'valid_until',
        'is_active',
    ];
}

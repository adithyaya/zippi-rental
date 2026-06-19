<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'alternate_phone',
        'email',
        'address',
        'date_of_birth',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
        ];
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function customerDocuments()
    {
        return $this->hasMany(CustomerDocument::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function hasApprovedKyc(): bool
    {
        return $this->customerDocuments()
            ->where('verification_status', 'approved')
            ->exists();
    }
}

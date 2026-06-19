<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\RentalPlan;
use Carbon\Carbon;

class Booking extends Model
{
    // Booking.php
    protected $fillable = [
        'customer_id',
        'bike_id',
        'rental_plan_id',
        'booking_number',
        'start_time',
        'expected_end_time',
        'actual_end_time',
        'start_odometer',
        'end_odometer',
        'total_amount',
        'security_deposit',
        'late_fee',
        'damage_fee',
        'pickup_location',
        'return_location',
        'status',
        'notes',
        'distance_travelled',
'extra_km',
'extra_km_fee',
'final_amount',
'refundable_deposit',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function bike()
    {
        return $this->belongsTo(Bike::class);
    }

    public function rentalPlan()
    {
        return $this->belongsTo(RentalPlan::class);
    }

public function payments()
{
    return $this->hasMany(Payment::class);
}

public function damageReports()
{
    return $this->hasMany(DamageReport::class);
}

    protected static function booted()
{
    static::saving(function ($booking) {

    if (! $booking->exists) {
    $customer = Customer::find($booking->customer_id);

    if (! $customer || ! $customer->hasApprovedKyc()) {
        throw \Illuminate\Validation\ValidationException::withMessages([
            'customer_id' => 'This customer cannot book until KYC is approved.',
        ]);
    }
}


    if (! $booking->exists) {
    $customerAlreadyHasActiveBooking = self::where('customer_id', $booking->customer_id)
        ->whereIn('status', ['pending', 'confirmed', 'active'])
        ->exists();

    if ($customerAlreadyHasActiveBooking) {
        throw \Illuminate\Validation\ValidationException::withMessages([
    'customer_id' => 'This customer already has an active booking.',
]);
    }
}


    if ($booking->status === 'completed' && ! $booking->actual_end_time) {
    $booking->actual_end_time = now();
        }

        if (! $booking->exists) {
    $bikeAlreadyBooked = self::where('bike_id', $booking->bike_id)
        ->whereIn('status', ['pending', 'confirmed', 'active'])
        ->exists();

    if ($bikeAlreadyBooked) {
        throw \Filament\Support\Exceptions\Halt::make([
            'bike_id' => 'This bike is already booked or rented.',
        ]);
    }
}


        if ($booking->rental_plan_id && $booking->start_time) {
            $plan = RentalPlan::find($booking->rental_plan_id);

            if ($plan) {
                $start = Carbon::parse($booking->start_time);

                if ($plan->duration_type === 'hourly') {
                    $booking->expected_end_time = $start->copy()->addHours($plan->duration_value);
                }

                if ($plan->duration_type === 'daily') {
                    $booking->expected_end_time = $start->copy()->addDays($plan->duration_value);
                }

                if ($plan->duration_type === 'weekly') {
                    $booking->expected_end_time = $start->copy()->addWeeks($plan->duration_value);
                }

                if ($plan->duration_type === 'monthly') {
                    $booking->expected_end_time = $start->copy()->addMonths($plan->duration_value);
                }

                $booking->total_amount = $plan->price;
                $booking->security_deposit = $plan->security_deposit;
            }
        }

        if ($booking->status === 'completed') {
    if (! $booking->actual_end_time) {
        $booking->actual_end_time = now();
    }

    if ($booking->end_odometer && $booking->start_odometer) {
        $booking->distance_travelled = max(
            0,
            $booking->end_odometer - $booking->start_odometer
        );
    }
    

    $plan = RentalPlan::find($booking->rental_plan_id);

    if ($plan) {
        $includedKm = $plan->included_km ?? 0;

        $booking->extra_km = max(
            0,
            $booking->distance_travelled - $includedKm
        );

        $booking->extra_km_fee = $booking->extra_km * $plan->extra_km_charge;

        $booking->damage_fee = $booking->damageReports()
    ->whereIn('status', ['reported', 'under_review'])
    ->sum('estimated_cost');

        $booking->final_amount =
            $booking->total_amount
            + $booking->extra_km_fee
            + $booking->late_fee
            + $booking->damage_fee;

        $booking->refundable_deposit = max(
            0,
            $booking->security_deposit
            - $booking->extra_km_fee
            - $booking->late_fee
            - $booking->damage_fee
        );
    }
}
    });

    static::created(function ($booking) {
        if ($booking->bike) {
            $booking->bike->update([
                'status' => 'booked',
            ]);
        }

        $booking->payments()->create([
    'payment_reference' => 'PAY-' . now()->format('YmdHis') . '-' . random_int(100, 999),
    'transaction_id' => null,
    'amount' => $booking->total_amount,
    'payment_method' => 'cash',
    'payment_type' => 'rental',
    'status' => 'pending',
]);

$booking->payments()->create([
    'payment_reference' => 'PAY-' . now()->format('YmdHis') . '-' . random_int(100, 999),
    'transaction_id' => null,
    'amount' => $booking->security_deposit,
    'payment_method' => 'cash',
    'payment_type' => 'deposit',
    'status' => 'pending',
]);
    });

    static::updated(function ($booking) {
    if (! $booking->bike) {
        return;
    }

    if ($booking->status === 'active') {
        $booking->bike->update(['status' => 'rented']);
    }

     if (in_array($booking->status, ['completed', 'cancelled'])) {
            $booking->bike->update(['status' => 'available']);
        }
    });
}

}

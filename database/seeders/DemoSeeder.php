<?php

namespace Database\Seeders;

use App\Models\Bike;
use App\Models\BikeModel;
use App\Models\Booking;
use App\Models\Coupon;
use App\Models\CustomerDocument;
use App\Models\MaintenanceRecord;
use App\Models\RentalPlan;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // ── 1. CUSTOMERS ─────────────────────────────────────────────────────────
        $customers = [
            ['name' => 'Ravi Kumar',   'email' => 'ravi@demo.com'],
            ['name' => 'Priya Sharma', 'email' => 'priya@demo.com'],
            ['name' => 'Arjun Nair',   'email' => 'arjun@demo.com'],
            ['name' => 'Sneha Patel',  'email' => 'sneha@demo.com'],
        ];

        $userIds = [];
        foreach ($customers as $c) {
            $user = User::firstOrCreate(['email' => $c['email']], [
                'name'              => $c['name'],
                'password'          => bcrypt('Demo@1234'),
                'email_verified_at' => now(),
            ]);
            $userIds[$c['email']] = $user->id;
        }

        // ── 2. KYC DOCUMENTS (approved for all customers) ────────────────────────
        $docs = [
            ['email' => 'ravi@demo.com',   'type' => 'aadhaar',         'number' => 'ADHR-4521-8832'],
            ['email' => 'priya@demo.com',  'type' => 'driving_license', 'number' => 'DL-KA-2023-88321'],
            ['email' => 'arjun@demo.com',  'type' => 'passport',        'number' => 'P4521883K'],
            ['email' => 'sneha@demo.com',  'type' => 'voter_id',        'number' => 'VTR-KA-5521'],
        ];

        foreach ($docs as $d) {
            CustomerDocument::firstOrCreate(
                ['user_id' => $userIds[$d['email']], 'document_type' => $d['type']],
                [
                    'document_number'     => $d['number'],
                    'document_file'       => 'kyc/' . $d['number'] . '.pdf',
                    'verification_status' => 'approved',
                    'verified_at'         => now()->subDays(3),
                ]
            );
        }

        // ── 3. BIKE MODELS ───────────────────────────────────────────────────────
        $models = [
            ['name' => 'Ather 450X',      'brand' => 'Ather',  'type' => 'scooter', 'hourly_rate' => 80,  'daily_rate' => 600,  'is_active' => true],
            ['name' => 'Ola S1 Pro',       'brand' => 'Ola',    'type' => 'scooter', 'hourly_rate' => 75,  'daily_rate' => 550,  'is_active' => true],
            ['name' => 'Bounce Infinity',  'brand' => 'Bounce', 'type' => 'scooter', 'hourly_rate' => 60,  'daily_rate' => 450,  'is_active' => true],
        ];

        foreach ($models as $m) {
            BikeModel::firstOrCreate(['name' => $m['name']], $m);
        }

        $atherModelId  = BikeModel::where('name', 'Ather 450X')->value('id');
        $olaModelId    = BikeModel::where('name', 'Ola S1 Pro')->value('id');
        $bounceModelId = BikeModel::where('name', 'Bounce Infinity')->value('id');

        // ── 4. BIKES ─────────────────────────────────────────────────────────────
        $bikes = [
            ['bike_model_id' => $atherModelId,  'bike_code' => 'ATH-001', 'registration_number' => 'KA01AB1234', 'status' => 'available',    'current_odometer' => 3200, 'battery_percentage' => 95,  'color' => 'Grey'],
            ['bike_model_id' => $atherModelId,  'bike_code' => 'ATH-002', 'registration_number' => 'KA01AB1235', 'status' => 'booked',        'current_odometer' => 1800, 'battery_percentage' => 88,  'color' => 'White'],
            ['bike_model_id' => $olaModelId,    'bike_code' => 'OLA-001', 'registration_number' => 'KA01CD5678', 'status' => 'rented',        'current_odometer' => 4200, 'battery_percentage' => 72,  'color' => 'Black'],
            ['bike_model_id' => $bounceModelId, 'bike_code' => 'BNC-001', 'registration_number' => 'KA01EF9012', 'status' => 'available',     'current_odometer' => 500,  'battery_percentage' => 100, 'color' => 'Blue'],
            ['bike_model_id' => $bounceModelId, 'bike_code' => 'BNC-002', 'registration_number' => 'KA01EF9013', 'status' => 'maintenance',   'current_odometer' => 6100, 'battery_percentage' => 60,  'color' => 'Red'],
        ];

        foreach ($bikes as $b) {
            Bike::firstOrCreate(['bike_code' => $b['bike_code']], $b);
        }

        $ath001 = Bike::where('bike_code', 'ATH-001')->value('id');
        $ath002 = Bike::where('bike_code', 'ATH-002')->value('id');
        $ola001 = Bike::where('bike_code', 'OLA-001')->value('id');
        $bnc002 = Bike::where('bike_code', 'BNC-002')->value('id');

        // ── 5. RENTAL PLANS ──────────────────────────────────────────────────────
        $plans = [
            ['name' => 'Hourly',   'duration_type' => 'hourly',   'duration_value' => 1,  'price' => 80,    'security_deposit' => 500,  'included_km' => 15,   'extra_km_charge' => 5, 'is_active' => true, 'description' => 'Perfect for quick errands'],
            ['name' => 'Half Day', 'duration_type' => 'hourly',   'duration_value' => 6,  'price' => 350,   'security_deposit' => 1000, 'included_km' => 60,   'extra_km_charge' => 5, 'is_active' => true, 'description' => 'Great for half day outings'],
            ['name' => 'Full Day', 'duration_type' => 'daily',    'duration_value' => 1,  'price' => 600,   'security_deposit' => 1500, 'included_km' => 120,  'extra_km_charge' => 5, 'is_active' => true, 'description' => 'Explore the city all day'],
            ['name' => 'Weekly',   'duration_type' => 'weekly',   'duration_value' => 7,  'price' => 3500,  'security_deposit' => 3000, 'included_km' => 700,  'extra_km_charge' => 4, 'is_active' => true, 'description' => 'Best value for week-long travel'],
            ['name' => 'Monthly',  'duration_type' => 'monthly',  'duration_value' => 30, 'price' => 12000, 'security_deposit' => 5000, 'included_km' => 2000, 'extra_km_charge' => 3, 'is_active' => true, 'description' => 'Monthly commuter plan'],
        ];

        foreach ($plans as $p) {
            RentalPlan::firstOrCreate(['name' => $p['name']], $p);
        }

        $fullDayPlanId = RentalPlan::where('name', 'Full Day')->value('id');
        $halfDayPlanId = RentalPlan::where('name', 'Half Day')->value('id');
        $weeklyPlanId  = RentalPlan::where('name', 'Weekly')->value('id');

        // ── 6. BOOKINGS + PAYMENTS (bypassing model events for demo data) ────────
        $now = now();

        // Completed booking — Ravi, ATH-001, Full Day (2 days ago)
        if (!Booking::where('booking_number', 'BK-2026-0001')->exists()) {
            $booking1Id = DB::table('bookings')->insertGetId([
                'user_id'          => $userIds['ravi@demo.com'],
                'bike_id'          => $ath001,
                'rental_plan_id'   => $fullDayPlanId,
                'booking_number'   => 'BK-2026-0001',
                'start_time'       => $now->copy()->subDays(2)->setTime(9, 0),
                'expected_end_time'=> $now->copy()->subDays(1)->setTime(9, 0),
                'actual_end_time'  => $now->copy()->subDays(1)->setTime(10, 30),
                'start_odometer'   => 3080,
                'end_odometer'     => 3200,
                'distance_travelled'=> 120,
                'total_amount'     => 600,
                'security_deposit' => 1500,
                'extra_km'         => 0,
                'extra_km_fee'     => 0,
                'final_amount'     => 600,
                'refundable_deposit'=> 1500,
                'status'           => 'completed',
                'notes'            => 'Smooth ride, customer satisfied.',
                'created_at'       => $now->copy()->subDays(2),
                'updated_at'       => $now->copy()->subDays(1),
            ]);
            DB::table('payments')->insert([
                ['booking_id' => $booking1Id, 'payment_reference' => 'PAY-2026-0001', 'amount' => 600,  'payment_method' => 'upi',  'payment_type' => 'rental',  'status' => 'paid', 'created_at' => $now->copy()->subDays(2), 'updated_at' => $now->copy()->subDays(2)],
                ['booking_id' => $booking1Id, 'payment_reference' => 'PAY-2026-0002', 'amount' => 1500, 'payment_method' => 'cash', 'payment_type' => 'deposit', 'status' => 'refunded', 'created_at' => $now->copy()->subDays(2), 'updated_at' => $now->copy()->subDays(1)],
            ]);
        }

        // Active booking — Priya, OLA-001, Half Day (started today)
        if (!Booking::where('booking_number', 'BK-2026-0002')->exists()) {
            $booking2Id = DB::table('bookings')->insertGetId([
                'user_id'          => $userIds['priya@demo.com'],
                'bike_id'          => $ola001,
                'rental_plan_id'   => $halfDayPlanId,
                'booking_number'   => 'BK-2026-0002',
                'start_time'       => $now->copy()->setTime(10, 0),
                'expected_end_time'=> $now->copy()->setTime(16, 0),
                'actual_end_time'  => null,
                'start_odometer'   => 4200,
                'end_odometer'     => null,
                'total_amount'     => 350,
                'security_deposit' => 1000,
                'status'           => 'active',
                'notes'            => 'Customer picked up bike at 10am.',
                'created_at'       => $now->copy()->subHours(2),
                'updated_at'       => $now->copy()->subHours(2),
            ]);
            DB::table('payments')->insert([
                ['booking_id' => $booking2Id, 'payment_reference' => 'PAY-2026-0003', 'amount' => 350,  'payment_method' => 'upi',  'payment_type' => 'rental',  'status' => 'paid',    'created_at' => $now, 'updated_at' => $now],
                ['booking_id' => $booking2Id, 'payment_reference' => 'PAY-2026-0004', 'amount' => 1000, 'payment_method' => 'cash', 'payment_type' => 'deposit', 'status' => 'pending', 'created_at' => $now, 'updated_at' => $now],
            ]);
        }

        // Pending booking — Arjun, ATH-002, Weekly (starts tomorrow)
        if (!Booking::where('booking_number', 'BK-2026-0003')->exists()) {
            $booking3Id = DB::table('bookings')->insertGetId([
                'user_id'          => $userIds['arjun@demo.com'],
                'bike_id'          => $ath002,
                'rental_plan_id'   => $weeklyPlanId,
                'booking_number'   => 'BK-2026-0003',
                'start_time'       => $now->copy()->addDay()->setTime(9, 0),
                'expected_end_time'=> $now->copy()->addDays(8)->setTime(9, 0),
                'actual_end_time'  => null,
                'start_odometer'   => 1800,
                'total_amount'     => 3500,
                'security_deposit' => 3000,
                'status'           => 'pending',
                'notes'            => 'Customer confirmed via phone.',
                'created_at'       => $now,
                'updated_at'       => $now,
            ]);
            DB::table('payments')->insert([
                ['booking_id' => $booking3Id, 'payment_reference' => 'PAY-2026-0005', 'amount' => 3500, 'payment_method' => 'card', 'payment_type' => 'rental',  'status' => 'pending', 'created_at' => $now, 'updated_at' => $now],
                ['booking_id' => $booking3Id, 'payment_reference' => 'PAY-2026-0006', 'amount' => 3000, 'payment_method' => 'cash', 'payment_type' => 'deposit', 'status' => 'pending', 'created_at' => $now, 'updated_at' => $now],
            ]);
        }

        // ── 7. MAINTENANCE RECORDS ───────────────────────────────────────────────
        MaintenanceRecord::firstOrCreate(['invoice_number' => 'INV-MNT-001'], [
            'bike_id'          => $bnc002,
            'maintenance_type' => 'battery_service',
            'maintenance_date' => now()->subDays(1),
            'cost'             => 2500,
            'odometer_reading' => 6100,
            'description'      => 'Full battery diagnostic and cell replacement',
            'next_service_due' => now()->addMonths(3),
            'status'           => 'in_progress',
            'service_provider' => 'EV Care Centre, Bangalore',
            'invoice_number'   => 'INV-MNT-001',
        ]);

        MaintenanceRecord::firstOrCreate(['invoice_number' => 'INV-MNT-000'], [
            'bike_id'          => $ath001,
            'maintenance_type' => 'regular_service',
            'maintenance_date' => now()->subDays(15),
            'cost'             => 800,
            'odometer_reading' => 3000,
            'description'      => 'Regular 3000km service — brakes, tyre pressure, general checkup',
            'next_service_due' => now()->addMonths(2),
            'status'           => 'completed',
            'service_provider' => 'Ather Service Center',
            'invoice_number'   => 'INV-MNT-000',
        ]);

        // ── 8. COUPONS ───────────────────────────────────────────────────────────
        $coupons = [
            ['code' => 'ZIPPI10',   'discount_type' => 'percentage', 'discount_value' => 10,  'minimum_booking_amount' => 200,  'maximum_discount' => 100,  'usage_limit' => 100, 'per_user_limit' => 1, 'valid_from' => now(),            'valid_until' => now()->addMonths(3), 'is_active' => true],
            ['code' => 'FLAT100',   'discount_type' => 'fixed',      'discount_value' => 100, 'minimum_booking_amount' => 500,  'maximum_discount' => 100,  'usage_limit' => 50,  'per_user_limit' => 1, 'valid_from' => now(),            'valid_until' => now()->addMonth(),  'is_active' => true],
            ['code' => 'WELCOME20', 'discount_type' => 'percentage', 'discount_value' => 20,  'minimum_booking_amount' => 300,  'maximum_discount' => 200,  'usage_limit' => 200, 'per_user_limit' => 1, 'valid_from' => now()->subMonth(), 'valid_until' => now()->addMonths(6), 'is_active' => true],
        ];

        foreach ($coupons as $c) {
            Coupon::firstOrCreate(['code' => $c['code']], $c);
        }

        // ── 9. SUBSCRIPTIONS ─────────────────────────────────────────────────────
        Subscription::firstOrCreate(
            ['user_id' => $userIds['priya@demo.com'], 'plan_type' => 'monthly'],
            [
                'name'                => 'Monthly Commuter',
                'plan_type'           => 'monthly',
                'price'               => 1999,
                'start_date'          => now()->startOfMonth(),
                'end_date'            => now()->endOfMonth(),
                'status'              => 'active',
                'rides_included'      => 30,
                'free_minutes'        => 60,
                'discount_percentage' => 10,
                'auto_renew'          => true,
            ]
        );

        Subscription::firstOrCreate(
            ['user_id' => $userIds['sneha@demo.com'], 'plan_type' => 'weekly'],
            [
                'name'                => 'Weekend Explorer',
                'plan_type'           => 'weekly',
                'price'               => 599,
                'start_date'          => now()->startOfWeek(),
                'end_date'            => now()->endOfWeek(),
                'status'              => 'active',
                'rides_included'      => 8,
                'free_minutes'        => 30,
                'discount_percentage' => 5,
                'auto_renew'          => false,
            ]
        );

        $this->command->info('✓ 4 customers with approved KYC');
        $this->command->info('✓ 3 bike models, 5 bikes');
        $this->command->info('✓ 5 rental plans');
        $this->command->info('✓ 3 bookings (completed, active, pending) + 6 payments');
        $this->command->info('✓ 2 maintenance records');
        $this->command->info('✓ 3 coupons');
        $this->command->info('✓ 2 subscriptions');
    }
}

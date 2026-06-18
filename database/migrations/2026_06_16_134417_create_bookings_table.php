<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {

    $table->id();

    $table->foreignId('user_id')
          ->constrained()
          ->cascadeOnDelete();

    $table->foreignId('bike_id')
          ->constrained()
          ->cascadeOnDelete();

    $table->foreignId('rental_plan_id')
          ->constrained()
          ->cascadeOnDelete();

    $table->string('booking_number')
          ->unique();

    $table->dateTime('start_time');

    $table->dateTime('expected_end_time');

    $table->dateTime('actual_end_time')
          ->nullable();

    $table->integer('start_odometer')
          ->default(0);

    $table->integer('end_odometer')
          ->nullable();

    $table->decimal('total_amount', 10, 2)
          ->default(0);

    $table->decimal('security_deposit', 10, 2)
          ->default(0);

$table->decimal('late_fee', 10, 2)
      ->default(0);

$table->decimal('damage_fee', 10, 2)
      ->default(0);

$table->string('pickup_location')
      ->nullable();

$table->string('return_location')
      ->nullable();

    $table->enum('status', [
        'pending',
        'confirmed',
        'active',
        'completed',
        'cancelled'
    ])->default('pending');

    $table->text('notes')
          ->nullable();

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};

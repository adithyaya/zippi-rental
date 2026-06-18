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
    Schema::create('bikes', function (Blueprint $table) {
        $table->id();

        $table->foreignId('bike_model_id')
              ->nullable()
              ->constrained()
              ->nullOnDelete();

        $table->string('bike_code')->unique(); // ZP001, ZP002

        $table->string('registration_number')->unique();

        $table->string('imei')->nullable(); // GPS tracker IMEI

        $table->string('chassis_number')->nullable();

        $table->string('engine_number')->nullable();

        $table->string('color')->nullable();

        $table->integer('current_odometer')->default(0);

        $table->integer('battery_percentage')->nullable();

        $table->enum('status', [
            'available',
            'booked',
            'rented',
            'maintenance',
            'inactive'
        ])->default('available');

        $table->date('insurance_expiry')->nullable();

        $table->date('pollution_expiry')->nullable();

        $table->date('fitness_expiry')->nullable();

        $table->text('notes')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bikes');
    }
};

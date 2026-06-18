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
        Schema::create('rental_plans', function (Blueprint $table) {
    $table->id();

    $table->string('name');

    $table->enum('duration_type', [
        'hourly',
        'daily',
        'weekly',
        'monthly'
    ]);

    $table->integer('duration_value');

    $table->decimal('price', 10, 2);

    $table->decimal('security_deposit', 10, 2)
          ->default(0);

    $table->integer('included_km')
          ->nullable();
    
    $table->integer('max_km_per_day')
          ->nullable();

    $table->integer('grace_period_minutes')
          ->default(15);

    $table->decimal('extra_km_charge', 10, 2)
          ->default(0);

    $table->boolean('is_active')
          ->default(true);

    $table->text('description')
          ->nullable();

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rental_plans');
    }
};

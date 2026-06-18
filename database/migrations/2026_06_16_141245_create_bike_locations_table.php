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
        Schema::create('bike_locations', function (Blueprint $table) {
    $table->id();

    $table->foreignId('bike_id')
          ->constrained()
          ->cascadeOnDelete();

    $table->decimal('latitude', 10, 7);

    $table->decimal('longitude', 10, 7);

    $table->integer('battery_percentage')
          ->nullable();

    $table->timestamp('reported_at');

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bike_locations');
    }
};

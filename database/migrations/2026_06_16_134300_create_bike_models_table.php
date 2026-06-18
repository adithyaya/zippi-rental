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
        Schema::create('bike_models', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('brand')->nullable();
    $table->string('type')->nullable();
    $table->decimal('hourly_rate', 10, 2)->default(0);
    $table->decimal('daily_rate', 10, 2)->default(0);
    $table->boolean('is_active')->default(true);
    $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bike_models');
    }
};

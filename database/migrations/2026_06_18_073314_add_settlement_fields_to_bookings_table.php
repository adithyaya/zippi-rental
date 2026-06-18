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
        Schema::table('bookings', function (Blueprint $table) {
    $table->integer('distance_travelled')->default(0);
    $table->integer('extra_km')->default(0);
    $table->decimal('extra_km_fee', 10, 2)->default(0);
    $table->decimal('final_amount', 10, 2)->default(0);
    $table->decimal('refundable_deposit', 10, 2)->default(0);
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            //
        });
    }
};

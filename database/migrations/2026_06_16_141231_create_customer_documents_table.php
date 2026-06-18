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
        Schema::create('customer_documents', function (Blueprint $table) {
    $table->id();

    $table->foreignId('user_id')
          ->constrained()
          ->cascadeOnDelete();

    $table->enum('document_type', [
        'aadhaar',
        'driving_license',
        'passport',
        'voter_id'
    ]);

    $table->string('document_number');

    $table->string('document_file');

    $table->enum('verification_status', [
        'pending',
        'approved',
        'rejected'
    ])->default('pending');

    $table->text('remarks')->nullable();

    $table->timestamp('verified_at')->nullable();

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_documents');
    }
};

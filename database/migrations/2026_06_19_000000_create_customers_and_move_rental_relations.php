<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->nullable()->unique();
            $table->string('alternate_phone')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('status', ['active', 'inactive', 'blocked'])->default('active');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        foreach (DB::table('users')->select('id', 'name', 'email', 'created_at', 'updated_at')->get() as $user) {
            DB::table('customers')->insert([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'status' => 'active',
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
            ]);
        }

        $this->moveRelationToCustomers('bookings');
        $this->moveRelationToCustomers('customer_documents');
        $this->moveRelationToCustomers('subscriptions');
    }

    public function down(): void
    {
        $this->moveRelationToUsers('subscriptions');
        $this->moveRelationToUsers('customer_documents');
        $this->moveRelationToUsers('bookings');

        Schema::dropIfExists('customers');
    }

    private function moveRelationToCustomers(string $tableName): void
    {
        if (! Schema::hasColumn($tableName, 'user_id')) {
            return;
        }

        Schema::table($tableName, function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::table($tableName, function (Blueprint $table) {
            $table->renameColumn('user_id', 'customer_id');
        });

        Schema::table($tableName, function (Blueprint $table) {
            $table->foreign('customer_id')->references('id')->on('customers')->cascadeOnDelete();
        });
    }

    private function moveRelationToUsers(string $tableName): void
    {
        if (! Schema::hasColumn($tableName, 'customer_id')) {
            return;
        }

        Schema::table($tableName, function (Blueprint $table) {
            $table->dropForeign(['customer_id']);
        });

        Schema::table($tableName, function (Blueprint $table) {
            $table->renameColumn('customer_id', 'user_id');
        });

        Schema::table($tableName, function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }
};

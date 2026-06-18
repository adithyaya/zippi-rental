<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('ADMIN_EMAIL');
        $password = env('ADMIN_PASSWORD');

        if (!$email || !$password) {
            $this->command->error('ADMIN_EMAIL and ADMIN_PASSWORD environment variables are required.');
            return;
        }

        if (User::where('email', $email)->exists()) {
            $this->command->info('Admin user already exists. Skipping.');
            return;
        }

        User::create([
            'name'     => 'Admin',
            'email'    => $email,
            'password' => bcrypt($password),
            'email_verified_at' => now(),
        ]);

        $this->command->info('Admin user created: ' . $email);
    }
}

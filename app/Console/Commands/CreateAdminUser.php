<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreateAdminUser extends Command
{
    protected $signature = 'admin:create {email} {password}';
    protected $description = 'Create an admin user';

    public function handle(): void
    {
        $email    = $this->argument('email');
        $password = $this->argument('password');

        if (User::where('email', $email)->exists()) {
            $this->info('User already exists: ' . $email);
            return;
        }

        User::create([
            'name'              => 'Admin',
            'email'             => $email,
            'password'          => bcrypt($password),
            'email_verified_at' => now(),
        ]);

        $this->info('Admin user created: ' . $email);
    }
}

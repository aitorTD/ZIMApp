<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-admin-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new admin user with the specified nickname';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Check if user already exists
        if (\App\Models\User::where('nickname', 'aitor')->exists()) {
            $this->error('A user with the nickname "aitor" already exists!');
            return 1;
        }

        // Create the user
        $user = new \App\Models\User();
        $user->first_name = 'Aitor';
        $user->last_name = 'Admin';  // Added required last_name field
        $user->nickname = 'aitor';
        $user->email = 'aitor@example.com';
        $user->password = \Illuminate\Support\Facades\Hash::make('password');
        $user->save();

        // Assign admin role
        $user->assignRole('admin');

        $this->info('Admin user created successfully!');
        $this->line('Email: aitor@example.com');
        $this->line('Password: password');
        $this->newLine();
        $this->warn('Please change the password after first login!');
    }
}

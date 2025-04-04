<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:admin {name?} {email?} {password?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new admin user';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name') ?? $this->ask('Enter admin username');
        $email = $this->argument('email') ?? $this->ask('Enter admin email');
        $password = $this->argument('password') ?? $this->secret('Enter admin password');

        // Kullanıcı tipi ve durumu belirtelim
        $user_type = 'admin';
        $status = true;
        $full_name = $this->ask('Enter admin full name');

        // Kullanıcı oluşturma işlemini deneyelim
        try {
            User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'user_type' => $user_type,
                'status' => $status,
                'full_name' => $full_name,
            ]);
            
            $this->info('Admin user created successfully!');
            
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Error creating admin user: ' . $e->getMessage());
            
            return Command::FAILURE;
        }
    }
}

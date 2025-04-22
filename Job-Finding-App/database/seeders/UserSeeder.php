<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'username' => 'admin',
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'phone'=>'0700000000',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin12345'),
        ]);

        User::create([
            'username' => 'user',
            'first_name' => 'User',
            'last_name' => 'User',
            'phone'=>'9770000000',
            'email' => 'user@gmail.com',
            'password' => bcrypt('user12345'),
        ]);

        User::create([
            'username' => 'employee',
            'first_name' => 'Employee',
            'last_name' => 'Employee',
            'phone'=>'9888000000',
            'email' => 'employee@gmail.com',
            'password' => bcrypt('employee12345'),
        ]);
    }
}

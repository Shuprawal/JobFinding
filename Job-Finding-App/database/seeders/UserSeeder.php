<?php

namespace Database\Seeders;

use App\Models\Role;
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
        if (User::count() ===0){
            $roleAdmin= Role::where('name', 'Admin')->first();
            $roleUser= Role::where('name', 'User')->first();
//        $roleEmployee= Role::where('name', 'Employee')->first();

            User::create([
                'username' => 'admin',
                'first_name' => 'Admin',
                'last_name' => 'Admin',
                'phone'=>'0700000000',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('admin12345'),
                'role_id'=>$roleAdmin->id,
            ]);

            User::create([
                'username' => 'user',
                'first_name' => 'User',
                'last_name' => 'User',
                'phone'=>'9770000000',
                'email' => 'user@gmail.com',
                'password' => bcrypt('user12345'),
                'role_id'=>$roleUser->id,
            ]);
        }



    }
}

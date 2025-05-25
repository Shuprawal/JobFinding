<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Role::count()===0){
            $roleName=['Admin', 'User','Company'];
            foreach ($roleName as $role) {
                $roles[$role] = Role::create(['name' => $role]);
            }

        }




    }
}

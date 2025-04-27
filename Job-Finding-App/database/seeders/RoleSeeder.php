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
        $roleName=['Admin', 'User','Employee'];
        foreach ($roleName as $role) {
           $roles[$role] = Role::create(['name' => $role]);
        }

    }
}

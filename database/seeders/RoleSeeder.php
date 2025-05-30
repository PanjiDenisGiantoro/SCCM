<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Role::create([
            'name' => 'super_admin',
            'guard_name' => 'web'
        ]);

        Role::create([
            'name' => 'admin',
            'guard_name' => 'web'
        ]);
        Role::create([
            'name' => 'manager',
            'guard_name' => 'web'
        ]);
        Role::create([
            'name' => 'supervisor',
            'guard_name' => 'web'
        ]);
        Role::create([
            'name' => 'technician',
            'guard_name' => 'web'
        ]);
        Role::create([
            'name' => 'operator',
            'guard_name' => 'web'
        ]);
    }
}

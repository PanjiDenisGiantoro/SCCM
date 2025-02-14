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
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.id',
            'password' => bcrypt('12345678'),
        ]);

        $admin->assignRole('admin');

        $spv = User::create([
            'name' => 'SuperVisor',
            'email' => 'spv@spv.id',
            'password' => bcrypt('12345678'),
        ]);

        $spv->assignRole('supervisor');

        $superadmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@superadmin.id',
            'password' => bcrypt('12345678'),
        ]);

        $superadmin->assignRole('super_admin');

        $operator = User::create([
            'name' => 'Operator',
            'email' => 'operator@operator.id',
            'password' => bcrypt('12345678'),
        ]);

        $operator->assignRole('operator');

        $technician = User::create([
            'name' => 'Technician',
            'email' => 'technician@technician.id',
            'password' => bcrypt('12345678'),
        ]);

        $technician->assignRole('technician');

        $manager = User::create([
            'name' => 'Manager',
            'email' => 'manager@manager.id',
            'password' => bcrypt('12345678'),
        ]);

        $manager->assignRole('manager');
    }
}

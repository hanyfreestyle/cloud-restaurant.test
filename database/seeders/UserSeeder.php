<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        $adminUser = User::create([
            'id' => Uuid::uuid4()->toString(),
            'name' => 'Admin User',
            'email' => 'hany.freestyle4u@gmail.com',
            'password' => Hash::make('hany.freestyle4u@gmail.com'),
        ]);
        $adminUser->assignRole('admin');

        // Create Manager User
        $managerUser = User::create([
            'id' => Uuid::uuid4()->toString(),
            'name' => 'Restaurant Manager',
            'email' => 'manager@demo.com',
            'password' => Hash::make('password'),
        ]);
        $managerUser->assignRole('manager');

        // Create Waiter User
        $waiterUser = User::create([
            'id' => Uuid::uuid4()->toString(),
            'name' => 'Waiter',
            'email' => 'waiter@demo.com',
            'password' => Hash::make('password'),
        ]);
        $waiterUser->assignRole('waiter');

        // Create Cashier User
        $cashierUser = User::create([
            'id' => Uuid::uuid4()->toString(),
            'name' => 'Cashier',
            'email' => 'cashier@demo.com',
            'password' => Hash::make('password'),
        ]);
        $cashierUser->assignRole('cashier');
    }
}

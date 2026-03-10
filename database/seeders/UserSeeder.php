<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'first_name' => 'Pán',
                'last_name' => 'Admin',
                'email' => 'admin@ukf.sk',
                'password' => Hash::make('123'),
                'role' => 'admin',
                'premium_until' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Dávid',
                'last_name' => 'Držík',
                'email' => 'ddrzik@ukf.sk',
                'password' => Hash::make('456'),
                'role' => 'user',
                'premium_until' => now()->addDays(30),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Jozef',
                'last_name' => 'Kapusta',
                'email' => 'jkapusta@ukf.sk',
                'password' => Hash::make('789'),
                'role' => 'user',
                'premium_until' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Lucia',
                'last_name' => 'Vysoká',
                'email' => 'lvysoka@ukf.sk',
                'password' => Hash::make('secret123'),
                'role' => 'user',
                'premium_until' => now()->addMonths(6),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Peter',
                'last_name' => 'Admin',
                'email' => 'padmin@ukf.sk',
                'password' => Hash::make('admin-pass-99'),
                'role' => 'admin',
                'premium_until' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Mária',
                'last_name' => 'Kováčová',
                'email' => 'mkovacova@ukf.sk',
                'password' => Hash::make('password'),
                'role' => 'user',
                'premium_until' => now()->subDays(1),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Michal',
                'last_name' => 'Novák',
                'email' => 'mnovak@ukf.sk',
                'password' => Hash::make('novak2024'),
                'role' => 'user',
                'premium_until' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Zuzana',
                'last_name' => 'Malá',
                'email' => 'zmala@ukf.sk',
                'password' => Hash::make('zuzka_pass'),
                'role' => 'user',
                'premium_until' => now()->addDays(7),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

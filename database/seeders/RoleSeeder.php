<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::updateOrCreate(
            ['email' => 'admin@shopind.com'],
            [
                'name' => 'Admin Shopind',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role' => 'admin',
            ]
        );

        \App\Models\User::updateOrCreate(
            ['email' => 'customer@shopind.com'],
            [
                'name' => 'Customer Shopind',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role' => 'customer',
            ]
        );
    }
}

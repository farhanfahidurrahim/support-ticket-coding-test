<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'role' => 'admin', 
            'name' => 'Admin',
            'email' => 'admin@gmail.com', 
            'password' => Hash::make('12345678'),
        ]);

        User::create([
            'role' => 'customer',
            'name' => 'Fahidur',
            'email' => 'fahidur@gmail.com',
            'password' => Hash::make('87654321'),
        ]);
    }
}

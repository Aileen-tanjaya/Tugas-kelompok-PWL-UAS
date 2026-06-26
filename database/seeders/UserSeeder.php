<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //admin
        User::updateOrCreate(
        ['email' => 'admin@gmail.com'],
        [
            'name' => 'Administrator',
            'password' => Hash::make('password1280'),
            'role' => 'admin',
        ]
        );
        
        //user biasa 
        User::updateOrCreate(
        ['email' => 'user@mail.com'],
        [
            'name' => 'User Biasa',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]
        );

        //dummy random
        User::factory()->count(5)->create([
            'role' => 'user',
        ]);
    }
}

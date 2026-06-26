<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Plan;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Plan::insert([
            [
                'name' => 'Basic',
                'price' => 50000,
                'duration_days' => 30,
                'description' => 'Akses kelas dasar selama 30 hari',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pro',
                'price' => 100000,
                'duration_days' => 30,
                'description' => 'Akses kelas premium selama 30 hari',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Business',
                'price' => 250000,
                'duration_days' => 90,
                'description' => 'Akses kelas bisnis selama 90 hari',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
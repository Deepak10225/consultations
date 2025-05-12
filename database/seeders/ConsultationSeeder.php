<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConsultationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          $user = \App\Models\Consultation::firstOrCreate(
    ['name' => 'test'],
    [
        'description' => 'test',
        'scheduled_at' => '2025-12-12',
    ]
);
    }
}

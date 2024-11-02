<?php

namespace Database\Seeders;

use App\Models\DefenseEnrollment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DefenseEnrollmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DefenseEnrollment::create([
            'id' => 1,
            'defense_request_id' => 1,
            'jury_group_id' => 1,
            'defense_date' => now()->addMonths(1),
            'status' => "Scheduled",
        ]);

        DefenseEnrollment::create([
            'id' => 2,
            'defense_request_id' => 2,
            'jury_group_id' => 2,
            'defense_date' => now()->addMonths(2),
            'status' => "Scheduled",
        ]);
    }
}

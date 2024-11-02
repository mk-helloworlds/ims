<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Internship;

class InternshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Internship::create([
            'internship_title' => 'CS Gen1 Internship1',
            'type' => 1,
            'period' => 4,
            'school' => 'CS',
            'generation' => 1,
            'description' => 'This is Computer Science Generation 1 Internship, period 4 months',
            'start_date' => now(),
            'end_date' => now(),
        ]);

        Internship::create([
            'internship_title' => 'TN Gen2 Internship2',
            'type' => 2,
            'period' => 6,
            'school' => 'TN',
            'generation' => 2,
            'description' => 'This is Telecom and Networking Generation 2 Internship, period 6 months',
            'start_date' => now(),
            'end_date' => now(),
        ]);

        Internship::create([
            'internship_title' => 'DB Gen3 Internship1',
            'type' => 1,
            'period' => 4,
            'school' => 'DB',
            'generation' => 3,
            'description' => 'This is Digital Business Generation 2 Internship, period 4 months',
            'start_date' => now(),
            'end_date' => now(),
        ]);

        Internship::create([
            'internship_title' => 'CS Gen4 Internship2',
            'type' => 2,
            'period' => 4,
            'school' => 'CS',
            'generation' => 4,
            'description' => 'This is Computer Science Generation 4 Internship, period 4 months',
            'start_date' => now(),
            'end_date' => now(),
        ]);
    }
}

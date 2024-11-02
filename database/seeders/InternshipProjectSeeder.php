<?php

namespace Database\Seeders;

use App\Models\InternshipProject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class InternshipProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        InternshipProject::create([
            'id' => 1,
            'student_request_id' => 1 ,
            'project_name' => 'AI Research Project' ,
            'description' => 'Research on AI algorithms',
            'start_date' => now(),
            'end_date' => now(),
        ]);
        InternshipProject::create([
            'id' => 2,
            'student_request_id' => 3,
            'project_name' => 'Machine Learning in Healthcare' ,
            'description' => 'Implementing ML in healthcare',
            'start_date' => now(),
            'end_date' => now(),
        ]);
        InternshipProject::create([
            'id' => 3,
            'student_request_id' => 5,
            'project_name' => 'Blockchain for Secure Transactions' ,
            'description' => 'Blockchain-based secure transactions',
            'start_date' => now(),
            'end_date' => now(),
        ]);
        InternshipProject::create([
            'id' => 4,
            'student_request_id' => 6,
            'project_name' => 'Hello Worldws Hello Worlds' ,
            'description' => 'Hello Worldws Hello Worlds',
            'start_date' => now(),
            'end_date' => now(),
        ]);
    }
}

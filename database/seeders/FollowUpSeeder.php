<?php

namespace Database\Seeders;

use App\Models\FollowUp;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FollowUpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FollowUp::create([
        'id' => 1,
        'student_request_id' => 1,
        'follow_up_date' => today(),
        'notes' => "HELLO WORLDS 1",
        'status' => "On Track" ,
        ]);

        FollowUp::create([
            'id' => 2,
            'student_request_id' => 3,
            'follow_up_date' => today(),
            'notes' => "HELLO WORLDS 2",
            'status' => "Behind Schedule" ,
        ]);

        FollowUp::create([
            'id' => 3,
            'student_request_id' => 5,
            'follow_up_date' => today(),
            'notes' => "HELLO WORLDS 3",
            'status' => "Completed" ,
        ]);

        FollowUp::create([
            'id' => 4,
            'student_request_id' => 6,
            'follow_up_date' => today(),
            'notes' => "HELLO WORLDS 4",
            'status' => "On Track" ,
        ]);
    }
}

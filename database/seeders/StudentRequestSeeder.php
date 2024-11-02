<?php

namespace Database\Seeders;

use App\Models\StudentRequest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seeding the student request
        StudentRequest::insert([
            'id' => 1,
            'internship_id' => 1,
            'student_id' => 1, 
            'advisor_id' => 2, 
            'status' => "Accepted",
        ]);

        StudentRequest::create([
            'id' => 2,
            'internship_id' => 1,
            'student_id' => 5, 
            'advisor_id' => 6, 
            'status' => "Pending",
        ]);

        DB::table('student_requests')->insert(
        [
            'id' => 3,
            'internship_id' => 2,
            'student_id' => 1, 
            'advisor_id' => 3, 
            'status' => "Accepted",
        ]);

        $student_request = [
            'id' => 4,
            'internship_id' => 2,
            'student_id' => 1, 
            'advisor_id' => 1, 
            'status' => "Rejected",
        ];

        DB::table('student_requests')->insert($student_request);

        DB::table('student_requests')->insert(
            [
                'id' => 5,
                'internship_id' => 1,
                'student_id' => 3, 
                'advisor_id' => 2, 
                'status' => "Accepted",
            ]);

        DB::table('student_requests')->insert(
            [
                'id' => 6,
                'internship_id' => 3,
                'student_id' => 5, 
                'advisor_id' => 6, 
                'status' => "Accepted",
            ]);
        
        DB::table('student_requests')->insert(
            [
                'id' => 7,
                'internship_id' => 3,
                'student_id' => 9, 
                'advisor_id' => 7, 
                'status' => "Accepted",
            ]);
    }
}

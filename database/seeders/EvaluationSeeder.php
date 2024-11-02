<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Evaluation;

class EvaluationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // STUDENT 1
        // JURY 1 - ID : 14
        // Question 1 - 4
        Evaluation::create([
            'user_student_id' => 1,
            'user_jury_id' => 14,
            'defense_enrollment_id' => 1,
            'question_id' => 1,
            'score' => 8,
            'feedback' => '1Great performance!',
            'note' => '1Needs improvement in Q&A',
        ]);
        Evaluation::create([
            'user_student_id' => 1,
            'user_jury_id' => 14,
            'defense_enrollment_id' => 1,
            'question_id' => 2,
            'score' => 8,
            'feedback' => '2Great performance!',
            'note' => '2Needs improvement in Q&A',
        ]);
        Evaluation::create([
            'user_student_id' => 1,
            'user_jury_id' => 14,
            'defense_enrollment_id' => 1,
            'question_id' => 3,
            'score' => 8,
            'feedback' => '3Great performance!',
            'note' => '3Needs improvement in Q&A',
        ]);
        Evaluation::create([
            'user_student_id' => 1,
            'user_jury_id' => 14,
            'defense_enrollment_id' => 1,
            'question_id' => 4,
            'score' => 8,
            'feedback' => '4Great performance!',
            'note' => '4Needs improvement in Q&A',
        ]);

        // STUDENT 1
        // JURY 2 - ID: 15
        // Question 1 - 4

        // In the system the 
        // if (!user_student_id == defense_enrollment_id.defense_request_id.thesis_submission_id.student_request_id.user_student_id){
            // the user_student_id is not eligable for defense
        // }

        Evaluation::create([
            'user_student_id' => 4,
            'user_jury_id' => 15,
            'defense_enrollment_id' => 2,
            'question_id' => 5,
            'score' => 8,
        ]);
        Evaluation::create([
            'user_student_id' => 1,
            'user_jury_id' => 14,
            'defense_enrollment_id' => 1,
            'question_id' => 6,
            'score' => 8,
        ]);
        Evaluation::create([
            'user_student_id' => 1,
            'user_jury_id' => 14,
            'defense_enrollment_id' => 1,
            'question_id' => 7,
            'score' => 8,
            'feedback' => '7Great performance!',
            'note' => '7Needs improvement in Q&A',
        ]);
        Evaluation::create([
            'user_student_id' => 1,
            'user_jury_id' => 14,
            'defense_enrollment_id' => 1,
            'question_id' => 8,
            'score' => 8,
            'feedback' => '8Great performance!',
            'note' => '8Needs improvement in Q&A',
        ]);

        // STUDENT 1
        // JURY 3 - ID: 16
        // Question 1 - 4

        // STUDENT 1
        // JURY 4 - ID: 17
        // Question 1 - 4

    }
}

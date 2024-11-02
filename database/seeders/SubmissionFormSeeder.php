<?php

namespace Database\Seeders;

use App\Models\SubmissionForm;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubmissionFormSeeder extends Seeder
{
    public function run(): void
    {
        SubmissionForm::create([
            'id' => 1,      
            'student_request_id' => 1,
            'company_id' => 1,
            'supervisor_name' => "1",
            'internship_agreement' => "1.pdf",
            'advisor_confirmation_letter' => "1.pdf" ,
            'internship_proposal' => "1.pdf",
        ]);

        SubmissionForm::create([
            'id' => 2,      
            'student_request_id' => 3,
            'company_id' => 2,
            'supervisor_name' => "2",
            'internship_agreement' => "2.pdf",
            'advisor_confirmation_letter' => "2.pdf" ,
            'internship_proposal' => "2.pdf",
        ]);

        SubmissionForm::create([
            'id' => 3,      
            'student_request_id' => 5,
            'company_id' => 3,
            'supervisor_name' => "3",
            'internship_agreement' => "3.pdf",
            'advisor_confirmation_letter' => "3.pdf" ,
            'internship_proposal' => "3.pdf",
        ]);

        SubmissionForm::create([
            'id' => 4,      
            'student_request_id' => 6,
            'company_id' => 4,
            'supervisor_name' => "4",
            'internship_agreement' => "4.pdf",
            'advisor_confirmation_letter' => "4.pdf" ,
            'internship_proposal' => "4.pdf",
        ]);
        
    }
}

<?php

namespace Database\Seeders;

use App\Models\DefenseEnrollment;
use App\Models\DefenseRequest;
use App\Models\Evaluation;
use App\Models\SubmissionForm;
use App\Models\ThesisDocument;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserRoleSeeder::class,
            UserSeeder::class,

            CategorySeeder::class,
            CompanySeeder::class,

            InternshipSeeder::class,

            StudentRequestSeeder::class,            
            InternshipProjectSeeder::class,

            SubmissionFormSeeder::class,
            FollowUpSeeder::class,

            ThesisDocumentSeeder::class,
            DefenseRequestSeeder::class,

            JuryGroupSeeder::class,
            DefenseEnrollmentSeeder::class,

            EvaluationQuestionSeeder::class,
            EvaluationSeeder::class,
            
            // InternshipStudentAdvisorSeeder::class,
            // UserRolePermissionSeeder::class,
            // CompanyCategoryRelationSeeder::class,
        ]);
    }
}

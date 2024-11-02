<?php

namespace Database\Seeders;

use App\Models\ThesisDocument;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ThesisDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ThesisDocument::create([
            'id' => 1,
            'student_request_id' => 1,
            'student_thesis' => "1.pdf",
            'status' => "accepted",
        ]);

        ThesisDocument::create([
            'id' => 2,
            'student_request_id' => 3,
            'student_thesis' => "2.pdf",
            'status' => "accepted",
        ]);

        ThesisDocument::create([
            'id' => 3,
            'student_request_id' => 5,
            'student_thesis' => "3.pdf",
            'status' => "accepted",
        ]);

        ThesisDocument::create([
            'id' => 4,
            'student_request_id' => 6,
            'student_thesis' => "4.pdf",
            'status' => "submitted",
        ]);

        ThesisDocument::create([
            'id' => 5,
            'student_request_id' => 7,
            'student_thesis' => "5.pdf",
            'status' => "rejected",
        ]);

    }
}

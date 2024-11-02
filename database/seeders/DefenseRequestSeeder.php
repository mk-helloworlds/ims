<?php

namespace Database\Seeders;

use App\Models\DefenseRequest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DefenseRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DefenseRequest::create([
        'id' => 1,
        'thesis_document_id' => 1,
        'status' => 'approved',
        'feedback' => 'The student is eligable for defense',
        ]);

        DefenseRequest::create([
        'id' => 2,
        'thesis_document_id' => 2,
        'status' => 'approved',
        'feedback' => 'The student is eligable for defense',
        ]);

        DefenseRequest::create([
        'id' => 3,
        'thesis_document_id' => 3,
        'status' => 'rejected',
        'feedback' => 'The student is not eligable for defense',
        ]);
    }
}

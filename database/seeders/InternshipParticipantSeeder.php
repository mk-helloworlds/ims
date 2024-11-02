<?php

namespace Database\Seeders;

use App\Models\InternshipParticipant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InternshipParticipantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        InternshipParticipant::create([
            'internship_id' => 1,
            'user_id' => 1,
        ]);
    
        InternshipParticipant::create([
            'internship_id' => 2,
            'user_id' => 2,
        ]);
    
        InternshipParticipant::create([
            'internship_id' => 3,
            'user_id' => 3,
        ]);
    
        InternshipParticipant::create([
            'internship_id' => 4,
            'user_id' => 4,
        ]);
    }
}

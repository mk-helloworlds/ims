<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JuryGroup;

class JuryGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JuryGroup::create([
            'id' => 1,
            'internship_id' => 1,
            'user_jury1_id' => 14,
            'user_jury2_id' => 15,
            'user_jury3_id' => 16,
            'user_jury4_id' => 17,
        ]);

        JuryGroup::create([
            'id' => 2,
            'internship_id' => 2,
            'user_jury1_id' => 17,
            'user_jury2_id' => 18,
            'user_jury3_id' => 19,
            'user_jury4_id' => 20,
        ]);

        JuryGroup::create([
            'id' => 3,
            'internship_id' => 3,
            'user_jury1_id' => 14,
            'user_jury2_id' => 15,
            'user_jury3_id' => 16,
            'user_jury4_id' => 17,
        ]);

        JuryGroup::create([
            'id' => 4,
            'internship_id' => 4,
            'user_jury1_id' => 17,
            'user_jury2_id' => 18,
            'user_jury3_id' => 19,
            'user_jury4_id' => 20,
        ]);

        JuryGroup::create([
            'id' => 5,
            'internship_id' => 1,
            'user_jury1_id' => 14,
            'user_jury2_id' => 15,
            'user_jury3_id' => 16,
            'user_jury4_id' => 17,
        ]);
    }
}

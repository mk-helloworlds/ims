<?php

namespace Database\Seeders;

use App\Models\EvaluationQuestion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EvaluationQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EvaluationQuestion::create([
            'id' => 1,
            'question_text' => 'How well was the topic presented?'
        ]);
        
        EvaluationQuestion::create([
            'id' => 2,
            'question_text' => 'Was the student\'s argumentation convincing?'
        ]);
        
        EvaluationQuestion::create([
            'id' => 3,
            'question_text' => 'How was the student\'s engagement during the Q&A session?'
        ]);
        
        EvaluationQuestion::create([
            'id' => 4,
            'question_text' => 'Did the student demonstrate thorough knowledge of the subject matter?'
        ]);
        
        EvaluationQuestion::create([
            'id' => 5,
            'question_text' => 'Was the presentation clear and well-structured?'
        ]);
        
        EvaluationQuestion::create([
            'id' => 6,
            'question_text' => 'How effective were the student’s communication skills?'
        ]);
        
        EvaluationQuestion::create([
            'id' => 7,
            'question_text' => 'Did the student maintain good time management during the presentation?'
        ]);
        
        EvaluationQuestion::create([
            'id' => 8,
            'question_text' => 'How well did the student handle the technical aspects of the project?'
        ]);
        
        EvaluationQuestion::create([
            'id' => 9,
            'question_text' => 'Was the student able to provide relevant solutions to problems raised?'
        ]);
        
        EvaluationQuestion::create([
            'id' => 10,
            'question_text' => 'How well did the student integrate feedback into the final project?'
        ]);
        
        EvaluationQuestion::create([
            'id' => 11,
            'question_text' => 'Did the student collaborate effectively with their advisor or team?'
        ]);
        
        EvaluationQuestion::create([
            'id' => 12,
            'question_text' => 'Was the student confident during the presentation?'
        ]);
        
        EvaluationQuestion::create([
            'id' => 13,
            'question_text' => 'How well did the student justify their design or research choices?'
        ]);
        
        EvaluationQuestion::create([
            'id' => 14,
            'question_text' => 'Did the student use data or evidence effectively to support their argument?'
        ]);
        
        EvaluationQuestion::create([
            'id' => 15,
            'question_text' => 'Was the student receptive to criticism and questions from the jury?'
        ]);
    }
}

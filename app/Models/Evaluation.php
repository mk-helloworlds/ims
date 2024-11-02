<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    protected $table = 'evaluations';

    protected $fillable = [
        'id',

        'user_student_id',
        'user_jury_id',
        'defense_enrollment_id',
        'question_id',

        'score',
        'feedback',
        'note',
    ]; 

    public function EvaluationQuestion()
    {
        return $this->belongsTo(EvaluationQuestion::class, "question_id" );
    }

    public function jury()
    {
        return $this->belongsTo(User::class);
    }

    public function defenseEnrollment()
    {
        return $this->belongsTo(DefenseEnrollment::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'user_student_id');
    }

}

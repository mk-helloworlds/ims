<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternshipAdvisorStudent extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'internship_id',
        'user_student_id',
        'user_advisor_id', 
    ];

    public function internship(){
        return $this->belongsTo(Internship::class, 'internship_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'user_student_id');
    }

    public function advisor()
    {
        return $this->belongsTo(User::class, 'user_advisor_id');
    }

    // Scope to get advisor's current student count for a specific internship
    public static function advisorStudentCount($advisorId, $internshipId)
    {
        return self::where('user_advisor_id', $advisorId)
                    ->where('internship_id', $internshipId)
                    ->count();
                    // Returning in numberical Format
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefenseEnrollment extends Model
{
    use HasFactory;

    protected $table = 'defense_enrollments';

    protected $fillable =[
        'id',
        'defense_request_id',
        'jury_group_id',
        'defense_date',
        'status',
    ];

    public function defenseRequest()
    {
        return $this->belongsTo(DefenseRequest::class);
    }
    
    public function juryGroup()
    {
        return $this->belongsTo(JuryGroup::class);
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class, 'defense_enrollment_id');
    }

    public function submissionForm()
    {
        return $this->hasOne(SubmissionForm::class, 'student_request_id');
    }

    public function internshipProject()
    {
        return $this->hasOne(InternshipProject::class, 'student_request_id');
    }

}

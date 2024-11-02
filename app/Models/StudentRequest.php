<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentRequest extends Model
{
    use HasFactory;

    protected $table = 'student_requests';

    protected $fillable = [
        'id',
        'internship_id',
        'student_id', 
        'advisor_id', 
        'status',
        'message',         
        'cv',                 
        'advisor_response_message',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function advisor()
    {
        return $this->belongsTo(User::class, 'advisor_id');
    }

    public function internship(){
        return $this->belongsTo(Internship::class, 'internship_id');
    }

    public function thesisDocuments()
    {
        return $this->hasMany(ThesisDocument::class, 'student_request_id');
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


<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThesisDocument extends Model
{
    use HasFactory;
    
    protected $table = 'thesis_documents';

    protected $fillable = [
        'id',
        'student_request_id',  
        'student_thesis',
        'status',
    ];

    // Relationship to Student
    public function student()
    {
        return $this->belongsTo(User::class, 'user_student_id');
    }

    // Relationship to Advisor
    public function advisor()
    {
        return $this->belongsTo(User::class, 'user_advisor_id');
    }

    // Relationship to Internship
    public function internship()
    {
        return $this->belongsTo(Internship::class, 'internship_id');
    } 

    // Relationship to Internship
    public function student_request()
    {
        return $this->belongsTo(StudentRequest::class, 'student_request_id');
    }

}

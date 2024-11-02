<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefenseRequest extends Model
{
    use HasFactory;

    protected $table = "defense_requests";

    protected $fillable = [
        'id',
        'thesis_document_id',
        'status',
        'feedback',
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

    public function thesisDocument()
    {
        return $this->belongsTo(ThesisDocument::class, 'thesis_document_id');
    }

}

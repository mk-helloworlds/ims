<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubmissionForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',      
        'student_request_id',
        'company_id',
        'supervisor_name',
        'internship_agreement',
        'advisor_confirmation_letter',
        'internship_proposal',
    ];
    
    public function student_request()
    {
        return $this->belongsTo(StudentRequest::class, 'student_request_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
    
}

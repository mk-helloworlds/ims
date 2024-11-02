<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternshipProject extends Model
{
    use HasFactory;

    protected $table = 'internship_projects';

    protected $fillable = [
        'id',
        'student_request_id',
        'project_name',
        'description',
        'start_date',
        'end_date',
    ];

    public function studentRequest() {
        return $this->belongsTo(StudentRequest::class, 'student_request_id');
    }
}

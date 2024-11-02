<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FollowUp extends Model
{
    use HasFactory;

    protected $table = 'follow_ups';

    protected $fillable = [
        'id',

        'student_request_id',  
      
        'follow_up_date',
        'notes',
        'status',
    ];

    public function studentRequest()
    {
        return $this->belongsTo(StudentRequest::class, 'student_request_id');
    }
}

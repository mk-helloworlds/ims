<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternshipStudentAdvisor extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'internship_id',
        'user_id',
        'user_role_id',
    ];
}

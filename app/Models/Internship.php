<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Internship extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'internship_title',
        'type',
        'period',
        'school',
        'generation',
        'description',
        'start_date',
        'end_date',
    ];

    public function projects(){
        return $this->hasMany(InternshipProject::class);
    }

    public function studentRequests()
    {
        return $this->hasMany(StudentRequest::class, 'internship_id');
    }
    
    public function participants()
    {
        return $this->belongsToMany(User::class, 'internship_participants')
                    ->withTimestamps();
    }

}

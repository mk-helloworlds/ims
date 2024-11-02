<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JuryGroup extends Model
{
    use HasFactory;

    protected $table = 'jury_groups';

    protected $fillable =[
        'id',
        'internship_id',
        'user_jury1_id',
        'user_jury2_id',
        'user_jury3_id',
        'user_jury4_id',
    ];

    public function jury1()
    {
        return $this->belongsTo(User::class, 'user_jury1_id');
    }

    public function jury2()
    {
        return $this->belongsTo(User::class, 'user_jury2_id');
    }

    public function jury3()
    {
        return $this->belongsTo(User::class, 'user_jury3_id');
    }

    public function jury4()
    {
        return $this->belongsTo(User::class, 'user_jury4_id');
    }

    // Relationship with Internship
    public function internship()
    {
        return $this->belongsTo(Internship::class, 'internship_id');
    }

}

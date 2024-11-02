<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'img_profile',
        'user_role_id',
    ];

    public function role()
    {
        return $this->belongsTo(UserRole::class,"user_role_id","id");
    }

    public function studentProjects()
    {
        return $this->hasMany(InternshipProject::class, 'user_student_id');
    }

    public function studentRequests()
    {
        return $this->hasMany(StudentRequest::class, 'advisor_id');
    }

    public function advisorProjects()
    {
        return $this->hasMany(InternshipProject::class, 'user_advisor_id');
    }

    public function internships()
    {
        return $this->belongsToMany(Internship::class, 'internship_participants')
                    ->withTimestamps();
    }

    
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        // 'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            // 'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Role;

class UserRolePermission extends Model
{
    use HasFactory;

    protected $table = 'user_role_permissions';

    protected $fillable = [
        'id',
        'user_id',
        'role_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function role(){
        return $this->belongsTo(UserRole::class);
    }
}

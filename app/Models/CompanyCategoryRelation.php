<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyCategoryRelation extends Model
{
    use HasFactory;

    protected $table = 'company_category_relations';

    protected $fillable = [
        'id',
        'company_id',
        'category_id',
    ];

    // Define the relationship with Company
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // Define the relationship with Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
}

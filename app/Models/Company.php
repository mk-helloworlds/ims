<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    // If the Model does not load correctly try using "Composer dump-autoload

    //  In Category.php, the function companies() is correct since a category has many companies.
    
    // In Company.php, the function should be named category() (singular) since a company belongs to one category.

    protected $fillable = [
        'id',
        'company_name',
        'company_profile',
        'category_id',
    ];

    // The Relationship:
    // One Category can have many Companies.
    // Each Company belongs to one Category.

    // Company as One
    // Category as Many

    public function category(){
        return $this->belongsTo(Category::class);
    }
}

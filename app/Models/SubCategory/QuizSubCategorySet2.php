<?php

namespace App\Models\SubCategory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizSubCategorySet2 extends Model
{
    use HasFactory;
    protected $fillable = [
        'sub_category_name',
        'sub_category_description',
        'category_id',
        'sub_category_image',
        'image_type'
    ];

    public function category()
    {
        return $this->belongsTo('App\Models\Category\QuizCategorySet2','category_id','id');
    }
}

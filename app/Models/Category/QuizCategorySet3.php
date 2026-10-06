<?php

namespace App\Models\Category;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizCategorySet3 extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'category_name',
        'category_description',
        'category_image',
        'image_type'
    ];
}

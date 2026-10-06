<?php

namespace App\Models\Quiz;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizSet3 extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_name',
        'question_content',
        'question_format_type',
        'option_format_type',
        'option_1',
        'option_2',
        'option_3',
        'option_4',
        'option_5',
        'option_6',
        'quiz_answer',
        'quiz_answer_value',
        'quiz_hint',
        'quiz_image',
        'image_type',
        'quiz_exp',
        'option_count',
        'category_id',
        'sub_category_id',
    ];
    
    public function subcategory()
    {
        return $this->belongsTo('App\Models\SubCategory\QuizSubCategorySet3','sub_category_id','id');
    }

}

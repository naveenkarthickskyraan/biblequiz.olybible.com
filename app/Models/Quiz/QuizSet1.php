<?php

namespace App\Models\Quiz;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizSet1 extends Model
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
    ];
    
    public function category()
    {
        return $this->belongsTo('App\Models\Category\QuizCategorySet1','category_id','id');
    }
}

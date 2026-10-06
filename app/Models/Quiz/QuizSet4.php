<?php

namespace App\Models\Quiz;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizSet4 extends Model
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
    ];

    public function app()
    {
        return $this->belongsTo('App\Models\App\QuizAppSet4','app_id','id');
    }
}

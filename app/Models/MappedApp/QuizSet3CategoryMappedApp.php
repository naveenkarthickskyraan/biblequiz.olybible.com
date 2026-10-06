<?php

namespace App\Models\MappedApp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizSet3CategoryMappedApp extends Model
{
    use HasFactory;

    use HasFactory;
    protected $fillable = [
        'id',
        'category_id',
        'sub_category_id',
    ];
}

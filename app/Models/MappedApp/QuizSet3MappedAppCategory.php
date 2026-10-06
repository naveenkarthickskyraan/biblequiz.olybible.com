<?php

namespace App\Models\MappedApp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizSet3MappedAppCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'category_id',
        'app_id',
    ];
}

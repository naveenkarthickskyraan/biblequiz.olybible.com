<?php

namespace App\Models\MappedApp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizSet1MappedAppCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'category_id',
        'app_id',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryQuestionModel extends Model
{
    use HasFactory;
    protected $table = 'category_question';
    protected $fillable = [
        'category_id',
        'question_id',
    ];
    public $timestamps = false;
}

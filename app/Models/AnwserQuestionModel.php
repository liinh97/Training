<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnwserQuestionModel extends Model
{
    use HasFactory;
    protected $table = 'anwser_question';
    protected $fillable = [
        'question_id',
        'anwser',
        'user_anwser_id'
    ];
}

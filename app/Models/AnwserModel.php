<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnwserModel extends Model
{
    use HasFactory;
    protected $table = 'anwser';
    protected $fillable = [
        'question_id',
        'anwser',
    ];
}

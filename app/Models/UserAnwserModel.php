<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAnwserModel extends Model
{
    use HasFactory;
    protected $table = 'user_anwser';
    protected $fillable = [
        'user_id',
        'category_id',
    ];
}

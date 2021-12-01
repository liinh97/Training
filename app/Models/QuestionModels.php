<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionModels extends Model
{
    use HasFactory;
    protected $table = 'question';
    protected $fillable = [
        'title',
        'type_checkbox',
    ];

    CONST TYPE_RADIO = 1;
    CONST TYPE_CHECK_BOX = 2;
    CONST TYPE_INPUT = 3;
    
    CONSt CHECKBOX_NAME = [
        self::TYPE_RADIO => 'Type Radio',
        self::TYPE_CHECK_BOX => 'Type CheckBox',
        self::TYPE_INPUT => 'Type Input',
    ];
}

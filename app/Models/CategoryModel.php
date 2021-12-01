<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model
{
    use HasFactory;

    protected $table = 'category';
    protected $fillable = [
        'title',
        'type',
    ];

    CONST TYPE_PUBLIC = 1;
    CONST TYPE_PRIVATE = 2;
}
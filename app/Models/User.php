<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'post_code',
        'city',
        'ward',
        'address',
        'role', 
        'note',
        'password',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    CONST PAGINATE = 7;
    CONST ADMIN = 1;
    CONST USER = 2;
    CONST ROLE_NAME = [
        self::ADMIN => 'Admin',
        self::USER => 'User',
    ];
}

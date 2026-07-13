<?php

namespace App\Models;

use MongoDB\Laravel\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    protected $connection = 'mongodb';
    protected $collection = 'users';

    protected $fillable = [
        'code',
        'name',
        'email',
        'phone',
        'photo_url',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
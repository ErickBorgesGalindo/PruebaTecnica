<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model as Eloquent;

class UserProfile extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'user_profiles';

    protected $fillable = [
        'user_id',
        'profile_id',
    ];

    protected $dates = ['created_at'];
}
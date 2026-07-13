<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model as Eloquent;

class Profile extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'profiles';

    protected $fillable = [
        'code',
        'name',
        'sections',
    ];

    protected $dates = ['created_at', 'updated_at'];
}
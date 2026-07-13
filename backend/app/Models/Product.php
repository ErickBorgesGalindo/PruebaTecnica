<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model as Eloquent;

class Product extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'products';

    protected $fillable = [
        'code',
        'name',
        'brand',
        'price',
    ];

    protected $dates = ['created_at', 'updated_at'];
}
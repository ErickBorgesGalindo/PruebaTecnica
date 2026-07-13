<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model as Eloquent;

class AuditLog extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'audit_logs';

    protected $fillable = [
        'entity_type',
        'entity_id',
        'action',
        'old_data',
        'new_data',
        'user_id',
        'user_name',
    ];

    protected $dates = ['created_at'];
}
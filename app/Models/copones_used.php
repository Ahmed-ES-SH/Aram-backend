<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class copones_used extends Model
{
    protected $fillable = [
        'user_id',
        'copone_id',
        'user_type',
        'current_usage',
        'usage_limit',
    ];
}
